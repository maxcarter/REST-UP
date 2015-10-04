<?php

$app -> route("GET", "/example", function() use (&$app){
    echo "This is an example plugin route.";
});

?>