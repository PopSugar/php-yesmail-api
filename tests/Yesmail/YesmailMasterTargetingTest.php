<?php
namespace Yesmail;
class YesmailMasterTargetingTest extends \PHPUnit_Framework_TestCase {

    public function testCreateYesmailMasterTargeting() {
        $targeting = new YesmailMasterTargeting(array(), array());
        $this->assertInstanceOf('\Yesmail\YesmailMasterTargeting', $targeting);
    }

    public function testYesmailMasterTargetingJson() {
        $requiredAttribute = new YesmailMasterRequiredTargetAttribute("name", array("value1"), false);
        $attribute = new YesmailMasterTargetAttribute("name", array("value1"), false, 1, 'AND', false, '');
        $targeting = new YesmailMasterTargeting(array($requiredAttribute), array($attribute));
        $json = '{"requiredTargetAttributes":{"requiredTargetAttributes":[{"name":"name","values":{"values":["value1"]},"nullable":false}]},"targetAttributes":[{"name":"name","values":{"values":["value1"]},"nullable":false,"id":1,"logicalConnectorWithNext":"AND","negation":false,"groupedWith":""}]}';
        $this->assertEquals($json, json_encode($targeting));
    }

    public function  testYesmailMasterTargetingValid() {
        $requiredAttribute = new YesmailMasterRequiredTargetAttribute("name", array("value1"), false);
        $attribute = new YesmailMasterTargetAttribute("name", array("value1"), false, 1, 'AND', false, '');
        $targeting = new YesmailMasterTargeting(array($requiredAttribute), array($attribute));
        $this->assertNotEmpty($targeting->requiredTargetAttributes);
        $this->assertNotEmpty($targeting->targetAttributes);
        $this->assertTrue($targeting->is_valid());
    }

    public function  testYesmailMasterTargetingRequiredTargetAttributesNotArray() {
        $requiredAttribute = new YesmailMasterRequiredTargetAttribute("name", array("value1"), false);
        $attribute = new YesmailMasterTargetAttribute("name", array("value1"), false, 1, 'AND', false, '');
        $targeting = new YesmailMasterTargeting($requiredAttribute, array($attribute));
        $this->assertEmpty($targeting->requiredTargetAttributes);
        $this->assertEmpty($targeting->targetAttributes);
        $this->assertTrue($targeting->is_valid());
    }

    public function  testYesmailMasterTargetingRequiredTargetAttributesInvalid() {
        $attribute = new YesmailMasterTargetAttribute("name", array("value1"), false, 1, 'AND', false, '');
        $targeting = new YesmailMasterTargeting(array(NULL), array($attribute));
        $this->assertEmpty($targeting->requiredTargetAttributes);
        $this->assertEmpty($targeting->targetAttributes);
        $this->assertTrue($targeting->is_valid());
    }

    public function  testYesmailMasterTargetingTargetAttributesNotArray() {
        $requiredAttribute = new YesmailMasterRequiredTargetAttribute("name", array("value1"), false);
        $attribute = new YesmailMasterTargetAttribute("name", array("value1"), false, 1, 'AND', false, '');
        $targeting = new YesmailMasterTargeting(array($requiredAttribute), $attribute);
        $this->assertEmpty($targeting->requiredTargetAttributes);
        $this->assertEmpty($targeting->targetAttributes);
        $this->assertTrue($targeting->is_valid());
    }

    public function  testYesmailMasterTargetingTargetAttributesInvalid() {
        $requiredAttribute = new YesmailMasterRequiredTargetAttribute("name", array("value1"), false);
        $targeting = new YesmailMasterTargeting(array($requiredAttribute), array(NULL));
        $this->assertEmpty($targeting->requiredTargetAttributes);
        $this->assertEmpty($targeting->targetAttributes);
        $this->assertTrue($targeting->is_valid());
    }
}
