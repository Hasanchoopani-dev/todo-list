<?php
function redirect ($url) {
    header("location:" . $url);
}
function generate_random_string ($length = 6){
    $characters  = "cppocpcmapapdoskdpdjjfeifnnvsidivnADCOSNIF0NEFENF654646446464462003";
    $result      = "";
    for ($i = 0 ; $i < $length ; $i++) {
        $random  = rand( 0 , strlen($characters) -1);
        $result .= $characters[$random];
    }
    return $result;
}
