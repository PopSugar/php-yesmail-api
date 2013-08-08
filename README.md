php-yesmail-api
==========================

Yesmail v1 API PHP Client. Implementation for Subscriber, Master, and List Management APIs.


Subscriber API Sample code:

    <?php

    $client = new Yesmail\CurlClient('username', 'password');
    $yesmail = new Yesmail\Yesmail($client);
    $subscriber = $yesmail->Subscriber_Lookup(array('email' => 'user@company.com'));

Master API Sample code:

    <?php
    
    $client = new Yesmail\CurlClient('username', 'password');
    $yesmail = new Yesmail\Yesmail($client);
    $masterName = 'Test Master';
    $fromName = 'yoursite';
    $fromDomain = 'yoursite.com';
    $division = 'My Division';
    $encoding = 'UTF-8';
    $subject = 'A Subject';
    $envelope = new Yesmail\YesmailMasterEnvelope($masterName, $fromName, $fromDomain, $division, $encoding, $subject);
    $targeting = NULL;
    $scheduling = array();
    $ret = $yesmail->Master_Create($envelope, $targeting, $scheduling);
    
List Management API Sample code:

    <?php
    
    $client = new Yesmail\CurlClient('username', 'password');
    $yesmail = new Yesmail\Yesmail($client);
    
    $name = 'My List';
    $type = 'DISTRIBUTIONLIST';
    $subtype = 'SEEDLIST';
    $deleteInsteadOfAppend = true;
    $subscriberIds = array(1, 2, 3);
    $emails = array();
    $subscriberList = new Yesmail\YesmailListManagementSubscriberList($deleteInsteadOfAppend, $subscriberIds, $emails);
    $modifyList = new Yesmail\YesmailListManagementModifyList($name, $type, $subtype, $subscriberList);
    $ret = $yesmail->ListManagement_Update_List($modifyList);
    
