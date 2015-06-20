<?php
class Response{
    var $status_code, $message, $data;

    public function __construct(){
        $this -> status_code = 500;
        $this -> message = "";
        $this -> data = null;
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }
}
?>