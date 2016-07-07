<?php
    include('../libs/pdf_converter.php');
    include('../functions.php');
    $sourcefile = '../resources/2016_Campus_Directory.pdf';
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
    $start_point = 'Ojeda, Evelyn';
    $counter = 0;
    while ($counter < 23) {
        global $counter, $person_assoc_arr, $master_list;
        $lname = getLName($start_point, $pdf_string);
        $fname = getFName($haystack);
        $ext = getPhoneExt($haystack);
        $dept_name = getDeptName($haystack);
        $location = getLocation($haystack);
        $title = getTitle($haystack);
        $email = getEmail($haystack);
        $person_assoc_arr = array(
            "last_name" => $lname,
            "first_name" => $fname, 
            "extension" => $ext, 
            "dept_name" => $dept_name,
            "location" => $location,
            "title" => $title,
            "email" => $email
        );
        $master_list[] = $person_assoc_arr;
        unset($person_assoc_arr);
        updateStartPosition($haystack);
        $counter++;
    }
    
    // $lname = getLName($start_point, $pdf_string);
    
    
    // $fname = getFName($haystack);
    
    
    // $ext = getPhoneExt($haystack);
    
    
    // $dept_name = getDeptName($haystack);
    
    
    // $location = getLocation($haystack);
    
    
    // $title = getTitle($haystack);
    
    
    // $email = getEmail($haystack);
    
    
    // $new_start = updateStartPosition($haystack);
    
    
    // echo $pdf_string;
    
 ?>

<pre>
    <?php print_r($master_list); ?>
</pre>