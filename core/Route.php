<?php

/**
 * The Route class handles all route content
 */
class Route {

    /**
     * @var array $routes Contains all defined routes
     */
    var $routes;

    /**
     * Constructor
     */
    public function __construct(){  
        $this -> routes = array();
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
            $this -> $property = $value;
        }
        return $this;
    }

    /**
     * Pushes a new route to the routes array
     *
     * @param string $request The route request method
     * @param string $pattern The route URI
     * @param method $callback The callback function
     */
    public function add($request, $pattern, $callback) {
        $valid_requests = array("GET", "PUT", "POST", "DELETE", "OPTIONS", "HEAD", "TRACE", "CONNECT");
        if (is_string($request) && is_string($pattern) && is_callable($callback)) {
            if (in_array(strtoupper($request), $valid_requests)) {
                $this -> routes[] = array(
                    'route'    => $pattern,
                    'type'     => $request,
                    'callback' => $callback
                );
            }
        }
    }
}
?>