<?php
	echo 'yo';

	$route -> add("GET", "/", function(){});
	$route -> add("GET", "/about", function(){
		echo 'hello world';
	});
	
	$route -> add("GET", "/max/a/:test/:hello", function($test, $hello){
		echo $test . '<br>';
		echo $hello . '<br>';
	});
?>