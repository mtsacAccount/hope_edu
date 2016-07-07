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
    
            echo $pdf_string;
?>