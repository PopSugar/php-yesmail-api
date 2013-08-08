<?php
namespace Yesmail;
/**
 * YesmailListManagementModifyList
 *
 * A helper class for the Yesmail ListManagement API
 *
 * @author Casey Powell <cpowell@popsugar.com>
 * @version 0.1
 * @copyright Copyright (c) 2013 Sugar Inc.
 * @link https://github.com/PopSugar/php-yesmail-api
 */
class YesmailListManagementModifyList implements \JsonSerializable {
    /**'
     * @var array An array of supported list types
     */
    public static $ListManagementListTypes = array('LISTLOADLIST', 'DISTRIBUTIONLIST');

    /**
     * @var array An array of supported list subtypes. Only used for type = DISTRIBUTIONLIST
     */
    public static $listManagementListSubTypes = array('SEEDLIST', 'TESTGROUP');

    // Required
    public $name;
    public $type;
    public $subscriberList;

    // Optional
    public $subtype;

    /**
     * Construct a new YesmailListManagementModifyList object
     *
     * @param string $name The name of the list, must be unique for its list type and match the name in the URL.
     * @param string $type Must match the type specified in the URL and be either LISTLOADLIST or DISTRIBUTIONLIST
     * @param string $subtype Only used for type = DISTRIBUTIONLIST. Must be either SEEDLIST or TESTGROUP
     * @param object $subscriberList Specify the users to add to the list, this element is still required even if the
     *                               list is intended to be empty upon creation.

     * @access public
     */
    public function __construct($name, $type, $subtype, $subscriberList) {
        if (is_string($name) === true) {
            $this->name = $name;
        } else {
            $this->name = NULL;
        }

        if (in_array($type, self::$ListManagementListTypes) === true) {
            $this->type = $type;
        } else {
            $this->type = NULL;
        }

        if ($this->type === 'DISTRIBUTIONLIST' && is_string($subtype) === true &&
            in_array($subtype, self::$listManagementListSubTypes) === true) {
            $this->subtype = $subtype;
        } else {
            $this->subtype = NULL;
        }

        if ($subscriberList instanceof YesmailListManagementSubscriberList && $subscriberList->is_valid() === true) {
            $this->subscriberList = $subscriberList;
        } else {
            $this->subscriberList = NULL;
        }

        return;
    }

    /**
     * Validates a modify list
     *
     * @return bool True if the modify list is valid, false otherwise
     * @access public
     */
    public function is_valid() {
        $ret = false;

        if (is_null($this->name) === false && is_null($this->type) === false &&
            (is_null($this->subtype) === false || $this->type !== 'DISTRIBUTIONLIST') &&
            is_null($this->subscriberList) === false
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

        $ret->name = $this->name;
        $ret->type = $this->type;

        if (is_null($this->subtype) === false) {
            $ret->subtype = $this->subtype;
        }

        $ret->subscriberList = $this->subscriberList;

        return $ret;
    }
}
