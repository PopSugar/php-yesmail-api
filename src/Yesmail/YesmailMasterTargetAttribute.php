<?php
namespace Yesmail;
/**
 * YesmailMasterTargetAttribute
 *
 * A helper class for the target attribute portion of a master targeting
 *
 * @author Casey Powell <cpowell@popsugar.com>
 * @version 0.1
 * @copyright Copyright (c) 2013 Sugar Inc.
 * @link https://github.com/PopSugar/php-yesmail-api
 */
class YesmailMasterTargetAttribute extends YesmailMasterRequiredTargetAttribute {
    public $id;
    public $negation;
    public $groupedWith;
    public $logicalConnectorWithNext;

    /**
     * Construct a new YesmailMasterTargetAttribute object
     *
     * @param string $name The targeting attribute name. The valid names are the same as the ones listed in the master
     *                     targeting section of the UI.
     * @param array $values An array of values to be targeting against. They will be converted to the appropriate type
     *                      based on the attribute definition.
     * @param bool $nullable Indicates whether or not an attribute can be nullable. If no value is provided it will
     *                       default to false.
     * @param int $id A non-zero positive value that uniquely identifies a targeting attribute. The ids should be
     *                sequential and should start at 1.
     * @param string $logicalConnectorWithNext Specifies how the query should join to the next attribute. If no value
     *                                         is provided it will default to AND.
     * @param bool $negation Indicates whether or not the unary "NOT" operator should be applied to this attribute.
     *                       If no value is provided it will default to false.
     * @param string $groupedWith Provides a way to define query precedence by grouping two or more attributes together.
     * @access public
     */
    public function __construct($name, $values, $nullable, $id, $logicalConnectorWithNext = 'AND', $negation = false, $groupedWith = '') {
        if (is_int($id) === true) {
            $this->id = $id;
        } else {
            $this->id = NULL;
        }

        if (is_string($logicalConnectorWithNext) === true) {
            $this->logicalConnectorWithNext = $logicalConnectorWithNext;
        } else {
            $this->logicalConnectorWithNext = NULL;
        }

        if (is_bool($negation) === true) {
            $this->negation = $negation;
        } else {
            $this->negation = NULL;
        }

        if (is_string($groupedWith) === true) {
            $this->groupedWith = $groupedWith;
        } else {
            $this->groupedWith = NULL;
        }

        parent::__construct($name, $values, $nullable);

        return;
    }

    /**
     * Validates the target attribute
     *
     * @return bool True if the target attribute is valid, false otherwise
     * @access public
     */
    public function is_valid() {
        $ret = false ;

        if (parent::is_valid() === true) {
            if (is_null($this->id) === false && is_null($this->logicalConnectorWithNext) === false &&
                is_null($this->negation) === false && is_null($this->groupedWith) === false
            ) {
                $ret = true;
            }
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
        $ret = parent::jsonSerialize();
        $ret->id = $this->id;
        $ret->logicalConnectorWithNext = $this->logicalConnectorWithNext;
        $ret->negation = $this->negation;
        $ret->groupedWith = $this->groupedWith;

        return $ret;
    }
}
