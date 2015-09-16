<?php

require_once 'core/Route.php';
require_once 'core/Request.php';
require_once 'core/Engine.php';

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


$engine = new Engine($route, $request);



/*
$routes = $route->__get(routes);

echo '<pre>';
print_r($routes);
echo json_encode($routes);
echo '</pre>';

print_r($request->__get(query));

//params from url
$param = isset($_GET['uri']) ? $_GET['uri'] : '/';

foreach($routes as $key => $value){
	$temp = trim($value, '/');
	if(preg_match("#^$temp$#", $param)){
		echo 'match';
	}
}*/

?>
