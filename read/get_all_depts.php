<?php
    // connect to the database
    //require_once('../includes/mysqli_connect.php');
    // query string
    $q = 'SELECT `dept_name` FROM `employees_2`';
    $r = mysqli_query($dbc, $q);
    // Initialize array to put depratments in
    $departments = array();
    
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            
          $current_dept = $row['dept_name'];
          if (!in_array($current_dept, $departments)) {
              $departments[] = $current_dept;
          }
          
    }
    mysqli_free_result($r);
    mysqli_close($dbc);
    
    sort($departments);
    
    $fp = fopen('../resources/all_depts.json', 'w');
    fwrite($fp, json_encode($departments));
    fclose($fp);
    
?>