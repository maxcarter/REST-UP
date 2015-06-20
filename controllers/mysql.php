<?php

class MySQL_CTRL {
    var $host, $username, $password, $database, $table;

    public function __construct($host, $username, $password, $database, $table){
        $this -> host = $host;
        $this -> username = $username;
        $this -> password = $password;
        $this -> database = $database;
        $this -> table = $table;
    }
}

?>