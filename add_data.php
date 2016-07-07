<?php
            // Set Up
            include('libs/pdf_converter.php');
            include('functions.php');
            $sourcefile = 'resources/2016_Campus_Directory.pdf';
            $pdf_string = pdf2string($sourcefile);
            $pdf_string = fixOfficerText($pdf_string);
            $pdf_string = fixOfficeText($pdf_string);
            $pdf_string = dblFtext($pdf_string);
            $pdf_string = fix_fi_text($pdf_string);
            $haystack = ' ';
            $position_title;
    
            // globals
            $master_list = [];
            $person_assoc_arr = [];
            $no_location = false;
            $no_email = false;
                
                
            // html
            include('includes/header.php');
?>

<?php
        

        // Establish database connection
        $mysqli = new mysqli('localhost', 'root', '', 'mtsac');
        $mysqli->set_charset('utf8');
        
        // Build Query
        $query = "INSERT INTO `employees_0` 
        (last_name, first_name, ext, dept_name, location, title, email)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        // Prep statement
        $stmt = $mysqli->prepare($query);
        
        $start_point = 'Zamora, Victor';
        $counter = 0;
        
        // Begin Iteration 
        
        while ($counter < 10) {
            global $counter, $person_assoc_arr, $master_list;
            // Bind the variables 'ssssss' -> all field inputs will be strings
            $stmt -> bind_param('sssssss', $lname, $fname, $ext, $dept_name, $location, $title, $email);
            
            $lname = getLName($start_point, $pdf_string);
            $fname = getFName($haystack);
            $ext = getPhoneExt($haystack);
            $dept_name = getDeptName($haystack);
            $location = getLocation($haystack);
            $title = getTitle($haystack);
            $email = getEmail($haystack);
            
            // Execute the statement
            $stmt->execute();
            // Check if db is updated
            if ($stmt->affected_rows == 1) {
                echo "<div class=\"alert alert-success text-center\">
                        <a href= \"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                        <strong>New Employee data has been succesfully inserted into database!</strong>
                      </div>";
            } else {
                 echo "<div class=\"alert alert-danger text-center\"
                          <a href= \"#\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">&times;</a>
                          <strong>Error:</strong> " . $stmt->error . "
                       </div";
            }
            
            updateStartPosition($haystack);
            $counter++;
        }
        
         // Close the statement
         $stmt->close();
         unset($stmt);
         
         // Close the connection
         $mysqli->close();
         unset($mysqli);
         
         include('includes/footer.php');
?>