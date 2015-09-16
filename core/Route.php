<?php

/**
* 
*/
class Route
{
    
    var $routes, $request;

    public function __construct(){  
        $this->routes = array();
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

    public function add($request, $pattern, $callback){
        //add some security here
        $this->routes[] = array(
                'route' => $pattern,
                'type' => $request,
                'callback' => $callback
            );

    }

}

?>