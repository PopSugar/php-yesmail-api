<?php
namespace Yesmail;

class YesmailTest extends \PHPUnit_Framework_TestCase {
    const DIVISION = 'Test Division';
    const YESMAIL_TEST_URL = 'http://cseqa-services.yesmail.com/enterprise';

    public function testCreateYesmail() {
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $this->assertInstanceOf('\Yesmail\Yesmail', $yesmail);
    }

    public function testSubscriberCreateRequestAccepted() {
        $client = $this->getMock('\Yesmail\CurlClient', array('post', 'get_info'), array('', ''));
        $mockData = $this->_getTestSubscriberCreateRequestAcceptedData();
        $client->expects($this->any())
            ->method('post')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $division = self::DIVISION;
        $ret = $yesmail->Subscriber_Create('SUBSCRIBED', $division, array('email' => 'cpowell@popsugar.com'));
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestSubscriberCreateRequestAcceptedData() {
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

    public function testSubscriberCreateRequestMalformed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 400)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $division = self::DIVISION;
        $yesmail->Subscriber_Create('SUBSCRIBED', $division, array('email' => 'cpowell@popsugar.com'));
    }

    public function testSubscriberCreateAuthenticationFailed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('post', 'get_info'), array('', ''));
        $mockData = $this->_getTestSubscriberCreateAuthenticationFailedData();
        $client->expects($this->any())
            ->method('post')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $division = self::DIVISION;
        $ret = $yesmail->Subscriber_Create('SUBSCRIBED', $division, array('email' => 'cpowell@popsugar.com'));

        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestSubscriberCreateAuthenticationFailedData() {
        $ret = array ('info' => array('http_code' => 401),
                      'response' => '{
                                        "trackingId" : "",
                                        "message" : "The request requires user authentication"
                                    }'
        );

        return $ret;
    }

    public function testSubscriberCreateResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $division = self::DIVISION;
        $yesmail->Subscriber_Create('SUBSCRIBED', $division, array('email' => 'cpowell@popsugar.com'));
    }

    public function testSubscriberUpdateRequestAccepted() {
        $client = $this->getMock('\Yesmail\CurlClient', array('put', 'get_info'), array('', ''));
        $mockData = $this->_getTestSubscriberUpdateRequestAcceptedData();
        $client->expects($this->any())
            ->method('put')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $user_id = 123;
        $division = self::DIVISION;
        $allow_resubscribe = true;
        $append = true;
        $ret = $yesmail->Subscriber_Update($user_id, 'SUBSCRIBED', $division, array('email' => 'cpowell@popsugar.com'),
            $allow_resubscribe, $append);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestSubscriberUpdateRequestAcceptedData() {
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

    public function testSubscriberUpdateRequestMalformed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 400)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $user_id = 123;
        $division = self::DIVISION;
        $allow_resubscribe = true;
        $append = true;
        $yesmail->Subscriber_Update($user_id, 'SUBSCRIBED', $division, array('email' => 'cpowell@popsugar.com'),
            $allow_resubscribe, $append);
    }

    public function testSubscriberUpdateAuthenticationFailed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $user_id = 123;
        $division = self::DIVISION;
        $allow_resubscribe = true;
        $append = true;
        $yesmail->Subscriber_Update($user_id, 'SUBSCRIBED', $division, array('email' => 'cpowell@popsugar.com'),
            $allow_resubscribe, $append);
    }

    public function testSubscriberUpdateResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $user_id = 123;
        $division = self::DIVISION;
        $allow_resubscribe = true;
        $append = true;
        $yesmail->Subscriber_Update($user_id, 'SUBSCRIBED', $division, array('email' => 'cpowell@popsugar.com'),
            $allow_resubscribe, $append);
    }

    public function testSubscriberLookupRequestSuccessful() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestSubscriberLookupRequestSuccessfulData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $ret = $yesmail->Subscriber_Lookup(array('email' => 'cpowell@popsugar.com'));

        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestSubscriberLookupRequestSuccessfulData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => '{
                                        "uri" : "https://services.yesmail.com/enterprise/subscribers/14"
                                    }'
        );

        return $ret;
    }

    public function testSubscriberLookupResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestSubscriberLookupResourceNotFoundData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $division = self::DIVISION;
        $ret = $yesmail->Subscriber_Lookup(array('email' => 'junk'));

        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestSubscriberLookupResourceNotFoundData() {
        $ret = array ('info' => array('http_code' => 404),
                      'response' => '{
                                        "trackingId" : "41b5f01b-701d-453a-bf50-8c010805d23d",
                                        "message" : "subscriber query had an empty result set."
                                }'
        );

        return $ret;
    }

    public function testSubscriberGetIdFound() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestSubscriberGetIdFoundData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $ret = $yesmail->Subscriber_Get_Id(array('email' => 'cpowell@popsugar.com'));
        $this->assertEquals(14, $ret);
    }

    protected function _getTestSubscriberGetIdFoundData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => '{
                                        "uri" : "https://services.yesmail.com/enterprise/subscribers/14"
                                    }'
        );

        return $ret;
    }

    public function testSubscriberGetIdNotFound() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $ret = $yesmail->Subscriber_Get_Id(array('email' => 'cpowell@popsugar.com'));
        $this->assertFalse($ret);
    }

    public function testSubscriberUnsubscribeRequestAccepted() {
        $client = $this->getMock('\Yesmail\CurlClient', array('delete', 'get_info'), array('', ''));
        $mockData = $this->_getTestSubscriberUnsubscribeRequestAcceptedData();
        $client->expects($this->any())
            ->method('delete')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $division = self::DIVISION;
        $ret = $yesmail->Subscriber_Unsubscribe(-1, $division);

        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestSubscriberUnsubscribeRequestAcceptedData() {
        $ret = array ('info' => array('http_code' => 202),
                      'response' => '{
                                        "trackingId" : "710629f6-320e-4afa-8237-5ee8acb43ffc",
                                        "statusCode" : "SUBMITTED",
                                        "statusMessage" : "Task has been accepted for processing",
                                        "lastUpdateTime" : "2013-07-29T20:46:48.110Z",
                                        "statusURI" : "https://API/status/710629f6-320e-4afa-8237-5ee8acb43ffc",
                                        "statusNoWaitURI" : "https://API/statusNoWait/710629f6-320e-4afa-8237-5ee8acb43ffc",
                                        "finalResourceURIs" : []
                                    }'
        );

        return $ret;
    }

    public function testSubscriberUnsubscribeRequestMalformed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('delete', 'get_info'), array('', ''));
        $mockData = $this->_getTestSubscriberUnsubscribeRequestMalformedData();
        $client->expects($this->any())
            ->method('delete')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $division = self::DIVISION;
        $ret = $yesmail->Subscriber_Unsubscribe(-10000000000, $division);

        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestSubscriberUnsubscribeRequestMalformedData() {
        $ret = array ('info' => array('http_code' => 400),
                      'response' => '{
                                        "trackingId" : "17efe157-542f-42bf-9fea-195df4c56ba5",
                                        "message" : "Invalid {userId}: -10000000000"
                                    }'
        );

        return $ret;
    }

    public function testSubscriberUnsubscribeAuthenticationFailed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('delete', 'get_info'), array('', ''));
        $mockData = $this->_getTestSubscriberUnsubscribeAuthenticationFailedData();
        $client->expects($this->any())
            ->method('delete')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $division = self::DIVISION;
        $ret = $yesmail->Subscriber_Unsubscribe(-1, $division);

        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestSubscriberUnsubscribeAuthenticationFailedData() {
        $ret = array ('info' => array('http_code' => 401),
                      'response' => '{
                                        "trackingId" : "",
                                        "message" : "The request requires user authentication"
                                    }'
        );

        return $ret;
    }

    public function testSubscriberUnsubscribeResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $division = self::DIVISION;
        $yesmail->Subscriber_Unsubscribe(-1, $division);
    }

    // 200
    public function testStatusGetRequestSuccessful() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestStatusGetRequestSuccessfulData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $ret = $yesmail->Status_Get('a-valid-tracking-id');

        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestStatusGetRequestSuccessfulData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => '{
                                        "trackingId" : "d32a52ed-0195-4264-a87d-8ecdedca7bbb",
                                        "statusCode" : "ERROR",
                                        "statusMessage" : "An error occurred: Refusing to update subscriber because the request url contained an invalid id \"-1\"",
                                        "lastUpdateTime" : "2013-07-30T15:49:11.000Z",
                                        "statusURI" : "https://API/status/d32a52ed-0195-4264-a87d-8ecdedca7bbb",
                                        "statusNoWaitURI" : "https://API/statusNoWait/d32a52ed-0195-4264-a87d-8ecdedca7bbb",
                                        "finalResourceURIs" : []
                                        ,"requestDetails" : {
                                            "method":"DELETE",
                                            "uri":"http://API/subscribers/-1?division=xxx",
                                            "requestTime":"2013-07-30T08:49:11.503Z",
                                            "userAgent":"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36",
                                            "remoteIp":"192.168.25.215",
                                            "charEncoding":"",
                                            "contentLength":135,
                                            "contentType":"application/json",
                                            "requestBodyUri":"https://API/status/d32a52ed-0195-4264-a87d-8ecdedca7bbb/request",
                                            "companyName":"popsugar",
                                            "createdBy":"915848"
                                        }
                                    }'
        );

        return $ret;
    }

    // 401
    public function testStatusGetAuthenticationFailed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $ret = $yesmail->Status_Get('real-status');
    }

    // 404
    public function testStatusGetResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $ret = $yesmail->Status_Get('an-invalid-tracking-id');
    }

    public function testMasterCreateEnvelopeNotInstanceOfYesmailMasterEnvelope() {
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $envelope = NULL;
        $targeting = $this->getMock('\Yesmail\YesmailMasterTargeting', NULL, array(), 'MyYesmailMasterTargeting', false);
        $scheduling = $this->getMock('\Yesmail\YesmailMasterScheduling', NULL, array(), 'MyYesmailMasterScheduling', false);
        $ret = $yesmail->Master_Create($envelope, $targeting, $scheduling);
        $this->assertFalse($ret);
    }

    public function testMasterCreateEnvelopeInvalid() {
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $envelope = $this->getMock('\Yesmail\YesmailMasterEnvelope', array('is_valid'), array(), 'MyYesmailMasterEnvelope', false);
        $envelope->expects($this->any())
            ->method('is_valid')
            ->will($this->returnValue(false));
        $targeting = $this->getMock('\Yesmail\YesmailMasterTargeting', NULL, array(), 'MyYesmailMasterTargeting', false);
        $scheduling = $this->getMock('\Yesmail\YesmailMasterScheduling', NULL, array(), 'MyYesmailMasterScheduling', false);
        $ret = $yesmail->Master_Create($envelope, $targeting, $scheduling);
        $this->assertFalse($ret);
    }

    // 202
    public function testMasterCreateRequestAccepted() {
        $client = $this->getMock('\Yesmail\CurlClient', array('post', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterCreateRequestAcceptedData();
        $client->expects($this->any())
            ->method('post')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterName = 'Test Master';
        $fromName = 'from-name';
        $fromDomain = 'from-domain.com';
        $division = self::DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject);
        $targeting = NULL;
        $scheduling = array();
        $ret = $yesmail->Master_Create($envelope, $targeting, $scheduling);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestMasterCreateRequestAcceptedData() {
        $ret = array ('info' => array('http_code' => 202),
                      'response' => '{
                                        "trackingId" : "1b1dacf1-f578-4288-910a-d9a2fb0ef133",
                                        "statusCode" : "SUBMITTED",
                                        "statusMessage" : "Task has been accepted for processing",
                                        "lastUpdateTime" : "2013-07-31T18:57:31.903Z",
                                        "statusURI" : "https://API/status/1b1dacf1-f578-4288-910a-d9a2fb0ef133",
                                        "statusNoWaitURI" : "https://API/statusNoWait/1b1dacf1-f578-4288-910a-d9a2fb0ef133",
                                        "finalResourceURIs" : []
                                    }'
        );

        return $ret;
    }

    public function testMasterUpdateRequestAccepted() {
        $client = $this->getMock('\Yesmail\CurlClient', array('put', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterUpdateRequestAcceptedData();
        $client->expects($this->any())
            ->method('put')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $envelope = $this->getMock('\Yesmail\YesmailMasterEnvelope', array('is_valid'), array(), 'MyYesmailMasterEnvelope', false);
        $envelope->expects($this->any())
            ->method('is_valid')
            ->will($this->returnValue(true));
        $targeting = NULL;
        $scheduling = NULL;
        $ret = $yesmail->Master_Update($masterId, $envelope, $targeting, $scheduling);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestMasterUpdateRequestAcceptedData() {
        $ret = array ('info' => array('http_code' => 202),
                      'response' => '{
                                        "trackingId" : "1b1dacf1-f578-4288-910a-d9a2fb0ef133",
                                        "statusCode" : "SUBMITTED",
                                        "statusMessage" : "Task has been accepted for processing",
                                        "lastUpdateTime" : "2013-07-31T18:57:31.903Z",
                                        "statusURI" : "https://API/status/1b1dacf1-f578-4288-910a-d9a2fb0ef133",
                                        "statusNoWaitURI" : "https://API/statusNoWait/1b1dacf1-f578-4288-910a-d9a2fb0ef133",
                                        "finalResourceURIs" : []
                                    }'
        );

        return $ret;
    }

    public function testMasterStatusUpdateRequestAccepted() {
        $client = $this->getMock('\Yesmail\CurlClient', array('put', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterStatusUpdateRequestAcceptedData();
        $client->expects($this->any())
            ->method('put')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $masterId = 123;
        $status = 'ENABLED';
        $ret = $yesmail->Master_Status_Update($masterId, $status);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestMasterStatusUpdateRequestAcceptedData() {
        $ret = array ('info' => array('http_code' => 202),
                      'response' => '{
                                        "trackingId" : "1b1dacf1-f578-4288-910a-d9a2fb0ef133",
                                        "statusCode" : "SUBMITTED",
                                        "statusMessage" : "Task has been accepted for processing",
                                        "lastUpdateTime" : "2013-07-31T18:57:31.903Z",
                                        "statusURI" : "https://API/status/1b1dacf1-f578-4288-910a-d9a2fb0ef133",
                                        "statusNoWaitURI" : "https://API/statusNoWait/1b1dacf1-f578-4288-910a-d9a2fb0ef133",
                                        "finalResourceURIs" : []
                                    }'
        );

        return $ret;
    }

    public function testMasterStatusUpdateRequestMalformed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 400)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $status = 'ENABLED';
        $yesmail->Master_Status_Update($masterId, $status);
    }

    public function testMasterStatusUpdateAuthenticationFailed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $status = 'ENABLED';
        $yesmail->Master_Status_Update($masterId, $status);
    }

    public function testMasterStatusUpdateResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $status = 'ENABLED';
        $yesmail->Master_Status_Update($masterId, $status);
    }

    public function testMasterStatusGetSuccessful() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterStatusGetSuccessfulData();
        $client->expects($this->any())
            ->method('put')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $masterId = 123;
        $ret = $yesmail->Master_Status_Get($masterId);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestMasterStatusGetSuccessfulData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => '{
                                        status: "DISABLED"
                                    }'
        );

        return $ret;
    }

    public function testMasterStatusGetResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $yesmail->Master_Status_Get($masterId);
    }

    public function testMasterGetSuccessful() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterGetSuccessfulData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $ret = $yesmail->Master_Get($masterId);
        $this->assertEquals($masterId, $ret->id);
        $this->assertEquals('Test', $ret->envelope->masterName);
        $this->assertEquals('Description', $ret->envelope->description);
        $this->assertEquals('Campaign', $ret->envelope->campaign);
        $this->assertEquals('Test Division', $ret->envelope->division);
        $this->assertEquals('UTF-8', $ret->envelope->encoding);
        $this->assertEquals('Subject', $ret->envelope->subject);
        $this->assertEquals('POPSUGAR', $ret->envelope->friendlyFrom);
        $this->assertEquals('from-name', $ret->envelope->fromName);
        $this->assertEquals('AUTODETECT', $ret->envelope->deliveryType);
        $this->assertCount(2, $ret->envelope->keywords->keywords);
        $this->assertEquals('key1', $ret->envelope->keywords->keywords[0]);
        $this->assertEquals('key2', $ret->envelope->keywords->keywords[1]);
        $this->assertCount(2, $ret->envelope->seedLists->seedLists);
        $this->assertEquals('PKTest', $ret->envelope->seedLists->seedLists[0]);
        $this->assertEquals('TestSat', $ret->envelope->seedLists->seedLists[1]);
    }

    protected function _getTestMasterGetSuccessfulData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => '{
                                        "envelope" : {
                                            "masterName" : "Test",
                                            "description" : "Description",
                                            "campaign" : "Campaign",
                                            "division" : "Test Division",
                                            "encoding" : "UTF-8",
                                            "subject" : "Subject",
                                            "friendlyFrom" : "POPSUGAR",
                                            "fromName" : "from-name",
                                            "fromDomain" : "from-domain.com",
                                            "deliveryType":"AUTODETECT",
                                            "keywords" : {
                                                "keywords" : [
                                                    "key1",
                                                    "key2"
                                                ]
                                            },
                                            "seedLists" : {
                                                "seedLists" : [
                                                    "PKTest",
                                                    "TestSat"
                                                ]
                                            }
                                        },
                                        "targeting" : {
                                            "requiredTargetAttributes" : {
                                                "requiredTargetAttributes" : [
                                                ]
                                            },
                                            "targetAttributes" : [
                                            ]
                                        },
                                        "scheduling" : {
                                            "allowMultipleDeliveries" : "false",
                                            "compileBeforeDeliveryStart" : "false",
                                            "compileStartDateTime" : "",
                                            "deliverImmediately" : false,
                                            "deliveryStartDateTime" : "4000-01-01T00:00:00.000Z",
                                            "maxRecipients" : 2147483647,
                                            "obeyDeliveryLimits" : "true",
                                            "priority" : 1,
                                            "deliveryFrequency" : "CONTINUALLY",
                                            "deliveryEndDateTime" : "",
                                            "deliveryPeriodHour" : "",
                                            "deliveryPeriodWeek" : "",
                                            "deliveryPeriodDayOfMonth" : "",
                                            "repeatsUntilDisabled" : true,
                                            "maxMessages" : "",
                                            "deliveryRatePeriod" : ""
                                        }
                                    }'
        );

        return $ret;
    }

    public function testMasterGetNotFound() {
//        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $ret = $yesmail->Master_Get($masterId);
    }

    public function testMasterAssetsGetSuccessful() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterAssetsGetSuccessfulData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $masterId = 123;
        $ret = $yesmail->Master_Assets_Get($masterId);
        $this->assertEquals($ret, json_decode($mockData['response']));

    }

    protected function _getTestMasterAssetsGetSuccessfulData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => '{
                                        "assets" : [
                                            "https://API/masters/1018979/assets/html",
                                            "https://API/masters/1018979/assets/text"
                                        ]
                                    }'
        );

        return $ret;
    }

    public function testMasterAssetsGetRequestMalformed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 400)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $yesmail->Master_Assets_Get($masterId);
    }

    public function testMasterAssetsGetAuthenticationFailed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $yesmail->Master_Assets_Get($masterId);
    }

    public function testMasterAssetsGetResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $yesmail->Master_Assets_Get($masterId);
    }

    public function testMasterAssetAddRequestAccepted() {
        $client = $this->getMock('\Yesmail\CurlClient', array('post', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterAssetAddRequestAcceptedData();
        $client->expects($this->any())
            ->method('post')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $assetName = 'index.html';
        $assetBase64 = base64_encode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html lang="en"><head><meta http-equiv="content-type" content="text/html; charset=utf-8"><title>title</title></head><body>test</body></html>');
        $ret = $yesmail->Master_Asset_Add($masterId, $assetName, $assetBase64);

        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestMasterAssetAddRequestAcceptedData() {
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

    public function testMasterAssetAddRequestMalformed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 400)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $assetName = 'index.html';
        $assetBase64 = base64_encode('not-html');
        $yesmail->Master_Asset_Add($masterId, $assetName, $assetBase64);
    }

    public function testMasterAssetAddAuthenticationFailed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $assetName = 'index.html';
        $assetBase64 = base64_encode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html lang="en"><head><meta http-equiv="content-type" content="text/html; charset=utf-8"><title>title</title></head><body>test</body></html>');
        $yesmail->Master_Asset_Add($masterId, $assetName, $assetBase64);
    }

    public function testMasterAssetAddResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $assetName = 'index.html';
        $assetBase64 = base64_encode('<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html lang="en"><head><meta http-equiv="content-type" content="text/html; charset=utf-8"><title>title</title></head><body>test</body></html>');
        $yesmail->Master_Asset_Add($masterId, $assetName, $assetBase64);
    }

    public function testMasterAssetDeleteRequestAccepted() {
        $client = $this->getMock('\Yesmail\CurlClient', array('delete', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterAssetDeleteRequestAcceptedData();
        $client->expects($this->any())
            ->method('delete')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $assetName = "index.html";
        $ret = $yesmail->Master_Asset_Delete($masterId, $assetName);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestMasterAssetDeleteRequestAcceptedData() {
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

    public function testMasterAssetDeleteRequestMalformed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 400)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $assetName = "index.html";
        $yesmail->Master_Asset_Delete($masterId, $assetName);
    }

    public function testMasterAssetDeleteAuthenticationFailed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $assetName = "index.html";
        $yesmail->Master_Asset_Delete($masterId, $assetName);
    }

    public function testMasterAssetDeleteResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $assetName = "index.html";
        $yesmail->Master_Asset_Delete($masterId, $assetName);
    }

    public function testMasterGetByNameFound() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterGetByNameFoundData();
        $client->expects($this->at(0))
            ->method('get')
            ->will($this->returnValue($mockData['response'][0]));
        $client->expects($this->at(2)) // 2 because the index is the index of ANY method call on client, not just 'get'
            ->method('get')
            ->will($this->returnValue($mockData['response'][1]));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterName = 'Message 1';
        $ret = $yesmail->Master_Get_By_Name($masterName);
        $this->assertInstanceOf('stdClass', $ret);
        $this->assertEquals($masterName, $ret->envelope->masterName);
    }

    protected function _getTestMasterGetByNameFoundData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => array(
                                    '{
                                        "masters" : [
                                            {
                                                "masterURI" : "https://API/masters/1018984",
                                                "masterId" : "1018984",
                                                "masterName" : "Message 1",
                                                "campaignId" : ""
                                            },
                                            {
                                                "masterURI" : "https://API/masters/1018983",
                                                "masterId" : "1018983",
                                                "masterName" : "Message 2",
                                                "campaignId" : ""
                                            }
                                        ]
                                     }',
                                    '{
                                          "envelope" : {
                                              "masterName" : "Message 1",
                                              "description" : "",
                                              "campaign" : "",
                                              "division" : "Test Division",
                                              "encoding" : "UTF-8",
                                              "subject" : "",
                                              "friendlyFrom" : "POPSUGAR",
                                              "fromName" : "from-name",
                                              "fromDomain" : "from-domain.com",
                                              "deliveryType":"AUTODETECT",
                                              "keywords" : {
                                                  "keywords" : [
                                                  ]
                                              },
                                              "seedLists" : {
                                                  "seedLists" : [
                                                  ]
                                              }
                                          },
                                          "targeting" : {
                                              "requiredTargetAttributes" : {
                                                  "requiredTargetAttributes" : [
                                                  ]
                                              },
                                              "targetAttributes" : [
                                              ]
                                          },
                                          "scheduling" : {
                                              "allowMultipleDeliveries" : "false",
                                              "compileBeforeDeliveryStart" : "false",
                                              "compileStartDateTime" : "",
                                              "deliverImmediately" : "false",
                                              "deliveryStartDateTime" : "4000-01-01T00:00:00.000Z",
                                              "maxRecipients" : 2147483647,
                                              "obeyDeliveryLimits" : "true",
                                              "priority" : 1,
                                              "deliveryFrequency" : "CONTINUALLY",
                                              "deliveryEndDateTime" : "",
                                              "deliveryPeriodHour" : "",
                                              "deliveryPeriodWeek" : "",
                                              "deliveryPeriodDayOfMonth" : "",
                                              "repeatsUntilDisabled" : "true",
                                              "maxMessages" : "",
                                              "deliveryRatePeriod" : ""
                                          }
                                      }'
                      )
        );

        return $ret;
    }

    public function testMasterGetByNameNotFound() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterGetByNameNotFoundData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterName = 'Message 3';
        $ret = $yesmail->Master_Get_By_Name($masterName);
        $this->assertFalse($ret);
    }

    protected function _getTestMasterGetByNameNotFoundData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => '{
                                        "masters" : [
                                            {
                                                "masterURI" : "https://API/masters/1018984",
                                                "masterId" : "1018984",
                                                "masterName" : "Message 1",
                                                "campaignId" : ""
                                            },
                                            {
                                                "masterURI" : "https://API/masters/1018983",
                                                "masterId" : "1018983",
                                                "masterName" : "Message 2",
                                                "campaignId" : ""
                                            }
                                        ]
                                     }'
        );

        return $ret;
    }

    public function testMasterPreviewDistributionListRequestAccepted() {
        $client = $this->getMock('\Yesmail\CurlClient', array('post', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterPreviewDistributionListRequestAcceptedData();
        $client->expects($this->any())
            ->method('post')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $contentType = 'BOTH';
        $distributionList = 'Test Distribution List';
        $userId = NULL;
        $emails = NULL;
        $ret = $yesmail->Master_Preview($masterId, $contentType, $distributionList, $userId, $emails);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestMasterPreviewDistributionListRequestAcceptedData() {
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

    public function testMasterPreviewManualListRequestAccepted() {
        $client = $this->getMock('\Yesmail\CurlClient', array('post', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterPreviewManualListRequestAcceptedData();
        $client->expects($this->any())
            ->method('post')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $contentType = 'BOTH';
        $distributionList = NULL;
        $userId = 123;
        $emails = array('cpowell@popsugar.com');
        $ret = $yesmail->Master_Preview($masterId, $contentType, $distributionList, $userId, $emails);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestMasterPreviewManualListRequestAcceptedData() {
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

    public function testMasterPreviewRequestMalformed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 400)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $contentType = 'BOTH';
        $distributionList = 'Test Distribution List';
        $userId = NULL;
        $emails = NULL;
        $yesmail->Master_Preview($masterId, $contentType, $distributionList, $userId, $emails);
    }

    public function testMasterPreviewAuthenticationFailed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $contentType = 'BOTH';
        $distributionList = 'Test Distribution List';
        $userId = NULL;
        $emails = NULL;
        $yesmail->Master_Preview($masterId, $contentType, $distributionList, $userId, $emails);
    }

    public function testMasterPreviewResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $contentType = 'BOTH';
        $distributionList = 'Test Distribution List';
        $userId = NULL;
        $emails = NULL;
        $yesmail->Master_Preview($masterId, $contentType, $distributionList, $userId, $emails);
    }

    public function testMasterPreviewConflict() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 409)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $masterId = 123;
        $contentType = 'BOTH';
        $distributionList = 'Test Distribution List';
        $userId = NULL;
        $emails = NULL;
        $yesmail->Master_Preview($masterId, $contentType, $distributionList, $userId, $emails);
    }

    public function testListManagementGetListsSuccessful() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestListManagementGetListsSuccessfulData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $type = 'DISTRIBUTIONLIST';
        $ret = $yesmail->ListManagement_Get_Lists($type);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestListManagementGetListsSuccessfulData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => '{
                                        "listOfLists" : [
                                            {
                                                "URI" : "https://API/lists/DISTRIBUTIONLIST/ps1",
                                                "id" : "5",
                                                "name" : "ps1",
                                                "type" : "DISTRIBUTIONLIST",
                                                "subtype" : "TESTGROUP"
                                            },
                                            {
                                                "URI" : "https://API/lists/DISTRIBUTIONLIST/ps2",
                                                "id" : "9",
                                                "name" : "ps2",
                                                "type" : "DISTRIBUTIONLIST",
                                                "subtype" : "TESTGROUP"
                                            }
                                        ]
                                    }'
        );

        return $ret;
    }

    public function testListManagementGetListsMalformed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestListManagementGetListsMalformedData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $type = 'unknown-type';
        $ret = $yesmail->ListManagement_Get_Lists($type);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestListManagementGetListsMalformedData() {
        $ret = array ('info' => array('http_code' => 400),
                      'response' => '{
                                        "trackingId" : "cffc8151-e080-4160-aaa3-8ddf938f7034",
                                        "message" : "Unknown list type: unknown-type possible choices are: [LISTLOADLIST, DISTRIBUTIONLIST]"
                                    }'
        );

        return $ret;
    }

    public function testListManagementGetListSuccessful() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestListManagementGetListSuccessfulData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $name = 'TEST';
        $type = 'DISTRIBUTIONLIST';
        $ret = $yesmail->ListManagement_Get_List($name, $type);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestListManagementGetListSuccessfulData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => '{
                                        "URI" : "https://API/lists/DISTRIBUTIONLIST/TEST",
                                        "id" : "24",
                                        "name" : "TEST",
                                        "type" : "DISTRIBUTIONLIST",
                                        "subtype" : "TESTGROUP"
                                    }'
        );

        return $ret;
    }

    public function testListManagementGetListMalformed() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestListManagementGetListMalformedData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);

        $name = 'TEST';
        $type = 'unknown-type';
        $ret = $yesmail->ListManagement_Get_List($name, $type);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestListManagementGetListMalformedData() {
        $ret = array ('info' => array('http_code' => 400),
                      'response' => '{
                                        "trackingId" : "cffc8151-e080-4160-aaa3-8ddf938f7034",
                                        "message" : "Unknown list type: unknown-type possible choices are: [LISTLOADLIST, DISTRIBUTIONLIST]"
                                    }'
        );

        return $ret;
    }

    public function testListManagementIsSubscriberInListFound() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestListManagementIsSubscriberInListFoundData();
        $client->expects($this->at(0))
            ->method('get')
            ->will($this->returnValue($mockData['response'][0]));
        $client->expects($this->at(2)) // 2 because the index is the index of ANY method call on client, not just 'get'
            ->method('get')
            ->will($this->returnValue($mockData['response'][1]));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $name = 'TEST';
        $type = 'DISTRIBUTIONLIST';
        $attributes = array('email' => 'cpowell@popsugar.com');
        $ret = $yesmail->ListManagement_Is_Subscriber_In_List($name, $type, $attributes);
        $this->assertTrue($ret);
    }

    protected function _getTestListManagementIsSubscriberInListFoundData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => array(
                          '{
                               "uri" : "https://services.yesmail.com/enterprise/subscribers/14"
                           }',
                          '{
                               "subscriberIds" : [ 419255, 18, 14]
                           }'
                      )
        );

        return $ret;
    }

    public function testListManagementIsSubscriberInListNotFound() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get_info'), array('', ''));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue(array('http_code' => 404)));
        $yesmail = new Yesmail($client, self::YESMAIL_TEST_URL);
        $name = 'TEST';
        $type = 'DISTRIBUTIONLIST';
        $attributes = array('email' => 'cpowell@popsugar.com');
        $ret = $yesmail->ListManagement_Is_Subscriber_In_List($name, $type, $attributes);
        $this->assertFalse($ret);
    }
}
