<?php
require_once 'Route.php';
require_once 'Request.php';
require_once 'Response.php';
require_once 'Router.php';


/**
 * The Engine class represents framework engine
 * and manages all methods and classes available. 
 */
class Engine {

    /**
     * @var object $route Framework Route
     * @var object $request Framework Request 
     * @var object $router Framework Router 
     * @var object $response Framework Response
     */
    var $route, $request, $router, $response;

    /**
     * Constructor
     */
    public function __construct() {
        $this -> route    = new Route();
        $this -> request  = new Request();
        $this -> response = new Resp();
    }

    /**
     * Adds a new route to the framework
     *
     * @param string $request HTTP request type
     * @param string $pattern the route
     * @param method $callback Callback Function
     */
    public function route($request, $pattern, $callback) {
        $this -> route -> add($request, $pattern, $callback);
    }

    /**
     * Returns the route object
     *
     * @return object The Route object
     */
    public function getRoutes() {
        return $this -> route;
    }

    /**
     * Returns the request object
     *
     * @return object The Request object
     */
    public function getRequest() {
        return $this -> request;
    }

    /**
     * Returns the POST data of the current request
     *
     * @return array The POST data
     */
    public function getRequestData() {
        return $this -> request -> __get(data);
    }

    /**
     * Starts the framework by initializing the Router
     */
    public function start() {
        $router = new Router($this -> getRoutes(), $this -> getRequest());
    }

    /**
     * Sends response in JSON format
     *
     * @param array  $data The Response data
     * @param number $code Status Code
     * @param bool   $encode Encoding boolean
     */    
    public function json($data, $code = 200, $encode = true) {
        $json = ($encode) ? json_encode($data) : $data;
        $this -> response -> status($code);
        $this -> response -> setHeaders('Content-Type', 'application/json');
        $this -> response -> write($json);
        $this -> response -> send();
    }
}
?>