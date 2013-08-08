<?php
namespace Yesmail;
/**
 * YesmailListload
 *
 * A helper class for the Yesmail Listload API
 *
 * @author Casey Powell <cpowell@popsugar.com>
 * @version 0.1
 * @copyright Copyright (c) 2013 Sugar Inc.
 * @link https://github.com/PopSugar/php-yesmail-api
 */
class YesmailListload implements \JsonSerializable {

    /**
     * @var array A list of supported load modes
     */
    public static $ListloadLoadModes = array('INSERT_ONLY', 'UPDATE_ONLY', 'INSERT_UPDATE');

    /**
     * @var array A list of supported error types
     */
    public static $ListloadErrorTypes = array('ABSOLUTE', 'RELATIVE');

    // Required
    protected $division;
    protected $datafileURI;
    protected $subscribe;
    protected $profileUpdate;
    protected $listLoadName;
    protected $loadMode;
    protected $headers;
    protected $maxErrors;
    protected $errorType;

    //Optional

    /**
     * Construct a new YesmailMasterEnvelope object
     *
     * @param string $division This value is the division display name.
     * @param string $datafileURI The uri to the data file to import or the file name of a file that already exists on
     *                            the Infogroup ftp site. You must specify the protocol as ftp:// (ie not sftp://).
     * @param bool $subscribe true = subscribe the user to the division
     *                        false = do not subscribe the user to the division. If subscribe is not provided in the
     *                                payload, the value will default to true.
     * @param bool $profileUpdate true = update the user profile
     *                            false = do not update the user profile. If profileUpdate is not provided in the
     *                            payload, the value will default to false.
     * @param string $listLoadName The name of the list load. It can be a name that already exists in Enterprise for
     *                             the client or a new list load name.
     * @param string $loadMode INSERT_ONLY = Only insert new users from the datafile, if a user is already in the system
     *                                       then that record is unchanged.
     *                         UPDATE_ONLY = Only update existing user records, no new users are created. (Currently
     *                                       updates are unsupported)
     *                         INSERT_UPDATE = if the record is preexisting, then it is updated otherwise a new user is
     *                                         inserted.
     * @param bool $headers true = the data file has column headers
     *                      false = the data file does not have column headers.
     *                      If headers is not provided in the payload, the value will default to false.
     * @param int $maxErrors A positive number indicating the number of rows in the data file can contain errors out
     *                       before the import is aborted.
     * @param string $errorType ABSOLUTE = The maxErrors value refers to the actual number of rows in the data file that
     *                                     can encounter an error.
     *                          RELATIVE = The maxErrors value refers to a percentage of rows in the data file that can
     *                                     encounter an error.
     * @access public
     */
    public function __construct($division, $datafileURI, $subscribe, $profileUpdate, $listLoadName, $loadMode, $headers,
                                    $maxErrors, $errorType) {
        if (is_string($division) === true) {
            $this->division = $division ;
        } else {
            $this->division = NULL;
        }

        if (is_string($datafileURI) === true) {
            $this->datafileURI = $datafileURI;
        } else {
            $this->datafileURI = NULL;
        }

        if (is_bool($subscribe) === true) {
            $this->subscribe = $subscribe;
        } else {
            $this->subscribe = NULL;
        }

        if (is_bool($profileUpdate) === true) {
            $this->profileUpdate = $profileUpdate;
        } else {
            $this->profileUpdate = NULL;
        }

        if (is_string($listLoadName) === true) {
            $this->listLoadName = $listLoadName;
        } else {
            $this->listLoadName = NULL;
        }

        if (in_array($loadMode, self::$ListloadLoadModes) === true) {
            $this->loadMode = $loadMode;
        } else {
            $this->loadMode = NULL;
        }

        if (is_bool($headers) === true) {
            $this->headers = $headers;
        } else {
            $this->headers = NULL;
        }

        if (is_int($maxErrors) === true && $maxErrors > 0) {
            $this->maxErrors = $maxErrors;
        } else {
            $this->maxErrors = NULL;
        }

        if (in_array($errorType, self::$ListloadErrorTypes) === true) {
            $this->errorType = $errorType;
        } else {
            $this->errorType = NULL;
        }

        return;
    }

    /**
     * Validates a listload
     *
     * @return bool True if the listload is valid, false otherwise
     * @access public
     */
    public function is_valid() {
        $ret = false;

        if (is_null($this->division) === false && is_null($this->datafileURI) === false &&
            is_null($this->subscribe) === false && is_null($this->profileUpdate) === false &&
            is_null($this->listLoadName) === false && is_null($this->loadMode) === false &&
            is_null($this->headers) === false && is_null($this->maxErrors) === false &&
            is_null($this->errorType) === false
        ) {
            $ret = true;
        }

        return $ret;
    }

    /**
     * Return a json_encode able version of the object
     *
     * @return object A version of the object that is ready for json_encode
     * @access public
     */
    public function jsonSerialize() {
        $ret = new \stdClass();

        $ret->division = $this->division;
        $ret->datafileURI = $this->datafileURI;
        $ret->subscribe = $this->subscribe;
        $ret->profileUpdate = $this->profileUpdate;
        $ret->listLoadName = $this->listLoadName;
        $options = array();
        $options['loadMode'] = $this->loadMode;
        $options['headers'] = $this->headers;
        $options['maxErrors'] = $this->maxErrors;
        $options['errorType'] = $this->errorType;
        $ret->options = $options;

        return $ret;
    }
}
