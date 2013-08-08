<?php
namespace Yesmail;
class YesmailMasterTargetAttributeTest extends \PHPUnit_Framework_TestCase {

    public function testCreateYesmailMasterTargetAttribute() {
        $attribute = new YesmailMasterTargetAttribute("name", array("value1"), false, 1, 'AND', false, '');
        $this->assertInstanceOf('\Yesmail\YesmailMasterTargetAttribute', $attribute);
    }

    public function testYesmailMasterTargetAttributeJson() {
        $attribute = new YesmailMasterTargetAttribute("name", array("value1"), false, 1, 'AND', false, '');
        $json = '{"name":"name","values":["value1"],"nullable":false,"id":1,"logicalConnectorWithNext":"AND","negation":false,"groupedWith":""}';
        $this->assertEquals($json, json_encode($attribute));
    }

    public function testYesmailMasterTargetAttributeValid() {
        $name = 'Attribute Name';
        $values = array();
        $nullable = false;
        $id = 1;
        $logicalConnectorWithNext = 'AND';
        $negation = false;
        $groupedWith = '';
        $attribute = new YesmailMasterTargetAttribute($name, $values, $nullable, $id, $logicalConnectorWithNext, $negation, $groupedWith);
        $this->assertTrue($attribute->is_valid());
    }

    public function testYesmailMasterTargetAttributeNameInvalid() {
        $name = NULL;
        $values = array();
        $nullable = false;
        $id = 1;
        $logicalConnectorWithNext = 'AND';
        $negation = false;
        $groupedWith = '';
        $attribute = new YesmailMasterTargetAttribute($name, $values, $nullable, $id, $logicalConnectorWithNext, $negation, $groupedWith);
        $this->assertFalse($attribute->is_valid());
    }

    public function testYesmailMasterTargetAttributeValuesInvalid() {
        $name = 'Attribute Name';
        $values = array(NULL);
        $nullable = false;
        $id = 1;
        $logicalConnectorWithNext = 'AND';
        $negation = false;
        $groupedWith = '';
        $attribute = new YesmailMasterTargetAttribute($name, $values, $nullable, $id, $logicalConnectorWithNext, $negation, $groupedWith);
        $this->assertEmpty($attribute->values);
        $this->assertTrue($attribute->is_valid());
    }

    public function testYesmailMasterTargetAttributeNullableInvalid() {
        $name = 'Attribute Name';
        $values = array();
        $nullable = NULL;
        $id = 1;
        $logicalConnectorWithNext = 'AND';
        $negation = false;
        $groupedWith = '';
        $attribute = new YesmailMasterTargetAttribute($name, $values, $nullable, $id, $logicalConnectorWithNext, $negation, $groupedWith);
        $this->assertFalse($attribute->is_valid());
    }

    public function testYesmailMasterTargetAttributeIdInvalid() {
        $name = 'Attribute Name';
        $values = array();
        $nullable = false;
        $id = NULL;
        $logicalConnectorWithNext = 'AND';
        $negation = false;
        $groupedWith = '';
        $attribute = new YesmailMasterTargetAttribute($name, $values, $nullable, $id, $logicalConnectorWithNext, $negation, $groupedWith);
        $this->assertFalse($attribute->is_valid());
    }

    public function testYesmailMasterTargetAttributeLogicalConnectorWithNextInvalid() {
        $name = 'Attribute Name';
        $values = array();
        $nullable = false;
        $id = 1;
        $logicalConnectorWithNext = 'invalid-connector';
        $negation = false;
        $groupedWith = '';
        $attribute = new YesmailMasterTargetAttribute($name, $values, $nullable, $id, $logicalConnectorWithNext, $negation, $groupedWith);
        $this->assertFalse($attribute->is_valid());
    }

    public function testYesmailMasterTargetAttributeNegationInvalid() {
        $name = 'Attribute Name';
        $values = array();
        $nullable = false;
        $id = 1;
        $logicalConnectorWithNext = 'AND';
        $negation = NULL;
        $groupedWith = '';
        $attribute = new YesmailMasterTargetAttribute($name, $values, $nullable, $id, $logicalConnectorWithNext, $negation, $groupedWith);
        $this->assertFalse($attribute->is_valid());
    }

    public function testYesmailMasterTargetAttributeGroupedWithInvalid() {
        $name = 'Attribute Name';
        $values = array();
        $nullable = false;
        $id = 1;
        $logicalConnectorWithNext = 'AND';
        $negation = false;
        $groupedWith = NULL;
        $attribute = new YesmailMasterTargetAttribute($name, $values, $nullable, $id, $logicalConnectorWithNext, $negation, $groupedWith);
        $this->assertFalse($attribute->is_valid());
    }
}
