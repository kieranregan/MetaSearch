<?php
include ("functions.php");
$Start = getTime();         //function that starts timer on script

$BING_API = "711A2418AB0B724625DD04F2188B6A5C63270EB6";
$ENTIRE_WEB_API = "e15e0445fe57edda9bda4b42f0b5f220";
$BLEKKO_API = "b58f6ba2";

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$requestBING = "http://api.bing.net/json.aspx?AppId=" . $BING_API . '&Query=' . urlencode($search) . '&Sources=Web&Web.Count=50';
$requestENTIRE_WEB = "http://www.entireweb.com/xmlquery?pz=" . $ENTIRE_WEB_API . "&ip=86.46.149.204&q=" . urlencode($search) . "&format=json&n=50";
$requestBLEKKO = "http://blekko.com/?q=" . urlencode($search) . "+/json+/ps=50&auth=<" . $BLEKKO_API . ">&p=1";

$response1 = file_get_contents($requestBING, TRUE);          //TRUE returns values in an array
$response2 = file_get_contents($requestENTIRE_WEB, TRUE);
$response3 = file_get_contents($requestBLEKKO, TRUE);

$BING = json_decode($response1);          //using JSON to parse the results from above in to an associative array
$ENTIRE_WEB = json_decode($response2);
$BLEKKO = json_decode($response3);

$End = getTime(); 
echo "Results for " .$search;
echo " .Time taken = " . number_format(($End - $Start), 2) . " secs";

echo('<ol>');
foreach ($BING->SearchResponse->Web->Results as $value) {
    if (isset($value->Description)){
    echo('<h4><a href="' . $value->Url . '"></h4>');
    echo('<h4>' . $value->Title .'</h4></a>');
    echo('<p class="Summary">' . $value->Description . '</p>');
	echo('<p class="engine">' ."Found on : Bing" . '</p>');
	echo('<p class="score">' . $value->Url . '</p>');
    }
}

foreach ($ENTIRE_WEB->hits as $value) {
    if (isset($value->snippet)){
    echo('<h4><a href="' . $value->url . '"></h4>');
    echo('<h4>' . $value->title .'</h4></a>');
    echo('<p class="Summary">' . $value->snippet . '</p>');
	echo('<p class="engine">' ."Found on : Entireweb" . '</p>');
	echo('<p class="score">' . $value->url . '</p>');
    }
}

foreach ($BLEKKO->RESULT as $value) {
    if (isset($value->snippet)){
    echo('<h4><a href="' . $value->url . '"></h4>');
    echo('<h4>' . $value->url_title .'</h4></a>');
    echo('<p class="Summary">' . $value->snippet . '</p>');
	echo('<p class="engine">' ."Found on : Blekko" . '</p>');
	echo('<p class="score">' . $value->url . '</p>');
    }
}
echo("</ol>");
?>