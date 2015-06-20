<?php

class MySQL_CTRL {
    var $host, $username, $password, $database, $table;

    public function __construct($host, $username, $password, $database, $table){
        $this -> host = $host;
        $this -> username = $username;
        $this -> password = $password;
        $this -> database = $database;
        $this -> table = $table;

        $this -> response = new Response();
    }

    function getValues(){
        $this -> response -> message = "Not Implemented";
        $this -> response -> status_code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function getValue($value){
        $this -> response -> message = "Not Implemented";
        $this -> response -> status_code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function putValues($data){
        $this -> response -> message = "Not Implemented";
        $this -> response -> status_code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function putValue($data){
        $this -> response -> message = "Not Implemented";
        $this -> response -> status_code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function postValues($data){
        $this -> response -> message = "Not Implemented";
        $this -> response -> status_code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function postValue($data){
        $this -> response -> message = "Not Implemented";
        $this -> response -> status_code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function deleteValues(){
        $this -> response -> message = "Not Implemented";
        $this -> response -> status_code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function deleteValue($value){
        $this -> response -> message = "Not Implemented";
        $this -> response -> status_code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }


}

?>