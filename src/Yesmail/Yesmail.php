<?php
namespace Yesmail;
//require_once('YesmailMasterEnvelope.php');
//require_once('YesmailMasterTargeting.php');
/**
 * Yesmail
 *
 * A simple PHP wrapper for Yesmail
 *
 * @author Casey Powell <cpowell@popsugar.com>
 * @version 0.1
 * @copyright Copyright (c) 2013 Sugar Inc.
 * @link https://github.com/PopSugar/php-yesmail-api
 */
class Yesmail {
    /**
     * @var array A list of required elements for a Master Scheduling
     */
    public static $MasterSchedulingRequiredAttributes = array('maxRecipients', 'priority', 'deliveryStartDateTime');

    public static $MasterSchedulingOptionalAttributes = array('compileStartDateTime', 'compileBeforeDeliveryStart',
                                                                'allowMultipleDeliveries', 'deliverImmediately',
                                                                'deliveryFrequency', 'obeyDeliveryLimits'
                                                                );

    /**
     * @var string The URL of the Yesmail API
     */
    protected $_url = "https://services.yesmail.com/enterprise";

    /**
     * @var string Yesmail wrapper version
     */
    private $_version = "0.1";

    /**
     * @var object An object which provides access to HTTP methods
     */
    private $_client;

    /**
     * Construct a new Yesmail object to communicate with Enterprise web services.
     *
     * @param $client object An instance of CurlClient to handle the http processing.
     * @access public
     */
    public function __construct($client) {
        $this->_client = $client;
    }

    /**
     * Create a new subscriber.
     *
     * @param mixed $subscription_state [optional] Any of {"UNSUBSCRIBED", "SUBSCRIBED", "REFERRED"}
     * @param mixed $division [optional] The division display name. If this is specified the subscriber will be
     *                                     subscribed to this division.
     * @param array $attributes Valid attributes in the payload include any subscriber attributes defined for this
     *                          company. In order to create a subscriber, all of the attributes which comprise the
     *                          unique subscriber key for the company are required, and a valid value must be provided
     *                          for each required attribute. Attributes which are not in the unique key are optional.
     *                          NOTE: emailFormat, aka emailProgram, is an optional setting, but if it is not set, then
     *                          when editing the user in the UI it will default to TEXT.
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function Subscriber_Create($subscription_state, $division, $attributes) {
        $data = new \stdClass();

        if(is_null($subscription_state) === false) {
            $data->subscriptionState = $subscription_state;
        }

        if(is_null($division) === false) {
            $data->division = new \stdClass();
            $data->division->value = $division;
        }

        $data->attributes = new \stdClass();
        $data->attributes->attributes = array();

        foreach($attributes as $key => $value) {
            $attribute = new \stdClass();
            $attribute->name = $key;
            $attribute->value = $value;
            $data->attributes->attributes[] = $attribute;
        }

        $ret = $this->_call_api('post', "{$this->_url}/subscribers", $data);

        return $ret;
    }

    /**
     * Look up an existing subscriber.
     *
     * @param array $attributes An array of attribute to look up the subscriber with
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function Subscriber_Lookup($attributes) {
        $ret = $this->_call_api('get', "{$this->_url}/subscribers", $attributes);

        return $ret;
    }

    /**
     * Unsubscribe an existing subscriber from a division.
     *
     * @param int $uid The ID of the user to unsubscribe
     * @param string $division_name The division from which to unsubscribe the user
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function Subscriber_Unsubscribe($uid, $division_name) {
        $ret = $this->_call_api('delete', "{$this->_url}/subscribers/$uid", array('division' => $division_name));

        return $ret;
    }

    /**
     * Get the status of an outstanding request.
     *
     * @param int $guid The trackingId of the request to get status for
     * @param bool $nowait True if we should return without blocking. False if we should block until the request
     *                     reaches a completed state.
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function Status_Get($guid, $nowait = true) {

        if ($nowait === true) {
            $ret = $this->_call_api('get', "{$this->_url}/statusNoWait/$guid", array());
        } else {
            $ret = $this->_call_api('get', "{$this->_url}/status/$guid", array());
        }

        return $ret;
    }

    /**
     * Create a new Master
     *
     * @param object $envelope The envelope to use for the new master
     * @param mixed $targeting [optional] Optional targeting parameters to use for the new master
     * @param mixed $scheduling [optional] Optional scheduling parameters to use for the new master
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function Master_Create($envelope, $targeting, $scheduling) {
        $ret = false;

        $data = $this->_package_master_elements($envelope, $targeting, $scheduling);
        if ($data !== false) {
            $ret = $this->_call_api('post', "{$this->_url}/masters", $data);
        }

        return $ret;
    }

    /**
     * Update an existing Master
     *
     * @param int $masterId The id of the master to update
     * @param object $envelope The envelope to use for the new master
     * @param mixed $targeting [optional] Optional targeting parameters to use for the new master
     * @param mixed $scheduling [optional] Optional scheduling parameters to use for the new master
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function Master_Update($masterId, $envelope, $targeting, $scheduling) {
        $ret = false;

        $data = $this->_package_master_elements($envelope, $targeting, $scheduling);
        if ($data !== false) {
            $data->masterId = $masterId;
            $ret = $this->_call_api('post', "{$this->_url}/masters", $data);
        }

        return $ret;
    }

    /**
     * Get an existing Master
     *
     * @param int $masterId The id of the master to retrieve
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function Master_Get($masterId) {
        $ret = false;

        if (is_int($masterId) === true) {
            $ret = $this->_call_api('get', "{$this->_url}/masters/$masterId", array());
        }

        return $ret;
    }

    /**
     * Get an existing Master by name
     *
     * @param int $masterName The name of the master to retrieve
     * @return mixed A JSON decoded PHP variable representing the HTTP response, or false if the master is not found
     * @access public
     */
    public function Master_Get_By_Name($masterName) {
        $ret = false;

        if (is_string($masterName) === true) {
            $pageSize = 50;
            $begin = 1;
            $end = $pageSize;
            $filter = 'active';
            $more = true;
            while($more) {
                $res = $this->_call_api('get', "{$this->_url}/masters", array('begin' => $begin, 'end' => $end,
                                                                              'filter' => $filter));
                foreach($res->masters as $result) {
                    if ($result->masterName === $masterName) {
                        $ret = $result;
                        break;
                    }
                }

                $more = ($ret === false && count($res->masters) === $pageSize ? true : false);
                $begin += $pageSize;
                $end += $pageSize;
            }
        }

        return $ret;
    }

    /**
     * Get the assets that belong to a Master
     *
     * @param int $masterId The id of the master who's assets are being requested
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function Master_Assets_Get($masterId) {
        $ret = false;

        if (is_int($masterId) === true) {
            $ret = $this->_call_api('get', "{$this->_url}/masters/$masterId/assets", array());
        }

        return $ret;
    }

    /**
     * Add new asset(s) to a Master
     *
     * @param int $masterId The id of the master to add the asset(s) to
     * @param string $assetName Valid file extensions are: .txt, .html, .htm, .gif, .jpg, .png, or .zip
     * @param string $assetBase64Data Should be a base-64 encoded string of the content or archive (zip file) being uploaded.
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function Master_Asset_Add($masterId, $assetName, $assetBase64Data) {
        $ret = false;

        if (is_int($masterId) === true && is_string($assetName) === true && is_string($assetBase64Data) === true) {
            $data = array('assetName' => $assetName , 'assetBase64Data' => $assetBase64Data);
            $ret = $this->_call_api('post', "{$this->_url}/masters/$masterId/assets", $data);
        }

        return $ret;
    }

    /**
     * Delete an asset from a Master
     *
     * @param int $masterId The id of the master to delete the asset from
     * @param string $assetName The name of the asset to delete
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function Master_Asset_Delete($masterId, $assetName) {
        $ret = $this->_call_api('delete', "{$this->_url}/masters/$masterId/assets/$assetName", array());

        return $ret;
    }

    /**
     * Get a list of lists given a list type
     *
     * @param string $type The type of lists to get. Should be either LISTLOADLIST or DISTRIBUTIONLIST
     * @return mixed A JSON decoded PHP variable representing the HTTP response
     */
    public function ListManagement_Get_Lists($type) {
        $ret = false;

        if (is_string($type) === true) {
            $type = rawurlencode($type);
            $ret = $this->_call_api('get', "{$this->_url}/lists/$type", array());
        }

        return $ret;
    }

    /**
     * Get a quick summary of the list: its name, type, subtype if relevant, resource uri, and its list id.
     *
     * @param string $name The name of the list to get.
     * @param string $type The type of list to get. Should be either LISTLOADLIST or DISTRIBUTIONLIST.

     * @return mixed A JSON decoded PHP variable representing the HTTP response
     */
    public function ListManagement_Get_List($name, $type) {
        $ret = false;

        if (is_string($name) === true && is_string($type) === true) {
            $name = rawurlencode($name);
            $type = rawurlencode($type);
            $ret = $this->_call_api('get', "{$this->_url}/lists/$type/$name", array());
        }

        return $ret;
    }

    /**
     * Either remove or append the subscribers identified in the payload. For subscriberIds and emails that are
     * submitted as part of a request that cannot be mapped back to existing subscriber data are ignored and a total
     * count of the number added users is returned as part of the status message.
     *
     * @param object $modifyList
     * @return mixed A JSON decoded PHP variable representing the HTTP response
     */
    public function ListManagement_Update_List($modifyList) {
        $ret = false;

        if ($modifyList instanceof YesmailListManagementModifyList && $modifyList->is_valid() === true) {
            $name = rawurlencode($modifyList->name);
            $type = rawurlencode($modifyList->type);
            $ret = $this->_call_api('put', "{$this->_url}/lists/$type/$name", $modifyList->subscriberList);
        }

        return $ret;
    }

    /**
     * Create a new list of the given type
     *
     * @param object $modifyList
     * @return mixed A JSON decoded PHP variable representing the HTTP response
     */
    public function ListManagement_Create_List($modifyList) {
        $ret = false;

        if ($modifyList instanceof YesmailListManagementModifyList && $modifyList->is_valid() === true) {
            $ret = $this->_call_api('post', "{$this->_url}/lists/{$modifyList->type}", $modifyList);
        }

        return $ret;
    }

    /**
     * Package a Master's envelope, targeting, and scheduling for sending in a request
     *
     * @param object $envelope The Master's envelope
     * @param mixed $targeting [optional] Optional targeting parameters for the new master
     * @param mixed $scheduling [optional] Optional scheduling parameters for the new master
     * @return mixed Either a stdClass object containing the Master's elements, or false upon failure
     */

    protected function _package_master_elements($envelope, $targeting, $scheduling) {
        $ret = false;

        if ($envelope instanceof YesmailMasterEnvelope && $envelope->is_valid() === true) {
            $ret = new \stdClass();
            $ret->envelope = $envelope;

            if ($targeting instanceof YesmailMasterTargeting && $targeting->is_valid() === true) {
                $ret->targeting = $targeting;
            }

            if ($scheduling instanceof YesmailMasterScheduling && $scheduling->is_valid() === true) {
                $ret->scheduling = $scheduling;
            }
        }

        return $ret;
    }
    /**
     * Make a call to the Yesmail API
     *
     * @param string $method Any of {'get', 'put', 'post', 'delete'}
     * @param string $url The url of the API call
     * @param mixed $params An object or array of parameters to submit in the request
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access protected
     * @throws Exception
     */
    protected function _call_api( $method, $url, $params ) {
        $raw_response = $this->_client->$method($url, $params);
        $info = $this->_client->get_info();
        if ($info['http_code'] != null) {
            switch ($info["http_code"]) {
                case 200:
                case 202:
                    $response = json_decode($raw_response);
                    break;
                    /*
                case 400:
                    throw new MalformedRequestException();
                case 401:
                    throw new AuthenticationFailedException();
                case 404:
                    throw new ResourceNotFoundException();
                case 500:
                    throw new InternalServerErrorException();
                case 503:
                    throw new ServiceTemporarilyUnavailableException();
                    */
                default:
                    throw new \Exception("Error: {$info['http_code']}");
            }
        }

        return $response;
    }
}
