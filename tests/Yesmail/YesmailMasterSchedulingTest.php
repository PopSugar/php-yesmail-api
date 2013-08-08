<?php
namespace Yesmail;
class YesmailMasterSchedulingTest extends \PHPUnit_Framework_TestCase {
    public function testCreateYesmailMasterScheduling() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertInstanceOf('\Yesmail\YesmailMasterScheduling', $scheduling);
    }

    public function testYesmailMasterSchedulingJson() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $json = '{"maxRecipients":1,"priority":50,"deliveryStartDateTime":"2013-08-02T08:49:00","compileStartDateTime":"2013-08-02T08:49:00","compileBeforeDeliveryStart":false,"allowMultipleDeliveries":false,"deliverImmediately":true,"deliveryFrequency":"ONCE","obeyDeliveryLimits":true}';
        $this->assertEquals($json, json_encode($scheduling));
    }

    public function testMasterSchedulingValid() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertTrue($scheduling->is_valid());
    }

    public function testMasterSchedulingMaxRecipientsInvalid() {
        $maxRecipients = 0;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);$this->assertFalse($scheduling->is_valid());
        $this->assertFalse($scheduling->is_valid());
    }

    public function testMasterSchedulingPriorityLowerBoundValid() {
        $maxRecipients = 1;
        $priority = 1;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertTrue($scheduling->is_valid());
    }

    public function testMasterSchedulingPriorityLowerBoundInvalid() {
        $maxRecipients = 1;
        $priority = 0;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertFalse($scheduling->is_valid());
    }

    public function testMasterSchedulingPriorityUpperBoundValid() {
        $maxRecipients = 1;
        $priority = 100;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertTrue($scheduling->is_valid());
    }

    public function testMasterSchedulingPriorityUpperBoundInvalid() {
        $maxRecipients = 1;
        $priority = 101;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertFalse($scheduling->is_valid());
    }

    public function testMasterSchedulingDeliveryStartDateTimeValid() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = false;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);

        $this->assertTrue($scheduling->is_valid());
    }

    public function testMasterSchedulingDeliveryStartDateTimeInvalid() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = false;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);

        $this->assertFalse($scheduling->is_valid());
    }

    public function testMasterSchedulingDeliveryStartDateTimeInvalidButOptional() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);

        $this->assertTrue($scheduling->is_valid());
    }

    public function testMasterSchedulingCompileStartDateTimeEqualDeliveryStartDateTimeValid() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = true;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertTrue($scheduling->is_valid());
    }

    public function testMasterSchedulingCompileStartDateTimeBeforeDeliveryStartDateTimeValid() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:48:59';
        $compileBeforeDeliveryStart = true;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertTrue($scheduling->is_valid());
    }

    public function testMasterSchedulingCompileStartDateTimeInvalid() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '';
        $compileBeforeDeliveryStart = true;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertFalse($scheduling->is_valid());
    }

    public function testMasterSchedulingCompileStartDateTimeAfterDeliveryStartDateTimeInvalid() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:01';
        $compileBeforeDeliveryStart = true;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertFalse($scheduling->is_valid());
    }

    public function testMasterSchedulingCompileBeforeDeliveryStartInvalid() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = NULL;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertFalse($scheduling->is_valid());
    }

    public function testMasterSchedulingAllowMultipleDeliveriesInvalid() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = NULL;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = true;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertFalse($scheduling->is_valid());
    }

    // TODO: deliveryFrequency tests

    public function testMasterSchedulingSubjectInvalid() {
        $maxRecipients = 1;
        $priority = 50;
        $deliveryStartDateTime = '2013/08/02 08:49:00';
        $compileStartDateTime = '2013/08/02 08:49:00';
        $compileBeforeDeliveryStart = false;
        $allowMultipleDeliveries = false;
        $deliverImmediately = true;
        $deliveryFrequency = 'ONCE';
        $obeyDeliveryLimits = NULL;
        $scheduling = new YesmailMasterScheduling($maxRecipients, $priority, $deliveryStartDateTime,
                                                    $compileStartDateTime, $compileBeforeDeliveryStart,
                                                    $allowMultipleDeliveries, $deliverImmediately, $deliveryFrequency,
                                                    $obeyDeliveryLimits);
        $this->assertFalse($scheduling->is_valid());
    }
}
