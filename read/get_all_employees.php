<?php
     // connect to database
    //require_once('../includes/mysqli_connect.php');
    // query string
    $q = "SELECT * FROM employees_2 ORDER BY `last_name` ASC";
    $r = mysqli_query($dbc, $q);
    // Initialize master array
    $people = array();
    
    
    while ( $row = mysqli_fetch_array($r, MYSQLI_ASSOC) ) {
        $person = array();
        $person['last_name'] = $row['last_name'];
        $person['first_name'] = $row['first_name'];
        $person['phone'] = $row['phone'];
        $person['dept_name'] = $row['dept_name'];
        $person['location'] = $row['location'];
        $person['email'] = $row['email'];
        $person['type'] = $row['type'];
        $people[] = $person;
        
     }
     
    mysqli_free_result($r);
    mysqli_close($dbc);

    //  echo "<pre>";
    //         print_r($people);
    //  echo "</pre>"
    
    $fp = fopen('../resources/all_employees.json', 'w');
    fwrite($fp, json_encode($people));
    fclose($fp);

?>