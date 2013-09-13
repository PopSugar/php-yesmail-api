<?php
namespace Yesmail;
/**
 * CurlClient
 *
 * A simple PHP wrapper for making HTTP requests using cURL
 *
 * @author Casey Powell <cpowell@popsugar.com>
 * @copyright Copyright (c) 2013 Sugar Inc.
 */
class CurlClient {

    /**
     * @var resource A curl handle.
     */
    protected $_ch;

    /**
     * @var string Username for request authentication.
     */
    protected $_username;

    /**
     * @var string Password for request authentication.
     */
    protected $_password;

    /**
     * @var mixed The info from the last HTTP request, or FALSE on failure
     */
    protected $_last_info;

    /**
     * Construct a new CurlClient object to communicate with Enterprise web services.
     *
     * @param string $username Username for HTTP authentication.
     * @param string $password Password for HTTP authentication.
     */
    public function __construct($username, $password) {
        $this->_username = $username;
        $this->_password = $password;
        $this->_initialize();
    }

    /**
     * Perform an HTTP GET
     *
     * @param string $url The URL to send the GET request to.
     * @param array $data An array of parameters to be added to the query string.
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function get($url, $data) {
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->_ch, CURLOPT_URL, sprintf( "%s?%s", $url, http_build_query($data, '', '&', PHP_QUERY_RFC3986)));
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array("Accept:application/json", "Content-Type: application/json"));

        return $this->_exec();
    }

    public function put($url, $data) {
        $data_string = json_encode($data);
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->_ch, CURLOPT_URL, $url);
        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        return $this->_exec();
    }

    /**
     * Perform an HTTP POST
     *
     * @param string $url The URL to send the POST request to.
     * @param mixed $data An object or array of parameters. These parameters are json_encoded and sent in the request
     *                    body.
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function post($url, $data) {
        $data_string = json_encode($data);
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->_ch, CURLOPT_URL, $url);
        curl_setopt($this->_ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );

        return $this->_exec();
    }

    /**
     * Perform an HTTP DELETE
     *
     * @param string $url The URL to send the DELETE request to.
     * @param mixed $data An array of parameters to be added to the query string.
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access public
     */
    public function delete($url, $data) {
        curl_setopt($this->_ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($this->_ch, CURLOPT_URL, sprintf("%s?%s", $url, http_build_query($data, '', '&', PHP_QUERY_RFC3986)));
        curl_setopt($this->_ch, CURLOPT_HTTPHEADER, array("Accept:application/json", "Content-Type: application/json"));

        return $this->_exec();
    }

    /**
     * Get the info from the last cURL request.
     *
     * @return mixed Either the info from the last cURL request, or FALSE if the request failed.
     * @access public
     */
    public function get_info() {
        return $this->_last_info;
    }

    /**
     * Initialize the curl resource and options
     *
     * @return void
     * @access protected
     */
    protected function _initialize() {
        $this->_ch = curl_init();
        $this->_last_info = FALSE;
        curl_setopt($this->_ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->_ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->_ch, CURLOPT_USERPWD, "{$this->_username}:{$this->_password}");

        return;
    }

    /**
     * Execute a curl request. Maintain the info from the request in a variable
     *
     * @return mixed A JSON decoded PHP variable representing the HTTP response.
     * @access protected
     * @throws Exception
     */
    protected function _exec() {
        $response = curl_exec($this->_ch);
        $this->_last_info = curl_getinfo($this->_ch);
        $error = curl_error( $this->_ch );
        if ( $error ) {
            throw new \Exception($error);
        }

        return $response;
    }
}
