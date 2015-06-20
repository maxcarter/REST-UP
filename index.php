<?php

require_once 'flight-master/flight/Flight.php';

Flight::route('/', function(){
    echo 'hello world!';
});

Flight::start();

?>