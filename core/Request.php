<?php

/**
 * The Request class handles the http 
 * request content
 */
class Request {

    /**
     * @var string $url The URL fo the request
     * @var string $type The type of the request
     * @var string $method The method of the request
     * @var number $length The length of the content
     * @var array  $query An array containing the compenents of the requested route
     * @var array  $data The posted data
     */
    var $url, $type, $length, $query, $data, $method;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this -> url    = $this -> getVar('REQUEST_URI', '/');
        $this -> type   = $this -> getVar('CONTENT_TYPE');
        $this -> method = $this -> getVar('REQUEST_METHOD');
        $this -> length = $this -> getVar('CONTENT_LENGTH', 0);
        $this -> query  = explode("/", rtrim($_REQUEST['uri'], '/'));
        $this -> data   = $_POST;
    }

    /**
     * Get magic accessor method
     *
     * @param mixed $property The variable to accessed
     * @return mixed The variable 
     */
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this -> $property;
        }
    }

    /**
     * Set magic mutator method
     *
     * @param mixed $property The variable to mutated
     * @param mixed $value The value to be assigned to the mutated variable
     */
    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }

    /**
     * Returns server variables 
     *
     * @param string $var The name of the server variable 
     * @param string $default The default value
     * @param mixed The server variable or the default value
     */
    public function getVar($var, $default = '') {
        if (isset($_SERVER[$var])) {
            return $_SERVER[$var];
        } else {
            return $default;
        }
    }
}

?>