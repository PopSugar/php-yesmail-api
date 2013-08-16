<?php
namespace Yesmail;
class YesmailListloadTest extends \PHPUnit_Framework_TestCase {
    const DIVISION = 'Test Division';

    public function testCreateYesmailListload() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = 100;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertInstanceOf('\Yesmail\YesmailListload', $listload);
    }

    public function testYesmailListloadJson() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = 100;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $json = '{"division":"Test Division","datafileURI":"datafile.csv","subscribe":true,"profileUpdate":false,"listLoadName":"Test Listload","options":{"loadMode":"INSERT_ONLY","headers":false,"maxErrors":100,"errorType":"ABSOLUTE"}}';
        $this->assertEquals($json, json_encode($listload));
    }

    public function testListloadValid() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = 100;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertTrue($listload->is_valid());
    }

    public function testListloadDivisionInvalid() {
        $division = NULL;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = 100;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
            $headers, $maxErrors, $errorType);
        $this->assertFalse($listload->is_valid());
    }

    public function testListloadDatafileURIInvalid() {
        $division = self::DIVISION;
        $datafileURI = NULL;
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = 100;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertFalse($listload->is_valid());
    }

    public function testListloadSubscribeInvalid() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = NULL;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = 100;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertFalse($listload->is_valid());
    }

    public function testListloadProfileUpdateInvalid() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = NULL;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = 100;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertFalse($listload->is_valid());
    }

    public function testListloadListLoadNameInvalid() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = NULL;
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = 100;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertFalse($listload->is_valid());
    }

    public function testListloadLoadModeInvalid() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'unknown-mode';
        $headers = false;
        $maxErrors = 100;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertFalse($listload->is_valid());
    }

    public function testListloadHeadersInvalid() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = NULL;
        $maxErrors = 100;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertFalse($listload->is_valid());
    }

    public function testListloadMaxErrorsLowerBoundValid() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = 1;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertTrue($listload->is_valid());
    }

    public function testListloadMaxErrorsLowerBoundInvalid() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = 0;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertFalse($listload->is_valid());
    }

    public function testListloadMaxErrorsInvalid() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = NULL;
        $errorType = 'ABSOLUTE';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertFalse($listload->is_valid());
    }

    public function testListloadErrorTypeInvalid() {
        $division = self::DIVISION;
        $datafileURI = 'datafile.csv';
        $subscribe = true;
        $profileUpdate = false;
        $listLoadName = 'Test Listload';
        $loadMode = 'INSERT_ONLY';
        $headers = false;
        $maxErrors = 100;
        $errorType = 'unknown-error-type';
        $listload = new YesmailListload($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode,
                                            $headers, $maxErrors, $errorType);
        $this->assertFalse($listload->is_valid());
    }
}
