<?php
    // Load from file or URL
    $file = '../resources/employees.xml';
    $employees = simplexml_load_file($file);
    $departments = array();
    
    foreach ($employees as $employee) {
       $department = (string) $employee->assignment;
       // check if department is already in array
       if (!in_array($department, $departments))
       {
           // if not in array, add department
           $departments[] = $department;
       }
       
    }
    
    sort($departments);
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    // echo '<pre>';
    //       print_r($departments);
    // echo '</pre>'; 
    
    /* 
    * Code to add the list of departments into MySQL
    * Already added so code is now commented out
    * and kept just for referenced. 
    *
    */
    
    // $mysqli = new mysqli('localhost', 'root', '', 'mtsac');
    // $mysqli -> set_charset('utf8');
    
    // // Build query
    // $query = "INSERT INTO `all_departments` (dept_name) VALUES (?)";
    
    // // Prep Statement
    // $stmt = $mysqli -> prepare($query);
    
    // // counter to keep track of departments
    // $counter = 0;
    
    
    // foreach ($departments as $dept) {
    //     $stmt -> bind_param('s', $dept_name); 
    //     $dept_name = (string) $dept;
    //     $stmt->execute();
    //     $counter++;
    // }
    
    //  // Close the statement
    //  $stmt->close();
    //  unset($stmt);
         
    //  // Close the connection
    //  $mysqli->close();
    //  unset($mysqli);
   
    //   echo "There were $counter departments added to the database!";
    
?>