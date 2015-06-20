<?php
class Response{
    var $code, $text, $data;

    public function __construct(){
        $this -> code = 500;
        $this -> text = "";
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