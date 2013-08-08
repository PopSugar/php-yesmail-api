<?php
namespace Yesmail;

class YesmailTest extends \PHPUnit_Framework_TestCase {
    const SHOPSTYLE_DIVISION = 'ShopStyle US';

    public function testCreateYesmail() {
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client);
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
        $yesmail = new Yesmail($client);

        $division = self::SHOPSTYLE_DIVISION;
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
        $this->markTestIncomplete();
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

        $yesmail = new Yesmail($client);

        $division = self::SHOPSTYLE_DIVISION;
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
        $this->markTestIncomplete();
    }

    public function testSubscriberCreateInternalServerError() {
        $this->markTestIncomplete();
    }

    public function testSubscriberCreateServiceTemporarilyUnavailable() {
        $this->markTestIncomplete();
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

        $yesmail = new Yesmail($client);

        $division = self::SHOPSTYLE_DIVISION;
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

        $yesmail = new Yesmail($client);

        $division = self::SHOPSTYLE_DIVISION;
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

    public function testSubscriberLookupInternalServerError() {
        $this->markTestIncomplete();
    }

    public function testSubscriberLookupServiceTemporarilyUnavailable() {
        $this->markTestIncomplete();
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

        $yesmail = new Yesmail($client);

        $division = self::SHOPSTYLE_DIVISION;
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
//        $this->markTestIncomplete();
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', array('delete', 'get_info'), array('', ''));
        $mockData = $this->_getTestSubscriberUnsubscribeRequestMalformedData();
        $client->expects($this->any())
            ->method('delete')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));

        $yesmail = new Yesmail($client);

        $division = self::SHOPSTYLE_DIVISION;
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

        $yesmail = new Yesmail($client);

        $division = self::SHOPSTYLE_DIVISION;
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
        $this->markTestIncomplete();
    }

    public function testSubscriberUnsubscribeInternalServerError() {
        $this->markTestIncomplete();
    }

    public function testSubscriberUnsubscribeServiceTemporarilyUnavailable() {
        $this->markTestIncomplete();
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

        $yesmail = new Yesmail($client);
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
        $yesmail = new Yesmail($client);
        $ret = $yesmail->Status_Get('real-status');
    }

    // 404
    public function testStatusGetResourceNotFound() {
        $this->setExpectedException('Exception');
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client);
        $ret = $yesmail->Status_Get('an-invalid-tracking-id');
    }

    // 500
    public function testStatusGetInternalServerError() {
        $this->markTestIncomplete();
    }

    // 503
    public function testStatusGetServiceTemporarilyUnavailable() {
        $this->markTestIncomplete();
    }

    public function testMasterCreateEnvelopeNotInstanceOfYesmailMasterEnvelope() {
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client);
        $envelope = NULL;
        $targeting = $this->getMock('\Yesmail\YesmailMasterTargeting', NULL, array(), 'MyYesmailMasterTargeting', false);
        $scheduling = $this->getMock('\Yesmail\YesmailMasterScheduling', NULL, array(), 'MyYesmailMasterScheduling', false);
        $ret = $yesmail->Master_Create($envelope, $targeting, $scheduling);
        $this->assertFalse($ret);
    }

    public function testMasterCreateEnvelopeInvalid() {
        $client = $this->getMock('\Yesmail\CurlClient', NULL, array('', ''));
        $yesmail = new Yesmail($client);
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
        $yesmail = new Yesmail($client);
        $masterName = 'Test Master';
        $fromName = 'shopstyle';
        $fromDomain = 'shopstyle.com';
        $division = self::SHOPSTYLE_DIVISION;
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

    public function testMasterGetSuccessful() {
        $client = $this->getMock('\Yesmail\CurlClient', array('get', 'get_info'), array('', ''));
        $mockData = $this->_getTestMasterGetSuccessfulData();
        $client->expects($this->any())
            ->method('get')
            ->will($this->returnValue($mockData['response']));
        $client->expects($this->any())
            ->method('get_info')
            ->will($this->returnValue($mockData['info']));
        $yesmail = new Yesmail($client);
        $masterId = 123;
        $ret = $yesmail->Master_Get($masterId);
        $this->assertEquals($ret, json_decode($mockData['response']));
    }

    protected function _getTestMasterGetSuccessfulData() {
        $ret = array ('info' => array('http_code' => 200),
                      'response' => '{
                                        "envelope" : {
                                            "masterName" : "Test",
                                            "description" : "",
                                            "campaign" : "",
                                            "division" : "ShopStyle US",
                                            "encoding" : "UTF-8",
                                            "subject" : "",
                                            "friendlyFrom" : "POPSUGAR",
                                            "fromName" : "shopstyle",
                                            "fromDomain" : "e-mail.popsugar.com",
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
                                            "maxRecipients" : "2147483647",
                                            "obeyDeliveryLimits" : "true",
                                            "priority" : "1",
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
        );

        return $ret;
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
        $yesmail = new Yesmail($client);

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
        $yesmail = new Yesmail($client);

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
        $yesmail = new Yesmail($client);

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
        $yesmail = new Yesmail($client);

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
}
