<?php
    
     // Load from file or URL
    $file = '../resources/employees.xml';
    // convert file and root level to simple xml obj
    $employees = simplexml_load_file($file);
    
    // Establish database connection
    $mysqli = new mysqli('localhost', 'root', '', 'mtsac');
    $mysqli->set_charset('utf8');
    
    // Build Query
    $query = "INSERT INTO `employees_2` 
    (last_name, first_name, phone, dept_name, location, title, email, type)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Prep statement
    $stmt = $mysqli->prepare($query);
    
    // counter to keep track of employees
    $counter = 0;
    // Iterate over each object and add it to database
    foreach ($employees as $employee) {
        // Bind the variables 'ssssss' -> all field inputs will be strings
        $stmt -> bind_param('ssssssss', $lname, $fname, $phone, $dept_name, $location, $title, $email, $type);
        
        $lname = $employee->last;
        $fname = $employee->first;
        $phone = $employee->phone;
        $dept_name = $employee->assignment;
        $location = $employee->office;
        $title = '';
        $email = $employee->email;
        $type = $employee->type;
        
        // Execute the statement
        $stmt->execute();
        // Update Counter
        $counter++;
    }
    
     // Close the statement
     $stmt->close();
     unset($stmt);
         
     // Close the connection
     $mysqli->close();
     unset($mysqli);
     
     echo "There were $counter employees added to the database!";

?>