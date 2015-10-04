<?php
    // Database Credentials
    define("HOST", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "root");
    define("DATABASE", "sample");
    define("TABLE", "person"); // Default table

    // Note: Every defined table must have a corresponding model defined in the models directory.
    // Note: The model file name must match table name. Case sensitive 
    $TABLES = array(
        "person"
    );

    // Controller
    define("CTRL", "mysql.php");
?>