<?php
   // $string = file_get_contents("../resources/all_depts.json");
    $departments = json_decode($string, true);
    $departments = $departments['departments'];
    // echo "<pre>";
    //         print_r($departments);
    // echo "</pre>";
    
    // Need to build master obj with each dept as a property and 
    // an empty array as it value
    
    $master_obj = array();
    
    foreach($departments as $department) {
             $master_obj[$department] = array();
             
    }
    
    // echo "<pre>";
    //       var_dump($master_obj);
    // echo "</pre>";
    // $master_obj is an associative array with each department as the 
    // key and an empty array as it's value;
    
    
    // connect to db and write query
   // include('../includes/mysqli_connect.php');
    
    
    
    foreach(array_keys($master_obj) as $dept) {
         $q = "SELECT * FROM `employees_2` WHERE `dept_name`= '$dept' ";
         $r = mysqli_query($dbc, $q);
         
         
         while( $row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
             $employee = array();
             $employee['first_name'] = $row['first_name'];
             $employee['last_name'] = $row['last_name'];
             $employee['phone'] = $row['phone'];
             $employee['dept_name'] = $row['dept_name'];
             $employee['location'] = $row['location'];
             $employee['email'] = $row['email'];
             $employee['type'] = $row['type'];
             $master_obj[$dept][] = $employee;
         }
       
    }
    
    mysqli_free_result($r);
    mysqli_close($dbc);
    
    // echo "<pre>";
    //         print_r($master_obj);
    // echo "</pre>"
    
    $fp = fopen('../resources/column_4_data.json', 'w');
    fwrite($fp, json_encode($master_obj));
    fclose($fp);
    
    
?>