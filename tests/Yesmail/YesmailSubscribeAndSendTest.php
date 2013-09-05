<?php

namespace Yesmail;

class YesmailSubscribeAndSendTest extends \PHPUnit_Framework_TestCase {
    const DIVISION = 'Unit Test';
    const YESMAIL_TEST_URL = 'http://cseqa-services.yesmail.com/enterprise';

    public function testSubscribeAndSendRequestAccepted() {
        $client = $this->getMock('\Yesmail\CurlClient', array('post', 'get_info'), array('', ''));
        $mockData = $this->_getTestSubscribeAndSendRequestAcceptedData();
        $client->expects($this->any())
            ->method('post')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $subscription_state = "SUBSCRIBED";
        $division = self::DIVISION;
        $attributes = array('email' => 'cpowell@popsugar.com');
        $allow_resubscribe = true;
        $masterId = 123;
        $ret = $yesmail->Subscribe_And_Send($subscription_state, $division, $attributes, $allow_resubscribe, $masterId);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }


    protected function _getTestSubscribeAndSendRequestAcceptedData() {
        $ret = array ('info' => array('http_code' => 202),
                      'response' => '{
                                        "trackingId" : "11e7e380-8a8b-4487-91b3-a9f42e9eda5b",
                                        "statusCode" : "SUBMITTED",
                                        "statusMessage" : "Task has been accepted for processing",
                                        "lastUpdateTime" : "2013-07-26T22:08:33.450Z",
                                        "statusURI" : "https://API/status/11e7e380-8a8b-4487-91b3-a9f42e9eda5b",
                                        "statusNoWaitURI" : "https://API/statusNoWait/11e7e380-8a8b-4487-91b3-a9f42e9eda5b",
                                        "finalResourceURIs" : []
                                    }'
        );

        return $ret;
    }

    public function testSubscribeAndSendRequestMalformed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 400)));

        $subscription_state = "SUBSCRIBED";
        $division = self::DIVISION;
        $attributes = array('email' => 'cpowell@popsugar.com');
        $allow_resubscribe = true;
        $masterId = 0; // Master id does not exist
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $yesmail->Subscribe_And_Send($subscription_state, $division, $attributes, $allow_resubscribe, $masterId);

    }

    public function testSubscribeAndSendAuthenticationFailed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $subscription_state = "SUBSCRIBED";
        $division = self::DIVISION;
        $attributes = array('email' => 'cpowell@popsugar.com');
        $allow_resubscribe = true;
        $masterId = 123;
        $yesmail->Subscribe_And_Send($subscription_state, $division, $attributes, $allow_resubscribe, $masterId);
    }

    public function testSubscribeAndSendResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $subscription_state = "SUBSCRIBED";
        $division = self::DIVISION;
        $attributes = array('email' => 'cpowell@popsugar.com');
        $allow_resubscribe = true;
        $masterId = 123;
        $yesmail->Subscribe_And_Send($subscription_state, $division, $attributes, $allow_resubscribe, $masterId);
    }

    public function testSubscribeAndSendInternalServerError() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 500)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $subscription_state = "SUBSCRIBED";
        $division = self::DIVISION;
        $attributes = array('email' => 'cpowell@popsugar.com');
        $allow_resubscribe = true;
        $masterId = 123;
        $yesmail->Subscribe_And_Send($subscription_state, $division, $attributes, $allow_resubscribe, $masterId);
    }

    public function testSubscribeAndSendServiceTemporarilyUnavailable() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 503)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $subscription_state = "SUBSCRIBED";
        $division = self::DIVISION;
        $attributes = array('email' => 'cpowell@popsugar.com');
        $allow_resubscribe = true;
        $masterId = 123;
        $yesmail->Subscribe_And_Send($subscription_state, $division, $attributes, $allow_resubscribe, $masterId);
    }
}
