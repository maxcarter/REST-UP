<?php

class MySQL_CTRL {
    var $host, $username, $password, $database, $table, $connection;

    public function __construct($host, $username, $password, $database, $table){
        $this -> host = $host;
        $this -> username = $username;
        $this -> password = $password;
        $this -> database = $database;
        $this -> table = $table;
        $this -> response = new Response();

        // Establish MySQL connection
        $this -> connection = new mysqli($this -> host, $this -> username, $this -> password, $this -> database);

        // Custom DTO
        $this -> schema = new Person();
    }
 
    function getType($value) {
        switch (gettype($value)) {
            case "string":
                $type = 's';
                break;
            case "integer":
                $type = 'i';
                break;
            case "double":
                $type = 'd';
                break;
            case "boolean":
                $type = 'b';
                break;
            case "NULL":
                $type = 's';
                break;
            default:
                $type = "s";
        }
        return $type;
    }

    function getValues(){
        try {
            $mysqli = $this -> connection;
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
            $mysqli = $this -> connection;
            
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
        try {
            $mysqli = $this -> connection;

            if ($mysqli->connect_errno) {
                throw new Exception("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
            }

            // Ugly method of using DTO to validate data and construct SQL string
            // Refactor to include validation for invalid JSON
            $k = "";
            $v = "";
            $u = "";
            $types = "";
            $valueArray = [];
            foreach($this -> schema as $key => $value) {
                $this -> schema -> __set($key, $data[$key]);

                // Constructs SQL keys and values strings
                $k .= $key . ", ";
                $v .= "?, ";
                $u .= $key . " = VALUES(" . $key . "), ";
                $types .= $this -> getType($this -> schema ->__get($key));

                array_push($valueArray, $this -> schema ->__get($key));
            }
            $k = rtrim($k, ', ');
            $v = rtrim($v, ', ');
            $u = rtrim($u, ', '); 

            $q =  "INSERT INTO " . $this -> table . "(" . $k . ") VALUES(" . $v . ") ON DUPLICATE KEY UPDATE " . $u;
            $stmt = $mysqli->prepare($q);  
            
            // Use bind_param to avoid injection
            $params[] = & $types;
            for($i = 0; $i < sizeof($valueArray); $i++) {
                $params[] = & $valueArray[$i];
            }       
            call_user_func_array(array($stmt, 'bind_param'), $params);
            $exec = $stmt->execute();
        
            if(!$stmt || !$exec) {
                $stmt->close();
                $mysqli->close();
                throw new Exception($mysqli->error);
            }
        
            $stmt->close();
            $mysqli->close();

            $this -> response -> text = "PUT successfully completed";
            $this -> response -> code = 200;
            $this -> response -> data = [];
        }
        catch(Exception $e) {
            $this -> response -> text = "Error: " . $e->getMessage();
            $this -> response -> code = 500;
            $this -> response -> data = [];
        } 
    
        return $this -> response;
    }

    function postValues($data){
        $this -> response -> text = "Not Implemented";
        $this -> response -> code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function postValue($data){
        try {
            $mysqli = $this -> connection;

            if ($mysqli->connect_errno) {
                throw new Exception("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
            }

            // Ugly method of using DTO to validate data and construct SQL string
            // Refactor to include validation for invalid JSON
            $k = "";
            $v = "";
            $types = "";
            $valueArray = [];
            foreach($this -> schema as $key => $value) {
                if($key != 'id') {
                    $this -> schema -> __set($key, $data[$key]);

                    // Constructs SQL keys and values strings
                    $k .= $key . ", ";
                    $v .= "?, ";
                    $types .= $this -> getType($this -> schema ->__get($key));

                    array_push($valueArray, $this -> schema ->__get($key));
                }
            }
            $k = rtrim($k, ', ');
            $v = rtrim($v, ', ');

            $q =  "INSERT INTO " . $this -> table . "(" . $k . ") VALUES(" . $v . ")";
            $stmt = $mysqli->prepare($q);  
            
            // Use bind_param to avoid injection
            $params[] = & $types;
            for($i = 0; $i < sizeof($valueArray); $i++) {
                $params[] = & $valueArray[$i];
            }       
            call_user_func_array(array($stmt, 'bind_param'), $params);
            $exec = $stmt->execute();
        
            if(!$stmt || !$exec) {
                $stmt->close();
                $mysqli->close();
                throw new Exception($mysqli->error);
            }
        
            $stmt->close();
            $mysqli->close();

            $this -> response -> text = "POST successfully completed";
            $this -> response -> code = 200;
            $this -> response -> data = [];
        }
        catch(Exception $e) {
            $this -> response -> text = "Error: " . $e->getMessage();
            $this -> response -> code = 500;
            $this -> response -> data = [];
        } 
    
        return $this -> response;
    }

    function deleteValues(){
        $this -> response -> text = "Not Implemented";
        $this -> response -> code = 501;
        $this -> response -> data = [];
        return $this -> response;
    }

    function deleteValue($value){
        try {
            $mysqli = $this -> connection;

            if ($mysqli->connect_errno) {
                throw new Exception("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
            }

            $q = "DELETE FROM " . $this -> table ." WHERE id=?";
            $stmt = $mysqli -> prepare($q);
            $bind_params = $stmt -> bind_param('i', $value);        
            $exec = $stmt -> execute();

            if(!$stmt || !$bind_params || !$exec) {
                throw new Exception('Invalid MySQL Query '.$mysqli -> error);
            }  

            $stmt->close();
            $mysqli->close();

            $this -> response -> text = "id=$value has successfully been deleted.";
            $this -> response -> code = 200;
            $this -> response -> data = [];  
        }
        catch(Exception $e){
            $this -> response -> text = "Error: " . $e->getMessage();
            $this -> response -> code = 500;
            $this -> response -> data = [];
        } 
                
        return $this -> response;
    }
}

?>