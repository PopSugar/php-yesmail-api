<?php
namespace Yesmail;
class YesmailListManagementSubscriberListTest extends \PHPUnit_Framework_TestCase {

    public function testCreateYesmailListManagementSubscriberList() {
        $deleteInsteadOfAppend = true;
        $subscriberIds = array(1, 2, 3);
        $emails = array();
        $subscriberList = new YesmailListManagementSubscriberList($deleteInsteadOfAppend, $subscriberIds, $emails);
        $this->assertInstanceOf('\Yesmail\YesmailListManagementSubscriberList', $subscriberList);
    }

    public function testYesmailListManagementSubscriberListSubscriberIdsJson() {
        $deleteInsteadOfAppend = true;
        $subscriberIds = array(1, 2, 3);
        $emails = array();
        $subscriberList = new YesmailListManagementSubscriberList($deleteInsteadOfAppend, $subscriberIds, $emails);
        $json = '{"deleteInsteadOfAppend":true,"subscrberIds":[1,2,3]}';
        $this->assertEquals($json, json_encode($subscriberList));
    }

    public function testYesmailListManagementSubscriberListEmailsJson() {
        $deleteInsteadOfAppend = true;
        $subscriberIds = array();
        $emails = array('john@doe.com', 'jane@doe.com');
        $subscriberList = new YesmailListManagementSubscriberList($deleteInsteadOfAppend, $subscriberIds, $emails);
        $json = '{"deleteInsteadOfAppend":true,"emails":["john@doe.com","jane@doe.com"]}';
        $this->assertEquals($json, json_encode($subscriberList));
    }

    public function testYesmailListManagementSubscriberListSubscriberIdsValid() {
        $deleteInsteadOfAppend = true;
        $subscriberIds = array(1, 2, 3);
        $emails = array();
        $subscriberList = new YesmailListManagementSubscriberList($deleteInsteadOfAppend, $subscriberIds, $emails);
        $this->assertTrue($subscriberList->is_valid());
    }

    public function testYesmailListManagementSubscriberListEmailsValid() {
        $deleteInsteadOfAppend = true;
        $subscriberIds = array();
        $emails = array('john@doe.com', 'jane@doe.com');
        $subscriberList = new YesmailListManagementSubscriberList($deleteInsteadOfAppend, $subscriberIds, $emails);
        $this->assertTrue($subscriberList->is_valid());
    }

    public function testYesmailListManagementSubscriberListDeleteInsteadOfAppendInvalid() {
        $deleteInsteadOfAppend = NULL;
        $subscriberIds = array(1, 2, 3);
        $emails = array();
        $subscriberList = new YesmailListManagementSubscriberList($deleteInsteadOfAppend, $subscriberIds, $emails);
        $this->assertFalse($subscriberList->is_valid());
    }

    public function testYesmailListManagementSubscriberListSubscriberIdsInvalid() {
        $deleteInsteadOfAppend = true;
        $subscriberIds = NULL;
        $emails = array();
        $subscriberList = new YesmailListManagementSubscriberList($deleteInsteadOfAppend, $subscriberIds, $emails);
        $this->assertFalse($subscriberList->is_valid());
    }

    public function testYesmailListManagementSubscriberListEmailsInvalid() {
        $deleteInsteadOfAppend = true;
        $subscriberIds = array(1, 2, 3);
        $emails = NULL;
        $subscriberList = new YesmailListManagementSubscriberList($deleteInsteadOfAppend, $subscriberIds, $emails);
        $this->assertFalse($subscriberList->is_valid());
    }

    public function testYesmailListManagementSubscriberListNoSubscriberIdsNoEmails() {
        $deleteInsteadOfAppend = true;
        $subscriberIds = array();
        $emails = array();
        $subscriberList = new YesmailListManagementSubscriberList($deleteInsteadOfAppend, $subscriberIds, $emails);
        $this->assertTrue($subscriberList->is_valid());
    }

    public function testYesmailListManagementSubscriberListBothSubscriberIdsAndEmails() {
        $deleteInsteadOfAppend = true;
        $subscriberIds = array(1, 2, 3);
        $emails = array('john@doe.com', 'jane@doe.com');
        $subscriberList = new YesmailListManagementSubscriberList($deleteInsteadOfAppend, $subscriberIds, $emails);
        $this->assertFalse($subscriberList->is_valid());
    }
}
