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


$app -> route("GET", "/", function(){
    echo "Welcome!";
});

$app -> route("GET", "/".TABLE, function(){
    $db = connect();
    $r=$db->getValues();
    $code = $r -> code;    
    print_r(json_encode($r)); 
});



$app -> start();

?>
