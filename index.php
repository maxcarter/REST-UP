<?php

require_once 'core/Route.php';
require_once 'core/Request.php';
require_once 'core/Router.php';

require_once 'config/config.php';
require_once 'controllers/' . CTRL;

$request = new Request();
$route = new Route();

// Import all models
$models_dir = './models';
$models = scandir($models_dir);
foreach($models as $file){
    if (strpos($file,'.php') !== false) {
        require_once $models_dir . '/' . $file;
    } 
}

function connect(){
    return new Controller(HOST, USERNAME, PASSWORD, DATABASE, TABLE);
}


$route -> add("GET", "/", function(){
	echo "Welcome!";
});

$route -> add("GET", "/".TABLE, function(){
	$db = connect();
    $response=$db->getValues();
    $code = $response -> code;    
    print_r(json_encode($response)); 
});


$router = new Router($route, $request);



?>
