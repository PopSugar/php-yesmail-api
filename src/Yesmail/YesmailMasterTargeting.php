<?php
namespace Yesmail;

class YesmailMasterTargeting implements \JsonSerializable {
    public $requiredTargetAttributes;
    public $targetAttributes;

    /**
     * Construct a new YesmailMasterTargeting object
     *
     * @param array $requiredTargetAttributes A list of zero or more requiredTargetAttribute elements.
     * @param array $targetAttributes A repeatable element which defines the targeting expression.
     * @access public
     */
    public function __construct($requiredTargetAttributes, $targetAttributes) {
        $this->requiredTargetAttributes = array();
        $this->targetAttributes = array();

        if(is_array($requiredTargetAttributes) === true && is_array($targetAttributes) === true) {
            foreach($requiredTargetAttributes as $requiredTargetAttribute) {
                if ($requiredTargetAttribute instanceof \Yesmail\YesmailMasterRequiredTargetAttribute) {
                    $this->requiredTargetAttributes[] = $requiredTargetAttribute;
                } else {
                    $this->requiredTargetAttributes = array();
                    break;
                }
            }

            if (count($this->requiredTargetAttributes) === count($requiredTargetAttributes)) {
                foreach($targetAttributes as $targetAttribute) {
                    if ($targetAttribute instanceof \Yesmail\YesmailMasterRequiredTargetAttribute) {
                        $this->targetAttributes[] = $targetAttribute;
                    } else {
                        $this->targetAttributes = array();
                        $this->requiredTargetAttributes = array();
                        break;
                    }
                 }
            }
        }

        return;
    }

    /**
     * Validates an targeting
     *
     * @return bool True if the targeting is valid, false otherwise
     * @access public
     */
    public function is_valid() {
        return true;
    }

    /**
     * Return a json_encode able version of the object
     *
     * @return object A version of the object that is ready for json_encode
     * @access public
     */
    public function jsonSerialize() {
        $ret = new \stdClass();
        $requiredTargetAttributes = array();
        $requiredTargetAttributes['requiredTargetAttributes'] = $this->requiredTargetAttributes;
        $ret->requiredTargetAttributes = $requiredTargetAttributes;
        $ret->targetAttributes = $this->targetAttributes;

        return $ret;
    }
}
