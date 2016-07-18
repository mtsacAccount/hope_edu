<?php
/*
    This file contains the database access information. 
    This file also establishes a connection to MySQL,
    selects the database, and sets the encoding. 
*/
//  Set the database access information as constants
    DEFINE ('DB_USER', 'root');
    DEFINE ('DB_PASSWORD', '');
    DEFINE ('DB_HOST', 'localhost');
    DEFINE ('DB_NAME', 'mtsac');
    
    // Establish Database Connection or Error Out
    $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );
    // Set the character set 
    mysqli_set_charset($dbc, 'utf8');
?>
