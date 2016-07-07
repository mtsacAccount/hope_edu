<?php
    // Load from file or URL
    $file = '../resources/employees.xml';
    
    $employees = simplexml_load_file($file);
    
    
    echo "Total Employees: " . $employees->count() . '<hr>';
    
    foreach ($employees as $employee) {
        echo $employee->first . ' ' . $employee->last . '<br>';
    }
    
    
    
    echo '<pre>';
          // print_r($employees);
    echo '</pre>';
?>