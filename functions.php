<?php 
    include('no_location_titles.php');
?>

<?php
    
    
    
    
    function fixOfficerText($str) {
        $new_str = str_replace('O\036cer','Officer', $str, $count);
        return $new_str;
    }
    function fixOfficeText($str) {
        $new_str = str_replace('O\036ce','Office', $str, $count);
        return $new_str;
    }
    function dblFtext($str) {
        $new_str = str_replace('\035','ff', $str, $count);
        return $new_str;
    }
    
    function fix_fi_text($str) {
        $new_str = str_replace('\037','fi', $str, $count);
        return $new_str;
    }
    
    
    
    
    // Helper function to separate title and department 
    function removeTitleFromDept($str) {
        // Pull in array of titles to match
        global $no_location_titles, $position_title;
        $str_len = strlen($str);
        $len = count($no_location_titles);
        $counter = 0;
        while($counter < $len) {
            // if there is a match, cut it out of $str
            if (strpos($str, $no_location_titles[$counter]) != false) {
                $index = strpos($str, $no_location_titles[$counter]);
                $new_str = substr($str, 0, $index);
                $position_title = substr($str, $index);
                return $new_str;
            }
         $counter++;
        }
    }
    
    
    
    function getLName($searchstart, $pdf_string) {
        // Find a starting point for the new Haystack (a large substring of the pdf string)
        $starting_search = $searchstart;
        global $haystack;
        // haystack is the rest of the string from where starting point was found
        $haystack = strstr($pdf_string, $starting_search);
        // indexOf comma
        $commaStop = intval(strpos($haystack, ','));
        // substring out the last name 
        $lname = substr($haystack, 0, $commaStop);
        // Update haystack from last comma point
        $haystack = strstr($haystack, ',');
        return $lname;
    }
    
    
    function getFName($haystack) {
        global $haystack;
        // Get next stopping point which is '\w '(letter char lower case followed directly by a space), 
        preg_match("/[a-z][\s][\W]/", $haystack, $matches, PREG_OFFSET_CAPTURE);
        $matched_index = $matches[0][1];
        // substring out the first name, start out 2 places after the comma, then
        // until the matched index of letter followed by a space
        $fname = substr($haystack, 2, $matched_index - 1);
        // update haystack
         preg_match("/([\d]{4}[A-Z])/", $haystack, $matches, PREG_OFFSET_CAPTURE);
           $matched_regex = $matches[0][0];
           $haystack = strstr($haystack, $matched_regex);
           return $fname;
    }
    
    
    
    
    function getPhoneExt($haystack) {
        global $haystack;
            $ext = substr($haystack, 0, 4);
            preg_match("/[A-Z]/", $haystack, $matches, PREG_OFFSET_CAPTURE);
            // index of capital letter match
            $bldNameStop = $matches[0][1];
            // matched capital letter
            $matched_cap_lettter = $matches[0][0];
            // extension value starts 5 characters after initial 
            $haystack = strstr($haystack, $matched_cap_lettter);
            return $ext;
     
    }
    
    function getDeptName($haystack) {
        global $haystack, $no_location, $position_title;
        // Next stopping point is a space
        preg_match("/\d/", $haystack, $matches, PREG_OFFSET_CAPTURE);
        // get index and value of matched digit
        $matched_digit = $matches[0][0];
        $digitStop = $matches[0][1];
        // case when the digit reach is longer than 50,
        // this means that there is no building number
        // readjustment for case
        if ($digitStop > 40) {
           $no_location = true;    
           // next matching pattern is beginning of email
           preg_match("/\s[a-z]/", $haystack, $matches, PREG_OFFSET_CAPTURE);
           $match_regex = $matches[0][0];
           $regex_index = $matches[0][1];
           $dept_name = substr($haystack, 0, $regex_index);
           $dept_name = removeTitleFromDept($dept_name);
           $haystack = strstr($haystack, $match_regex);
           return $dept_name;
        }
        // extract dept name
        $dept_name = substr($haystack, 0, $digitStop-1);
        $haystack = strstr($haystack, $matched_digit);
        return $dept_name;
    }
    
    function getLocation($haystack) {
        global $haystack, $no_location;
        if (!$no_location) {
            // Next stopping point is a regex "num->cap->lower | cap->cap->lower"
            preg_match("/([A-Z]{2}[a-z])|(\d[A-Z][a-z])/", $haystack, $matches, PREG_OFFSET_CAPTURE);
            // get index and value of matched regex
            $matched_regex = $matches[0][0];
            $regexStop = $matches[0][1];
            // extract dept/office number
            $location = substr($haystack, 0, $regexStop + 1);
            $haystack = strstr($haystack, $matched_regex);
            return $location;
        } else {
          $location = " ";
          return $location;
        }
    }
    
    function getTitle($haystack) {
        global $haystack, $no_location, $position_title, $no_email;
        // haystack start with location value
        // 6Professor cperry@mtsac.edu
        
        if ($no_location) {
            // run code when scenario has no location value
            $title = $position_title;
            $no_location = false;
            return $title;
        } else {
            preg_match("/(\s[a-z]+[@])/", $haystack, $matches, PREG_OFFSET_CAPTURE);
            $matched_email = $matches[0][0];
            $matched_email_index = $matches[0][1];
           
              // 3Custodian Addison
            if ($matched_email_index > 50) {
                $no_email = true;
                preg_match("/([A-Z][a-z]+[,])/", $haystack, $matches, PREG_OFFSET_CAPTURE);
                $matched_regex = $matches[0][0];
                $matched_index = $matches[0][1];
                $title = substr($haystack, 1, $matched_index - 1);
                $haystack = strstr($haystack, $matched_regex);
                return $title;
                
            }
            $title = substr($haystack, 1, $matched_email_index - 1);
            $haystack = strstr($haystack, $matched_email);
            return $title;
           
        }
    }
    
    function getEmail($haystack) {
        global $haystack, $no_email;
        // haystack looks like cperry@mtsac.eduAndrade, Susana
        //echo $haystack;
        if ($no_email) {
            $no_email = false;
            return ' ';
        } else {
            //([u]{1}[A-Z]{1})
            preg_match("/([u]{1}[A-Z]{1})/", $haystack, $matches, PREG_OFFSET_CAPTURE);
            $matched_regex = $matches[0][0];
            $matched_index = $matches[0][1];
            $email = substr($haystack, 1, $matched_index);
            $haystack = strstr($haystack, $matched_regex);
            return $email;
        }
       
    
        
    }
    
    // old regex = (([A-Z][a-z]+\-)*[A-Z][a-z]+[\,]\s[A-Z][a-z]+(\s\([A-Z][a-z]+\))*)    
    // new regex = (([A-Z][a-z]+\-)*[A-Z][a-z]+[\,]\s[A-Z][a-z]+\-*(\s\([A-Z][a-z]+\))*(\s[A-Z][a-z]+)*)
    function updateStartPosition($haystack) {
        global $haystack, $start_point;
        preg_match("/(([A-Z][a-z]+\-)*[A-Z][a-z]+[\,]\s[A-Z][a-z]+\-*(\s\([A-Z][a-z]+\))*(\s[A-Z][a-z]+)*)/", $haystack, $matches, PREG_OFFSET_CAPTURE);
        $start_point = $matches[0][0];
        // echo $start_point;
        return $start_point;
    }
   


    function addPerson($searchstart, $pdf_string) {
        $last_name = getLName($searchstart, $pdf_string);
        $first_name = getFName($haystack);
        $extension = getPhoneExt($haystack);
        $dept_name = getDeptName($haystack);
        $location = getLocation($haystack);
        $title = getTitle($haystack);
        $email = getEmail($haystack);
        $person_assoc_arr['last_name'] = $lname;
        $person_assoc_arr['first_name'] = $fname;
        $person_assoc_arr['extension'] = $ext;
        $person_assoc_arr['dept_name'] = $dept_name;
        $person_assoc_arr['location'] = $location;
        $person_assoc_arr['title'] = $title;
        // update master array
        array_push($master_list, $person_assoc_arr);
        unset($person_assoc_arr);
        $person_assoc_arr = array();
    }




?>