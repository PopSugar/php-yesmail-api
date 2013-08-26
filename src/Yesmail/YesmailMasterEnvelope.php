<?php
namespace Yesmail;
/**
 * YesmailMasterEnvelope
 *
 * A helper class for the envelope Master element
 *
 * @author Casey Powell <cpowell@popsugar.com>
 * @version 0.1
 * @copyright Copyright (c) 2013 Sugar Inc.
 * @link https://github.com/PopSugar/php-yesmail-api
 */
class YesmailMasterEnvelope implements \JsonSerializable {

    /**
     * @var array A list of supported encodings
     */
    public static $MasterEnvelopeEncodings = array('UTF-8', 'ISO-8859-1', 'ISO-8859-15', 'SJIS', 'ISO-2022-JP', 'EUC-JP',
                                                    'ISO-8859-5', 'ISO-2022-CN-GB', 'ISO-2022-CN-CNS', 'EUC-CN,GBK',
                                                    'BIG5', 'CP1252', 'KSC5601', 'ISO-2022-KR', 'ISO-8859-8');

    /**
     * @var array A list of supported delivery types
     */
    public static $MasterEnvelopeDeliveryType = array('AUTODETECT', 'NORMAL', 'HTML_AND_TEXT');

    // Required
    public $masterName;
    public $fromName;
    public $fromDomain;
    public $division;
    public $encoding;
    public $subject;

    // Optional
    public $deliveryType;
    public $friendlyFrom;
    public $description;
    public $campaign;
    public $keywords;
    public $seedLists;

    /**
     * Construct a new YesmailMasterEnvelope object
     *
     * @param string $masterName This is the name of the master and must be unique.
     * @param string $fromName This is the From name in the email address. It must be a valid name defined for the company.
     * @param string $fromDomain This is the domain of the company. It must be a valid domain defined for the company.
     * @param string $division This is the division name.
     * @param string $encoding The encoding type
     * @param string $subject This is the subject line of the email.
     * @param string $deliveryType [optional] AUTODETECT - requires html and text content.
     *                                        NORMAL - requires text content.
     *                                        HTML_AND_TEXT - requires html and text content.
     * @param string $friendlyFrom [optional] This is the display name in the from address.
     * @param string $description [optional] A description of the message master (not seen by recipients).
     * @param string $campaign [optional] Campaign associated with the message master.
     * @param array $keywords [optional] Specific keywords for the master. It contains one or more keywords.
     * @param array $seedLists [optional] Seed lists for the master. It contains one or more seedLists.
     * @access public
     */
    public function __construct($masterName, $fromName, $fromDomain, $division, $encoding, $subject,
                                $deliveryType = 'AUTODETECT', $friendlyFrom = '', $description = '', $campaign = '',
                                $keywords = array(), $seedLists = array()) {

        $this->masterName = (is_string($masterName) === true ? $masterName : NULL);
        $this->fromName = (is_string($fromName) === true ? $fromName : NULL);
        $this->fromDomain = (is_string($fromDomain) === true ? $fromDomain : NULL);
        $this->division = (is_string($division) === true ? $division : NULL);
        $this->encoding = (in_array($encoding, self::$MasterEnvelopeEncodings) === true ? $encoding : NULL);
        $this->subject = (is_string($subject) === true ? $subject : NULL);
        $this->deliveryType = (is_string($deliveryType) === true ? $deliveryType : NULL);
        $this->friendlyFrom = (is_string($friendlyFrom) === true ? $friendlyFrom : NULL);
        $this->description = (is_string($description) === true ? $description : NULL);
        $this->campaign = (is_string($campaign) === true ? $campaign : NULL);

        $this->keywords = array();
        if (is_array($keywords) === true) {
            foreach($keywords as $keyword) {
                if (is_string($keyword) === true) {
                    $this->keywords[] = $keyword;
                } else {
                    $this->keywords = array();
                    break;
                }
            }
        }

        $this->seedLists = array();
        if (is_array($seedLists) === true) {
            foreach($seedLists as $seedList) {
                if (is_string($seedList) === true) {
                    $this->seedLists[] = $seedList;
                } else {
                    $this->seedLists = array();
                    break;
                }
            }
        }

        return;
    }

    /**
     * Validates an envelope
     *
     * @return bool True if the envelope is valid, false otherwise
     * @access public
     */
    public function is_valid() {
        $ret = false;

        if (is_null($this->masterName) === false && is_null($this->fromName) === false &&
            is_null($this->fromDomain) === false && is_null($this->division) === false &&
            is_null($this->encoding) === false && is_null($this->subject) === false &&
            is_null($this->deliveryType) === false && is_null($this->friendlyFrom) === false &&
            is_null($this->description) === false && is_null($this->campaign) === false
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

        $ret->masterName = $this->masterName;
        $ret->fromName = $this->fromName;
        $ret->fromDomain = $this->fromDomain;
        $ret->division = $this->division;
        $ret->encoding = $this->encoding;
        $ret->subject = $this->subject;
        $ret->deliveryType = $this->deliveryType;
        $ret->friendlyFrom = $this->friendlyFrom;
        $ret->description = $this->description;
        $ret->campaign = $this->campaign;

        if (count($this->keywords) > 0) {
            $keywords = array();
            $keywords['keywords'] = $this->keywords;
            $ret->keywords = $keywords;
        }

        if (count($this->seedLists) > 0) {
            $seedLists = array();
            $seedLists['seedLists'] = $this->seedLists;
            $ret->seedLists = $seedLists;
        }

        return $ret;
    }
}
