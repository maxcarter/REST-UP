<?php
require_once 'Route.php';
require_once 'Request.php';
require_once 'Response.php';
require_once 'Router.php';

class Engine
{
    var $route, $request, $router;

    public function __construct()
    {
        $this -> route = new Route();
        $this -> request = new Request();
    }
    public function route($request, $pattern, $callback){
        $this -> route -> add($request, $pattern, $callback);
    }
    public function getRoutes(){
        return $this -> route;
    }
    public function getRequest(){
        return $this -> request;
    }
    public function start(){
        $router = new Router($this -> getRoutes(), $this -> getRequest());
    }
}
?>