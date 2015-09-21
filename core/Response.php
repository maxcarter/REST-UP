<?php

/**
 * The Resp class sends the http response
 * from the framework
 */
class Resp {
    /**
     * @var number $status HTTP status code
     * @var array $codes List of all valid HTTP status codes
     * @var array $headers List of headers
     * @var array $body Response body
     */
    var $status, $codes, $headers, $body;

    /**
     * Constructor
     */
    public function __construct() {  
        $this -> headers = array();
        $this -> status  = 200;
        $this -> codes   = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Switch Proxy',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            425 => 'Unordered Collection',
            426 => 'Upgrade Required',
            449 => 'Retry With',
            450 => 'Blocked by Windows Parental Controls',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            509 => 'Bandwidth Limit Exceeded',
            510 => 'Not Extended'
        );
    }

    /**
     * Get magic accessor method
     *
     * @param mixed $property The variable to accessed
     * @return mixed The variable 
     */
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     * Sets the status code
     *
     * @param  number $code The status code
     * @return number The status code
     */
    public function status($code = null) {
        if (array_key_exists($code, $this -> $codes) && $code != null) {
            $this -> status = $code;
        }
        return $this -> status;
    }

    /**
     * Sets the headers
     *
     * @param string $name Header name
     * @param string $value Header value
     */
    public function setHeaders($name, $value = null) {
        if (is_array($name)) {
            foreach ($name as $key => $val) {
                $this -> headers[$key] = $val;
            }
        } else {
            $this -> headers[$name] = $value;
        }
        return $this;
    }

    /**
     * Sets the body of the response
     *
     * @param array $content Response body
     */
    public function write($content) {
        $this -> body = $content;
        return $this;
    }


    /**
     * Sends the response
     */
    public function send() {

        //Send Headers 
        if (!headers_sent()) {
            //status code
            if (strpos(php_sapi_name(), 'cgi') !== false) {
                header("Status: " + $this -> status + " " + $this -> codes[$this -> status], true);
            } else {
                $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1');
                header($protocol + " " + $this -> status + " " + $this -> codes[$this -> status], true, $this->status);
            }

            //headers
            foreach ($this -> headers as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        header($key . ': ' . $v, false);
                    }
                } else {
                    header($key . ': ' . $value);
                }
            }

            //content length
            $length = strlen($this -> body);
            if ($length > 0) {
                header('Content-Length: ' . $length);
            }
        }

        exit($this -> body);
    }
}
?>