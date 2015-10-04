<?php

require_once 'core/Core.php';
require_once 'config/config.php';
require_once 'controllers/' . CTRL;

$app = new Core();

// Import all models
$models_dir = './models';
$files = scandir($models_dir);
$models = array();
foreach($files as $file){
    if (strpos($file,'.php') !== false) {
        array_push($models, $file);
        require_once $models_dir . '/' . $file;
    } 
}

function connect ($table = TABLE, $host = HOST, $username = USERNAME, $password = PASSWORD, $database = DATABASE) {
    return new Controller($host, $username, $password, $database, $table);
}

$app -> route("GET", "/", function() use (&$app){
    echo "Welcome!";
});

foreach ($TABLES as $table) {
    if(in_array($table . ".php", $models)){
        $app -> route("GET", "/".$table, function() use (&$app, $table){
            $db = connect($table);
            $response = $db -> getValues();
            $code = $response -> code;    
            $app -> json($response, $code);
        });
        
        $app -> route("GET", "/".$table."/id/:id", function($id) use (&$app, $table){
            $db = connect($table);
            $response = $db -> getValue($id);
            $code = $response -> code;    
            $app -> json($response, $code);
        });
        
        $app -> route("PUT", "/".$table, function() use (&$app, $table){
            $db = connect($table); 
            $data = $app -> getRequestData();
            $response = $db->putValue($data);
            $code = $response -> code;   
            $app -> json($response, $code); 
        });
        
        $app -> route("POST", "/".$table, function() use (&$app, $table){
            $db = connect($table); 
            $data = $app -> getRequestData();
            $response = $db->postValue($data);
            $code = $response -> code;   
            $app -> json($response, $code); 
        });
        
        $app -> route("DELETE", "/".$table."/id/:id", function($id) use (&$app, $table){
            $db = connect($table);
            $response = $db -> deleteValue($id);
            $code = $response -> code;    
            $app -> json($response, $code);
        });
    }
}

require_once 'plugins/routes.php';

$app -> start();

?>
