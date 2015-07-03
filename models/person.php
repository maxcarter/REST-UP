<?php
class Person {
    var $id, $Name, $City, $Email;

    public function __construct(){
        $this -> id = null;
        $this -> Name = null;
        $this -> City = null;
        $this -> Email = null;
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