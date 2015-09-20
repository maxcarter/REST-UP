<?php

require_once 'core/Core.php';

require_once 'config/config.php';
require_once 'controllers/' . CTRL;

$app = new Core();



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


$app -> route("GET", "/", function() use (&$app){
    echo "Welcome!";
});

$app -> route("GET", "/".TABLE, function() use (&$app){
    $db = connect();
    $response = $db -> getValues();
    $code = $response -> code;    
    $app -> json($response, $code);
});

$app -> route("GET", "/".TABLE."/id/:id", function($id) use (&$app){
    $db = connect();
    $response = $db -> getValue($id);
    $code = $response -> code;    
    $app -> json($response, $code);
});


$app -> route("POST", "/".TABLE, function() use (&$app){
    $db = connect(); 
    $data = $app -> getRequestData();
    $response = $db->postValue($data);
    $code = $response -> code;   
    $app -> json($response, $code); 
});


$app -> start();

?>
