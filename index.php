<?php

require_once 'flight-master/flight/Flight.php';
require_once 'config/config.php';
require_once 'controllers/mysql.php';
require_once 'models/response.php';

function connect(){
    return new MySQL_CTRL(HOST, USERNAME, PASSWORD, DATABASE, TABLE);
}

Flight::set('db', connect());

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::route('/test', function(){
    $db = Flight::get('db'); 
    Flight::json($db, 200);  
});


Flight::route('GET /'.TABLE, function(){
    $db = Flight::get('db');    
    $response=$db->getValues();
    $status_code = $response -> status_code;    
    Flight::json($response, $status_code); 
});


Flight::start();

?>