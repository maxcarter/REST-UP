<?php

require_once 'flight/Flight.php';

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::start();

?>