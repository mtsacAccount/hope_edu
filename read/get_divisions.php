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
    
    // globals
    $master_list = [];
    $division = [];
    $no_location = false;
    $no_email = false;
    $start_point = '';
    $counter = 0;
?>

<!-- PHP Script to parse PDF for Divsions, Test -->
<!-- /([A-Z])\w+(\,)*(\s)*(\&)*(\s)*/ig-->

<?php
        // Starting point
        $start_point = 'Academic Counselor for Student Athletes';
        // Update the haystack
        $haystack = strstr($pdf_string, $start_point);
        // Find index '('
        // preg_match("/\(/", $haystack, $matches, PREG_OFFSET_CAPTURE);
        // $matched_index = $matches[0][1];
        // // Extract Division Title String
        // $div_title = substr($haystack, 0, $matched_index-1);
        // // Update Divisions associative array
        // $division['title'] = $div_title;
        
        
        
        function getDivTitle($start_point, $haystack) {
            global $start_point, $haystack, $pdf_string;
            // Update the haystack
            $haystack = strstr($pdf_string, $start_point);
            // Find index '('
            preg_match("/\(/", $haystack, $matches, PREG_OFFSET_CAPTURE);
            $matched_regex = $matches[0][0];
            $matched_index = $matches[0][1];
            // Extract Division Title String
            $div_title = substr($haystack, 0, $matched_index-1);
            // Update the haystack
            $haystack = strstr($haystack, $matched_regex);
            return $div_title;
        }
        
        
        function getBldgNum($haystack) {
            global $haystack;
            // Find first occurence of number
            preg_match("/(\d+)/")
        }
?>
<pre>
    <?php    ?>
</pre>