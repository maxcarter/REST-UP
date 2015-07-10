<?php

require_once 'flight/flight/Flight.php';
require_once 'config/config.php';
require_once 'controllers/' . CTRL;

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

Flight::set('db', connect());

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::route('GET /'.TABLE, function(){
    $db = Flight::get('db');    
    $response=$db->getValues();
    $code = $response -> code;    
    Flight::json($response, $code); 
});

Flight::route('GET /'.TABLE.'/id/@id', function($id){
    $db = Flight::get('db');
    $response=$db->getValue($id);
    $code = $response -> code;    
    Flight::json($response, $code); 
});

Flight::route('PUT /'.TABLE, function(){
    $db = Flight::get('db');    
    $request = Flight::request();    
    $response = $db->putValue($request->data);
    $code = $response -> code;   
    Flight::json($response, $code); 
});

Flight::route('POST /'.TABLE, function(){
    $db = Flight::get('db');    
    $request = Flight::request();    
    $response = $db->postValue($request->data);
    $code = $response -> code;   
    Flight::json($response, $code); 
});

Flight::route('DELETE /'.TABLE.'/id/@id', function($id){
    $db = Flight::get('db');    
    $response=$db->deleteValue($id);
    $code = $response -> code;    
    Flight::json($response, $code);  
});

Flight::start();

?>