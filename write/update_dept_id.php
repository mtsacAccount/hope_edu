<?php
    function db_connect() {
       // Establish database connection
       $mysqli = new mysqli('localhost', 'root', '', 'mtsac');
       $mysqli->set_charset('utf8');
           if (!$mysqli) {
              return false;
           }
       $mysqli->autocommit(TRUE);
       return $mysqli;
    }
    
    function results_to_array($result) {
       $res_array = array();
       for ($count=0; $row = $result->fetch_assoc(); $count++) {
         $res_array[$count] = $row;
       }
        return $res_array;
    }
    
    
    function getDeptNames() {
        $conn = db_connect();
        $query = "SELECT * FROM `all_departments`";
        // 
        $result = @$conn->query($query);
        if (!$result) {
            return false;
        }
        $num_cats = @$result->num_rows;
        if ($num_cats == 0) {
           return false; 
        }
        $result = results_to_array($result);
        return $result;
    }
    
    function getEmployeeDepts() {
        $conn = db_connect();
        $query = "SELECT `dept_name`, `dept_id` FROM `employees_2`";
        $result = @$conn->query($query);
        if (!$result) {
            return false;
        }
        $num_cats = @$result->num_rows;
        if ($num_cats == 0) {
           return false; 
        }
        $result = results_to_array($result);
        return $result;
    }
    
     function updateEmployeeDeptId($id, $name) {
          $conn = db_connect();
          $query = "UPDATE `employees_2` SET dept_id=$id WHERE `dept_name`=$name";
          $result = @$conn->query($query);
          if (!$result) {
            return false;
            }
           $num_cats = @$result->num_rows;
            if ($num_cats == 0) {
               return false; 
            }
            $result = results_to_array($result);
            return $result;
         }
    
    
    $departments = getDeptNames();
    $employees = getEmployeeDepts();
    

            
            // loop through employees_2
            foreach($employees as $employee) {
                if ($employee['dept_name'] == 'Admissions and Records') {
                   $conn = db_connect();
                   $query = "UPDATE `employees_2` SET `dept_id`=30 WHERE `dept_name`='Admissions and Records'";
                   $result = @$conn->query($query);
                    
                }
            }
    
   
    
    
    
            //  if ($employee['dept_name'] == $name) {
            //         // run update query
            //         $conn = db_connect();
            //         $query = "UPDATE `employees_2` SET dept_id=$id WHERE `dept_name`=$name";
            //         $result=@conn->query($query);
            //          if (!$result) {
            //             return false;
            //             }
            //         $num_cats = @$result->num_rows;
            //         if ($num_cats == 0) {
            //           return false; 
            //         }
            //     }
    
    
    // echo '<pre>';
    //     print_r($employees);
    // echo '</pre>';
    
?>