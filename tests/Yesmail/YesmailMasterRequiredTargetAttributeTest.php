<?php
namespace Yesmail;
class YesmailMasterRequiredTargetAttributeTest extends \PHPUnit_Framework_TestCase {

    public function testCreateYesmailMasterRequiredTargetAttribute() {
        $attribute = new YesmailMasterRequiredTargetAttribute("name", array("value1"), false);
        $this->assertInstanceOf('\Yesmail\YesmailMasterRequiredTargetAttribute', $attribute);
    }

    public function testYesmailMasterRequiredTargetAttributeJson() {
        $attribute = new YesmailMasterRequiredTargetAttribute("name", array("value1"), false);
        $this->assertEquals('{"name":"name","values":["value1"],"nullable":false}', json_encode($attribute));
    }

    public function testYesmailMasterRequiredTargetAttributeValid() {
        $name = 'Required Attribute Name';
        $values = array();
        $nullable = false;
        $attribute = new YesmailMasterRequiredTargetAttribute($name, $values, $nullable);
        $this->assertTrue($attribute->is_valid());
    }

    public function testYesmailMasterRequiredTargetAttributeNameInvalid() {
        $name = NULL;
        $values = array();
        $nullable = false;
        $attribute = new YesmailMasterRequiredTargetAttribute($name, $values, $nullable);
        $this->assertFalse($attribute->is_valid());
    }

    public function testYesmailMasterRequiredTargetAttributeValuesInvalid() {
        $name = 'Required Attribute Name';
        $values = array(NULL);
        $nullable = false;
        $attribute = new YesmailMasterRequiredTargetAttribute($name, $values, $nullable);
        $this->assertEmpty($attribute->values);
        $this->assertTrue($attribute->is_valid());
    }

    public function testYesmailMasterRequiredTargetAttributeNullableInvalid() {
        $name = 'Required Attribute Name';
        $values = array();
        $nullable = NULL;
        $attribute = new YesmailMasterRequiredTargetAttribute($name, $values, $nullable);
        $this->assertFalse($attribute->is_valid());
    }
}
