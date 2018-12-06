<?php
include ("functions.php");
$Start = getTime();         //function that starts timer on script

$BING_API = "c8b5663456dc4e349971f864b22fe609";
$ENTIRE_WEB_API = "e15e0445fe57edda9bda4b42f0b5f220";
$BLEKKO_API = "b58f6ba2";

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$requestBING = "http://api.cognitive.microsoft.com/bing/v7.0" . $BING_API . '&Query=' . urlencode($search) . '&Sources=Web&Web.Count=50';
$requestENTIRE_WEB = "http://www.entireweb.com/xmlquery?pz=" . $ENTIRE_WEB_API . "&ip=86.46.149.204&q=" . urlencode($search) . "&format=json&n=50";
$requestBLEKKO = "http://blekko.com/?q=" . urlencode($search) . "+/json+/ps=50&auth=<" . $BLEKKO_API . ">&p=1";

$response1 = file_get_contents($requestBING, TRUE);          //TRUE returns values in an array
$response2 = file_get_contents($requestENTIRE_WEB, TRUE);
$response3 = file_get_contents($requestBLEKKO, TRUE);

$BING = json_decode($response1);          //using JSON to parse the results from above in to an associative array
$ENTIRE_WEB = json_decode($response2);
$BLEKKO = json_decode($response3);

$scoreBING = 51;  //variable used for Borda Count initalised to 51
$scoreENTIRE = 51;
$scoreBLEKKO = 51;

//////3 for each loops to extract the values we want from each engine and also to assign them a score/////////////////       

foreach ($BING->SearchResponse->Web->Results as $value) {      //for each loop goes through BING associative array
    if (isset($value->Description)) {
        $bordaBING[] = array("Engine" => "Bing", //creating a new array to score results with their score
            "Title" => $value->Title,
            "URL" => $value->Url,
            "Score" => --$scoreBING,
            "Summary" => $value->Description
        );
    }
}


foreach ($ENTIRE_WEB->hits as $value) {     //for each loop goes through ENTIRE_WEB associative array
    $bordaENTIRE[] = array("Engine" => "Entireweb", //creates a new array assigning scores based on position of results
        "Title" => $value->title,
        "URL" => $value->url,
        "Score" => --$scoreENTIRE,
        "Summary" => $value->snippet
    );
}



foreach ($BLEKKO->RESULT as $value) {     //for each loop goes through BLEKKO associative array
    if (isset($value->snippet)) {
        $bordaBLEKKO[] = array("Engine" => "Blekko",
            "Title" => $value->url_title,
            "URL" => $value->url,
            "Score" => --$scoreBLEKKO,
            "Summary" => $value->snippet
        );
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$BINGandENTIRE_WEB = add_common_results($bordaBING, $bordaENTIRE);     //adds to scores of urls that are common to the 2 engines and returns a new array
$all3 = add_common_results($BINGandENTIRE_WEB, $bordaBLEKKO);
$BINGandBLEKKO = add_common_results($bordaBING, $bordaBLEKKO);
$ENTIRE_WEBandBLEKKO = add_common_results($bordaBLEKKO, $bordaENTIRE);

////////////////////////part of the code to deal with duplicate values//////////////////////////////////////////////
$mergedORIGINAL = array_merge($bordaENTIRE, $bordaBLEKKO, $bordaBING);     //merge the two arrays with scores that have not been added

$mergedSCORES = array_merge($all3, $BINGandENTIRE_WEB, $BINGandBLEKKO, $ENTIRE_WEBandBLEKKO);       //merge all combinations of scores
$array1 = remove_duplicates($mergedSCORES);     //calling the function to remove duplicates

$mergedFINAL = array_merge($array1, $mergedORIGINAL);       //merge array with scores added to original array
$array2 = remove_duplicates($mergedFINAL);					//finally remove any duplicates

uasort($array2, 'sort_scores');      //uasort uses the user defined function above to sort results by score
$End = getTime();					//stops the timer
echo "Results for " .$search;
echo " .Time taken = " . number_format(($End - $Start), 2) . " secs";				//prints out time taken
print_results($array2);             //user defined function to print the results
?>