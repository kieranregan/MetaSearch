<?php
include ("functions.php");
$Start = getTime();         //function that starts timer on script

$BING_API = "711A2418AB0B724625DD04F2188B6A5C63270EB6";
$YAHOO_API = "7mOnTDvV34GdHdNm9XPcb6Ms_lbhz8hKyylyUJVY8pva..UnfTCTaw31kRoAQ1vi";
$BLEKKO_API = "b58f6ba2";

$requestBING = 'http://api.bing.net/json.aspx?AppId=' . $BING_API . '&Query=' . urlencode($search) . '&Sources=Web&Web.Count=50';
$requestYAHOO = 'http://search.yahooapis.com/WebSearchService/V1/webSearch?appid=' . $YAHOO_API . '&query=' . urlencode($search) . '&results=50' . '&output=json';
$requestBLEKKO = "http://blekko.com/?q=" . urlencode($search) . "+/json+/ps=50&auth=<" . $BLEKKO_API . ">&p=1";

$response = file_get_contents($requestBING, TRUE);          //TRUE returns values in an array
$response2 = file_get_contents($requestYAHOO, TRUE);
$response3 = file_get_contents($requestBLEKKO, TRUE);

$BING = json_decode($response);          //using JSON to parse the results from above in to an associative array
$YAHOO = json_decode($response2);
$BLEKKO = json_decode($response3);

$scoreBING = 51;  //variable used for Borda Count initalised to 51
$scoreYAHOO = 51;
$scoreBLEKKO = 51;

/////////////////////3 for each loops to extract the values we want from each engine and also to assign them a score//////////////////////////////////////////////////////////////////////////////////////////////////////        


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

foreach ($YAHOO->ResultSet->Result as $value) {     //for each loop goes through YAHOO associative array
    $bordaYAHOO[] = array("Engine" =>"YAHOO!", //creates a new array assigning scores based on position of results
        "Title"=>$value->Title,
        "URL" => $value->Url,
        "Score" => --$scoreYAHOO,
        "Summary" => $value->Summary
    );
}

foreach ($BLEKKO->RESULT as $value) {     //for each loop goes thur YAHOO associative array
     if (isset($value->snippet)) {
    $bordaBLEKKO[] = array("Engine" => "Blekko",
        "Title"=>$value->url_title,
        "URL" => $value->url,
        "Score" => --$scoreBLEKKO,
        "Summary" => $value->snippet
    );
     }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$BINGandYAHOO = add_common_results($bordaBING, $bordaYAHOO);     //adds to scores of urls that are common to the 2 engines and returns a new array

$all3 = add_common_results($BINGandYAHOO, $bordaBLEKKO);

$BINGandBLEKKO = add_common_results($bordaBING, $bordaBLEKKO);

$YAHOOandBLEKKO = add_common_results($bordaYAHOO, $bordaBLEKKO);


//////////////////////part of the code to deal with duplicate values//////////////////////////////////////////////
$mergedORIGINAL = array_merge($bordaYAHOO, $bordaBLEKKO, $bordaBING);     //merge the two arrays with scores that have not been added
  
if (is_array($all3)) {
    $mergedSCORES = array_merge($all3, $BINGandYAHOO, $BINGandBLEKKO, $YAHOOandBLEKKO);       //merge this array to the array with scores that have been added
    $array1 = remove_duplicates($mergedSCORES);     //calling the function to remove duplicates

    $mergedFINAL= array_merge($array1, $mergedORIGINAL);       //merge this array to the array with scores that have been added
    $array2 = remove_duplicates($mergedFINAL);

    uasort($array2, 'sort_scores');      //uasort uses the user defined function above to sort results by score
    $End = getTime(); 
    echo "Time taken = ".number_format(($End - $Start),2)." secs";
   
    echo"<pre>";
    print_r($array2);
    echo"</pre>";
   // print_results($array2);             //user defined function to print the results
    
} elseif (is_array($BINGandYAHOO)) {
    $mergedSCORES = array_merge($BINGandYAHOO, $mergedORIGINAL);       //merge this array to the array with scores that have been added
    $array1 = remove_duplicates($mergedSCORES);

    uasort($array1, 'sort_scores');      //uasort uses the user defined function above.
    $End = getTime(); 
    echo "Time taken = ".number_format(($End - $Start),2)." secs";
    print_results($array1);
    
} elseif (is_array($BINGandBLEKKO)) {
    $mergedSCORES = array_merge($BINGandBLEKKO, $mergedORIGINAL);       //merge this array to the array with scores that have been added
    $array1 = remove_duplicates($mergedSCORES);

    uasort($out_array1, 'sort_scores');      //uasort uses the user defined function above.
    $End = getTime(); 
    echo "Time taken = ".number_format(($End - $Start),2)." secs";
    print_results($array1);
} 

elseif (is_array($YAHOOandBLEKKO)) {
    $mergedSCORES = array_merge($YAHOOandBLEKKO, $mergedORIGINAL);       //merge this array to the array with scores that have been added
    $array1 = remove_duplicates($mergedSCORES);
   
    uasort($array1, 'sort_scores');      //uasort uses the user defined function above.
    $End = getTime(); 
    echo "Time taken = ".number_format(($End - $Start),2)." secs";
    print_results($array1);
}    
?>