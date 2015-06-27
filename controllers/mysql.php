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
        try {
            $mysqli = new mysqli($this -> host, $this -> username, $this -> password, $this -> database);
            $q = "SELECT * FROM " . $this -> table;
            $query_result = $mysqli->query($q);

            if ($mysqli->connect_errno) {
                throw new Exception("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
            }

            if(!$query_result) {
                $query_result -> free();
                $mysqli -> close();
                throw new Exception('Invalid MySQL Query '.$mysqli->error);
            }

            $values = array(); 
            while ($row = $query_result->fetch_assoc()) {
                $values[] = $row;
            }
            $query_result -> free();
            $mysqli -> close();

            $this -> response -> text = "Sucessfully queried " . $this -> table;
            $this -> response -> code = 200;
            $this -> response -> data = $values;
            
        }
        catch(Exception $e) {
            $this -> response -> text = "Error: " . $e->getMessage();
            $this -> response -> code = 500;
            $this -> response -> data = [];
        } 

        return $this -> response;
    }

    function getValue($value){
        try {
            $mysqli = new mysqli($this -> host, $this -> username, $this -> password, $this -> database);     
            
            if ($mysqli->connect_errno) {
                throw new Exception("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
            }

            $q = "SELECT * FROM " . $this -> table ." WHERE id=?";
            $stmt = $mysqli -> prepare($q);         
            $bind_params = $stmt -> bind_param('i', $value);
            $exec = $stmt -> execute();
            $store = $stmt -> store_result(); 

            // Nasty hack to replace mysqlnd get_result();
            $result = array();
            for($i = 0; $i < $stmt -> num_rows; $i++) {
                $metadata = $stmt -> result_metadata();
                $params = array();
                while($field = $metadata -> fetch_field()) {
                    $params[] = &$result[$i][$field -> name];
                }
                call_user_func_array(array($stmt, 'bind_result'), $params);
                $stmt -> fetch();
            }

            $query_result = $result;
    
            //$result = $stmt -> get_result();         
            //$query_result = $result->fetch_assoc();           
            
            $stmt -> free_result();  
            $stmt -> close();
            $mysqli -> close();

            if (sizeof($query_result) > 0) {
                $this -> response -> text = "id=$value has successfully loaded.";
                $this -> response -> code = 200;
                $this -> response -> data = $query_result;
            } else {
                $this -> response -> text = "Not Found: " . $e->getMessage();
                $this -> response -> code = 404;
                $this -> response -> data = [];
            }
            
        }
        catch(Exception $e) {
            $this -> response -> text = "Error: " . $e->getMessage();
            $this -> response -> code = 500;
            $this -> response -> data = [];
        } 
        return $this -> response; 
    }

    function putValues($data){
        $this -> response -> text = "Not Implemented";
        $this -> response -> code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function putValue($data){
        $this -> response -> text = "Not Implemented";
        $this -> response -> code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function postValues($data){
        $this -> response -> text = "Not Implemented";
        $this -> response -> code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function postValue($data){
        $this -> response -> text = "Not Implemented";
        $this -> response -> code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function deleteValues(){
        $this -> response -> text = "Not Implemented";
        $this -> response -> code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function deleteValue($value){
        $this -> response -> text = "Not Implemented";
        $this -> response -> code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }


}

?>