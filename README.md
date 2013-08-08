php-yesmail-api
==========================

Yesmail v1 API PHP Client. Implementation for Subscriber, Master, and List Management APIs.

## Getting started
Yesmail can be installed using composer. Add the following to your composer.json file.
```
"popsugar/php-yesmail-api": "1.0.0"
```

## Examples

Subscriber API Sample code:

```PHP
$client = new Yesmail\CurlClient('username', 'password');
$yesmail = new Yesmail\Yesmail($client);
$subscriber = $yesmail->Subscriber_Lookup(array('email' => 'user@company.com'));
```

Master API Sample code:

```PHP
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
```

List Management API Sample code:

```PHP
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
```

## Contributing
To contribute to this project:
* Create a fork of this repository
* Create a thoughtfully named branch for your feature/bug
* Package your changes into meaningful commits with meaningful
  commit messages.
* Open a pull-request into PopSugar/php-yesmail-api@master

Please write unit tests for new code, and make sure existing unit tests pass. You can run the unit tests using `phpunit` from the top level directory.
