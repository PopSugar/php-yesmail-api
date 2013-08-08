<?php
namespace Yesmail;
class YesmailListManagementModifyListTest extends \PHPUnit_Framework_TestCase {

    public function testCreateYesmailListManagementModifyList() {
        $name = 'List';
        $type = 'DISTRIBUTIONLIST';
        $subtype = 'SEEDLIST';
        $subscriberList = $this->getMock('\Yesmail\YesmailListManagementSubscriberList', array('is_valid'), array(),
            'MyYesmailListManagementSubscriberList', false);
        $subscriberList->expects($this->any())
            ->method('is_valid')
            ->will($this->returnValue(true));
        $modifyList = new YesmailListManagementModifyList($name, $type, $subtype, $subscriberList);
        $this->assertInstanceOf('\Yesmail\YesmailListManagementModifyList', $modifyList);
    }

    public function testYesmailListManagementModifyListJson() {
        unset($subscriberList);
        unset($modifyList);
        $name = 'List';
        $type = 'DISTRIBUTIONLIST';
        $subtype = 'SEEDLIST';
        $subscriberList = $this->getMock('\Yesmail\YesmailListManagementSubscriberList', array('is_valid', 'jsonSerialize'), array(),
            'MyYesmailListManagementSubscriberList2', false);
        $subscriberList->expects($this->any())
            ->method('is_valid')
            ->will($this->returnValue(true));

        $subscriberList->expects($this->any())
            ->method('jsonSerialize')
            ->will($this->returnValue(new \stdClass()));
        $modifyList = new YesmailListManagementModifyList($name, $type, $subtype, $subscriberList);

        $json = '{"name":"List","type":"DISTRIBUTIONLIST","subtype":"SEEDLIST","subscriberList":{}}';
        $this->assertEquals($json, json_encode($modifyList));
    }

    public function testYesmailListManagementModifyListValid() {
        $name = 'List';
        $type = 'DISTRIBUTIONLIST';
        $subtype = 'SEEDLIST';
        $subscriberList = $this->getMock('\Yesmail\YesmailListManagementSubscriberList', array('is_valid'), array(),
            'MyYesmailListManagementSubscriberList', false);
        $subscriberList->expects($this->any())
            ->method('is_valid')
            ->will($this->returnValue(true));
        $modifyList = new YesmailListManagementModifyList($name, $type, $subtype, $subscriberList);
        $this->assertTrue($modifyList->is_valid());
    }

    public function testYesmailListManagementModifyListNameInvalid() {
        $name = NULL;
        $type = 'DISTRIBUTIONLIST';
        $subtype = 'SEEDLIST';
        $subscriberList = $this->getMock('\Yesmail\YesmailListManagementSubscriberList', array('is_valid'), array(),
            'MyYesmailListManagementSubscriberList', false);
        $subscriberList->expects($this->any())
            ->method('is_valid')
            ->will($this->returnValue(true));
        $modifyList = new YesmailListManagementModifyList($name, $type, $subtype, $subscriberList);
        $this->assertFalse($modifyList->is_valid());
    }

    public function testYesmailListManagementModifyListTypeInvalid() {
        $name = 'List';
        $type = 'invalid-type';
        $subtype = 'SEEDLIST';
        $subscriberList = $this->getMock('\Yesmail\YesmailListManagementSubscriberList', array('is_valid'), array(),
            'MyYesmailListManagementSubscriberList', false);
        $subscriberList->expects($this->any())
            ->method('is_valid')
            ->will($this->returnValue(true));
        $modifyList = new YesmailListManagementModifyList($name, $type, $subtype, $subscriberList);
        $this->assertFalse($modifyList->is_valid());
    }

    public function testYesmailListManagementModifyListSubtypeInvalid() {
        $name = 'List';
        $type = 'DISTRIBUTIONLIST';
        $subtype = 'invalid-subtype';
        $subscriberList = $this->getMock('\Yesmail\YesmailListManagementSubscriberList', array('is_valid'), array(),
            'MyYesmailListManagementSubscriberList', false);
        $subscriberList->expects($this->any())
            ->method('is_valid')
            ->will($this->returnValue(true));
        $modifyList = new YesmailListManagementModifyList($name, $type, $subtype, $subscriberList);
        $this->assertFalse($modifyList->is_valid());
    }

    public function testYesmailListManagementModifyListSubtypeInvalidOptional() {
        $name = 'List';
        $type = 'LISTLOADLIST';
        $subtype = 'invalid-subtype';
        $subscriberList = $this->getMock('\Yesmail\YesmailListManagementSubscriberList', array('is_valid'), array(),
            'MyYesmailListManagementSubscriberList', false);
        $subscriberList->expects($this->any())
            ->method('is_valid')
            ->will($this->returnValue(true));
        $modifyList = new YesmailListManagementModifyList($name, $type, $subtype, $subscriberList);
        $this->assertTrue($modifyList->is_valid());
    }

    public function testYesmailListManagementModifyListSubscriberListInvalid() {
        $name = 'List';
        $type = 'DISTRIBUTIONLIST';
        $subtype = 'SEEDLIST';
        $subscriberList = $this->getMock('\Yesmail\YesmailListManagementSubscriberList', array('is_valid'), array(),
            'MyYesmailListManagementSubscriberList', false);
        $subscriberList->expects($this->any())
            ->method('is_valid')
            ->will($this->returnValue(false));
        $modifyList = new YesmailListManagementModifyList($name, $type, $subtype, $subscriberList);
        $this->assertFalse($modifyList->is_valid());
    }

    public function testYesmailListManagementModifyListSubscriberListNotObject() {
        $name = 'List';
        $type = 'DISTRIBUTIONLIST';
        $subtype = 'SEEDLIST';
        $subscriberList = NULL;
        $modifyList = new YesmailListManagementModifyList($name, $type, $subtype, $subscriberList);
        $this->assertFalse($modifyList->is_valid());
    }
}
