<?php
namespace Yesmail;
/**
 * YesmailMasterRequiredTargetAttribute
 *
 * A helper class for the required target attribute portion of a master targeting
 *
 * @author Casey Powell <cpowell@popsugar.com>
 * @version 0.1
 * @copyright Copyright (c) 2013 Sugar Inc.
 * @link https://github.com/PopSugar/php-yesmail-api
 */
class YesmailMasterRequiredTargetAttribute implements \JsonSerializable {
    public $name;
    public $values;
    public $nullable;

    /**
     * Construct a new YesmailMasterRequiredTargetAttribute object
     *
     * @param string $name The targeting attribute name. The valid names are the same as the ones listed in the master
     *                     targeting section of the UI.
     * @param array $values An array of values to be targeting against. They will be converted to the appropriate type
     *                      based on the attribute definition.
     * @param bool $nullable Indicates whether or not an attribute can be nullable. If no value is provided it will
     *                       default to false.
     * @access public
     */
    public function __construct($name, $values, $nullable = false) {
        if (is_string($name) === true) {
            $this->name = $name;
        } else {
            $this->name = NULL;
        }

        $this->values = array();

        if(is_array($values) === true) {
            foreach($values as $value) {
                if (is_string($value) === true) {
                    $this->values[] = $value;
                } else {
                    $this->values = array();
                    break;
                }
            }
        }

        if (is_bool($nullable) ===true) {
            $this->nullable = $nullable;
        }

        return;
    }

    /**
     * Validates the target attribute
     *
     * @return bool True if the target attribute is valid, false otherwise
     * @access public
     */
    public function is_valid() {
        $ret = false;

        if(is_null($this->name) === false && is_null($this->nullable) === false) {
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

        if(count($this->values) > 0) {
            $ret->values = $this->values;
        }

        $ret->nullable = $this->nullable;

        return $ret;
    }
}
