<?php
namespace Yesmail;
/**
 * YesmailListManagementSubscriberList
 *
 * A helper class for the Yesmail ListManagement API
 *
 * @author Casey Powell <cpowell@popsugar.com>
 * @version 0.1
 * @copyright Copyright (c) 2013 Sugar Inc.
 * @link https://github.com/PopSugar/php-yesmail-api
 */
class YesmailListManagementSubscriberList implements \JsonSerializable {
    public $deleteInsteadOfAppend;
    public $subscriberIds;
    public $emails;

    /**
     * Construct a new YesmailListManagementSubscriberList object
     *
     * @param bool $deleteInsteadOfAppend True indicates the specified users should be removed form the list, otherwise
     *                                    the users are added to the list.
     * @param array $subscriberIds A list of subscriberIds to act on. Either this or the emails element must be present,
     *                             mutually exclusive of each other.
     * @param array $emails A list of emails which are mapped back to subscriberIds. Either this or the subscriberIds
     *                      element must be present, , mutually exclusive of each other.

     * @access public
     */
    public function __construct($deleteInsteadOfAppend, $subscriberIds, $emails) {
        if (is_bool($deleteInsteadOfAppend) === true) {
            $this->deleteInsteadOfAppend = $deleteInsteadOfAppend;
        } else {
            $this->deleteInsteadOfAppend = NULL;
        }

        if((is_array($subscriberIds) === true && is_array($emails) === true) &&
            ((count($subscriberIds) === 0 && count($emails) === 0) ||
                (count($subscriberIds) > 0 xor count($emails) > 0))
        ){
            $this->subscriberIds = array();
            $this->emails = array();

            foreach($subscriberIds as $subscriberId) {
                if (is_int($subscriberId) === true) {
                    $this->subscriberIds[] = $subscriberId;
                } else {
                    $this->subscriberIds = array();
                    break;
                }
            }

            foreach($emails as $email) {
                if (is_string($email) === true) {
                    $this->emails[] = $email;
                } else {
                    $this->emails = array();
                }
            }
        } else {
            $this->subscriberIds = NULL;
            $this->emails = NULL;
        }

        return;
    }

    /**
     * Validates a subscriber list
     *
     * @return bool True if the subscriber list is valid, false otherwise
     * @access public
     */
    public function is_valid() {
        $ret = false;

        if (is_null($this->deleteInsteadOfAppend) === false && is_null($this->subscriberIds) === false &&
            is_null($this->emails) === false
        ) {
            $ret = true;
        }

        return $ret;
    }

    /**
     * Return a json_encode able version of the object
     *
     * @return object A version of the object that is ready for json_encode
     * @access public
     */
    public function jsonSerialize() {
        $ret = new \stdClass();

        $ret->deleteInsteadOfAppend = $this->deleteInsteadOfAppend;

        if (count($this->subscriberIds) > 0) {
            $ret->subscrberIds = $this->subscriberIds;
        }

        if (count($this->emails) > 0) {
            $ret->emails = $this->emails;
        }

        return $ret;
    }
}
