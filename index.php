<?php

require_once 'core/Route.php';
require_once 'core/Request.php';
require_once 'core/Router.php';

$request = new Request();
$route = new Route();




$route -> add("GET", "/", function(){});
$route -> add("GET", "/about", function(){
	echo 'hello world';
});

$route -> add("GET", "/max/a/:test/:hello", function($test, $hello){
	echo $test . '<br>';
	echo $hello . '<br>';
});


$router = new Router($route, $request);



?>
