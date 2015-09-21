<?php

require_once 'Engine.php';

/**
 * The Core class is the representation of the custom
 * REST UP routing framework. It uses overloading to 
 * dynamically invoke methods within the framework.
 */
class Core {
    /**
     * @var object Framework Engine
     */
    var $engine;

    /**
     * Constructor
     */
    public function __construct() {
        $this -> engine = new Engine();
    }

    /**
     * Overloads method calls
     *
     * @param string $name Method name
     * @param array $args Method parameters
     * @return mixed Callback results
     */
    public function __call($name, $args){
        if (method_exists($this -> engine, $name)) {
            return call_user_func_array(array($this -> engine, $name), $args);            
        }
    }
}
?>