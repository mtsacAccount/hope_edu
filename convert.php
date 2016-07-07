<?php
    
    function pdf2string($sourcefile) {

    $fp = fopen($sourcefile, 'rb');
    $content = fread($fp, filesize($sourcefile));
    fclose($fp);

    $searchstart = 'stream';
    $searchend = 'endstream';
    $pdfText = '';
    $pos = 0;
    $pos2 = 0;
    $startpos = 0;

    while ($pos !== false && $pos2 !== false) {

        $pos = strpos($content, $searchstart, $startpos);
        $pos2 = strpos($content, $searchend, $startpos + 1);

        if ($pos !== false && $pos2 !== false){

            if ($content[$pos] == 0x0d && $content[$pos + 1] == 0x0a) {
                $pos += 2;
            } else if ($content[$pos] == 0x0a) {
                $pos++;
            }

            if ($content[$pos2 - 2] == 0x0d && $content[$pos2 - 1] == 0x0a) {
                $pos2 -= 2;
            } else if ($content[$pos2 - 1] == 0x0a) {
                $pos2--;
            }

            $textsection = substr(
                $content,
                $pos + strlen($searchstart) + 2,
                $pos2 - $pos - strlen($searchstart) - 1
            );
            $data = @gzuncompress($textsection);
            $pdfText .= pdfExtractText($data);
            $startpos = $pos2 + strlen($searchend) - 1;

        }
    }

    return preg_replace('/(\\s)+/', ' ', $pdfText);

}

function pdfExtractText($psData){

    if (!is_string($psData)) {
        return '';
    }

    $text = '';

    // Handle brackets in the text stream that could be mistaken for
    // the end of a text field. I'm sure you can do this as part of the
    // regular expression, but my skills aren't good enough yet.
    $psData = str_replace('\\)', '##ENDBRACKET##', $psData);
    $psData = str_replace('\\]', '##ENDSBRACKET##', $psData);

    preg_match_all(
        '/(T[wdcm*])[\\s]*(\\[([^\\]]*)\\]|\\(([^\\)]*)\\))[\\s]*Tj/si',
        $psData,
        $matches
    );
    for ($i = 0; $i < sizeof($matches[0]); $i++) {
        if ($matches[3][$i] != '') {
            // Run another match over the contents.
            preg_match_all('/\\(([^)]*)\\)/si', $matches[3][$i], $subMatches);
            foreach ($subMatches[1] as $subMatch) {
                $text .= $subMatch;
            }
        } else if ($matches[4][$i] != '') {
            $text .= ($matches[1][$i] == 'Tc' ? ' ' : '') . $matches[4][$i];
        }
    }

    // Translate special characters and put back brackets.
    $trans = array(
        '...'                => '&#8230;',
        '\\205'                => '&#8230;',
        '\\221'                => chr(145),
        '\\222'                => chr(146),
        '\\223'                => chr(147),
        '\\224'                => chr(148),
        '\\226'                => '-',
        '\\267'                => '&#8226;',
        '\\('                => '(',
        '\\['                => '[',
        '##ENDBRACKET##'    => ')',
        '##ENDSBRACKET##'    => ']',
        chr(133)            => '-',
        chr(141)            => chr(147),
        chr(142)            => chr(148),
        chr(143)            => chr(145),
        chr(144)            => chr(146),
    );
    $text = strtr($text, $trans);

    return $text;

}
$master_list = [];
$person_assoc_arr = [];
$sourcefile = '2015_Campus_Directory.pdf';
// Convert Entire PDF to String
$pdf_string = pdf2string($sourcefile);


/**** Last Name *****/
        // Find a starting point for the new Haystack (a large substring of the pdf string)
        $starting_search = 'Abadie,';
        // haystack is the rest of the string from where starting point was found
        $haystack = strstr($pdf_string, $starting_search);
        // indexOf comma
        $commaStop = intval(strpos($haystack, ','));
        // substring out the last name 
        $lname = substr($haystack, 0, $commaStop);
        // update person associative array 
        $person_assoc_arr['last_name'] = $lname;
/****Last Name Complete *****/

/**** First Name *****/

        // Update haystack from last comma point
        $haystack = strstr($haystack, ',');
        // Get next stopping point which is '\w '(letter char lower case followed directly by a space), 
        // there is some issues with
        // performing a strpos on '.', does not return the right position
        preg_match("/\w\s/", $haystack, $matches, PREG_OFFSET_CAPTURE);
        $matched_index = $matches[0][1];
        // substring out the first name, start out 2 places after the comma, then
        // until the matched index of letter followed by a space
        $fname = substr($haystack, 2, $matched_index - 1);
        // update person associative array
        $person_assoc_arr['first_name'] = $fname;
        

/****** First Name Complete ********/ 

/****** Phone Extension **********/

        // Update haystack from 'ext' 
        $haystack = strstr($haystack, 'ext');
        // Next stopping point is the capital letter that will 
        // indicate the name of the building. 
        preg_match("/[A-Z]/", $haystack, $matches, PREG_OFFSET_CAPTURE);
        // index of capital letter match
        $bldNameStop = $matches[0][1];
        // matched capital letter
        $matched_cap_lettter = $matches[0][0];
        // extension value starts 5 characters after initial 
        $ext = substr($haystack, 5, $bldNameStop - 5);
        // update person associative array
        $person_assoc_arr['extension'] = $ext;
        
/******* Phone Extension Complete *********/

/******* Department Name ****************/
        // Update haystack from last matched Capital Letter
        $haystack = strstr($haystack, $matched_cap_lettter);
        // Next stopping point is a space
        preg_match("/\d/", $haystack, $matches, PREG_OFFSET_CAPTURE);
        // get index and value of matched digit
        $matched_digit = $matches[0][0];
        $digitStop = $matches[0][1];
        // extract dept name
        $dept_name = substr($haystack, 0, $digitStop-1);
        //update person associative array
        $person_assoc_arr['dept_name'] = $dept_name;


/******* Department Name Complete **************/

/****** Department/Office Number ***********/

        $haystack = strstr($haystack, $matched_digit);
        // Next stopping point is a regex "num->cap->lower | cap->cap->lower"
        preg_match("/([A-Z]{2}[a-z])|(\d[A-Z][a-z])/", $haystack, $matches, PREG_OFFSET_CAPTURE);
        // get index and value of matched regex
        $matched_regex = $matches[0][0];
        $regexStop = $matches[0][1];
        // extract dept/office number
        $location = substr($haystack, 0, $regexStop + 1);
        //update person associative array
        $person_assoc_arr['location'] = $location;


/******* Department/Office Number Complete ********/

/******* Position Title ********/
        
        $haystack = strstr($haystack, $matched_regex);
        // Next stopping point is a regex "two or more spaces"
        preg_match("/\s[a-z]/", $haystack, $matches, PREG_OFFSET_CAPTURE);
        $matched_regex = $matches[0][0];
        $regexStop = $matches[0][1];
        // extract title 
        $title = substr($haystack, 1, $regexStop);
        // update person associative array
        $person_assoc_arr['title'] = $title;


/****** Position Title Complete *******/ 
        
        
/****** Email *******/
        
        $haystack = strstr($haystack, $matched_regex);
        preg_match("/[A-Z]/", $haystack, $matches, PREG_OFFSET_CAPTURE);
        $matched_regex = $matches[0][0];
        $regexStop = $matches[0][1];
        // extract email 
        $email = substr($haystack, 0, $regexStop);
        // update person associative array
        $person_assoc_arr['email'] =  $email;
        $haystack = strstr($haystack, $matched_regex);
        echo $haystack

/***** Email Complete *******/ 

        // update master array
       array_push($master_list, $person_assoc_arr);
       unset($person_assoc_arr);
       $person_assoc_arr = array();
       
?> 

<pre>
    <?php 
        print_r($master_list); 
        print_r($person_assoc_arr);
    ?>
</pre>