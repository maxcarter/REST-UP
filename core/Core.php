<?php
/**
* 
*/
require_once 'Engine.php';

class Core
{
    var $engine;

    public function __construct(){
        $this -> engine = new Engine();
    }

    public function __call($name, $args){
        if (method_exists($this -> engine, $name)) {
            return call_user_func_array(array($this -> engine, $name), $args);            
        }
    }
}
?>