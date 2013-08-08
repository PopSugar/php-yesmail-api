<?php
namespace Yesmail;
class YesmailMasterEnvelopeTest extends \PHPUnit_Framework_TestCase {
    const SHOPSTYLE_DIVISION = 'ShopStyle US';

    public function testCreateYesmailMasterEnvelope() {
        $envelope = new YesmailMasterEnvelope("Test Master", "POPSUGAR", "popsugar.com", "ShopStyle US", "UTF-8", "");
        $this->assertInstanceOf('\Yesmail\YesmailMasterEnvelope', $envelope);
    }

    public function testYesmailMasterEnvelopeJson() {
        $envelope = new YesmailMasterEnvelope("Test Master", "POPSUGAR", "popsugar.com", "ShopStyle US", "UTF-8", "");
        $json = '{"masterName":"Test Master","fromName":"POPSUGAR","fromDomain":"popsugar.com","division":"ShopStyle US","encoding":"UTF-8","subject":"","deliveryType":"AUTODETECT","friendlyFrom":"","description":"","campaign":""}';
        $this->assertEquals($json, json_encode($envelope));
    }

    public function testMasterEnvelopeValidOnlyRequired() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject);
        $this->assertTrue($envelope->is_valid());
    }

    public function testMasterEnvelopeValidOnlyRequiredPlusOptional() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $deliveryType = 'AUTODETECT';
        $friendlyFrom = 'POPSUGAR';
        $description = 'Test Description';
        $campaign = 'Test Campaign';
        $keywords = array('test1', 'test2', 'test3');
        $seedLists = array('list1', 'list2', 'list3');
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject,
            $deliveryType, $friendlyFrom, $description, $campaign, $keywords, $seedLists);
        $this->assertTrue($envelope->is_valid());
    }

    public function testMasterEnvelopeMasterNameInvalid() {
        $masterName = NULL;
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject);
        $this->assertFalse($envelope->is_valid());
    }

    public function testMasterEnvelopeFromNameInvalid() {
        $masterName = 'Test Master';
        $fromName = NULL;
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject);
        $this->assertFalse($envelope->is_valid());
    }

    public function testMasterEnvelopeFromDomainInvalid() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = NULL;
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject);
        $this->assertFalse($envelope->is_valid());
    }

    public function testMasterEnvelopeDivisionInvalid() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = NULL;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject);
        $this->assertFalse($envelope->is_valid());
    }

    public function testMasterEnvelopeEncodingInvalid() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'unknown-encoding';
        $subject = 'Test Subject';
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject);
        $this->assertFalse($envelope->is_valid());
    }

    public function testMasterEnvelopeSubjectInvalid() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = NULL;
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject);
        $this->assertFalse($envelope->is_valid());
    }

    public function testMasterEnvelopeDeliveryTypeInvalid() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $deliveryType = NULL;
        $friendlyFrom = 'POPSUGAR';
        $description = 'Test Description';
        $campaign = 'Test Campaign';
        $keywords = array('test1', 'test2', 'test3');
        $seedLists = array('list1', 'list2', 'list3');
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject,
            $deliveryType, $friendlyFrom, $description, $campaign, $keywords, $seedLists);
        $this->assertFalse($envelope->is_valid());
    }

    public function testMasterEnvelopeFriendlyFromInvalid() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $deliveryType = 'AUTODETECT';
        $friendlyFrom = NULL;
        $description = 'Test Description';
        $campaign = 'Test Campaign';
        $keywords = array('test1', 'test2', 'test3');
        $seedLists = array('list1', 'list2', 'list3');
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject,
            $deliveryType, $friendlyFrom, $description, $campaign, $keywords, $seedLists);
        $this->assertFalse($envelope->is_valid());
    }

    public function testMasterEnvelopeDescriptionInvalid() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $deliveryType = 'AUTODETECT';
        $friendlyFrom = 'POPSUGAR';
        $description = NULL;
        $campaign = 'Test Campaign';
        $keywords = array('test1', 'test2', 'test3');
        $seedLists = array('list1', 'list2', 'list3');
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject,
            $deliveryType, $friendlyFrom, $description, $campaign, $keywords, $seedLists);
        $this->assertFalse($envelope->is_valid());
    }

    public function testMasterEnvelopeCampaignInvalid() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $deliveryType = 'AUTODETECT';
        $friendlyFrom = 'POPSUGAR';
        $description = 'Test Description';
        $campaign = NULL;
        $keywords = array('test1', 'test2', 'test3');
        $seedLists = array('list1', 'list2', 'list3');
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject,
            $deliveryType, $friendlyFrom, $description, $campaign, $keywords, $seedLists);
        $this->assertFalse($envelope->is_valid());
    }

    public function testMasterEnvelopeBadKeyword() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $deliveryType = 'AUTODETECT';
        $friendlyFrom = 'POPSUGAR';
        $description = 'Test Description';
        $campaign = 'Test Campaign';
        $keywords = array('test1', NULL, 'test3');
        $seedLists = array('list1', 'list2', 'list3');
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject,
            $deliveryType, $friendlyFrom, $description, $campaign, $keywords, $seedLists);
        $this->assertTrue($envelope->is_valid());
        $this->assertEmpty($envelope->keywords);
    }

    public function testMasterEnvelopeBadSeedList() {
        $masterName = 'Test Master';
        $fromName = 'POPSUGAR';
        $fromDomain = 'popsugar.com';
        $division = self::SHOPSTYLE_DIVISION;
        $encoding = 'UTF-8';
        $subject = 'Test Subject';
        $deliveryType = 'AUTODETECT';
        $friendlyFrom = 'POPSUGAR';
        $description = 'Test Description';
        $campaign = 'Test Campaign';
        $keywords = array('test1', 'test2', 'test3');
        $seedLists = array('list1', NULL, 'list3');
        $envelope = new YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject,
            $deliveryType, $friendlyFrom, $description, $campaign, $keywords, $seedLists);
        $this->assertTrue($envelope->is_valid());
        $this->assertEmpty($envelope->seedLists);
    }
}
