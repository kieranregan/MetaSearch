<?php
include ("functions.php");
$Start = getTime();         //function that starts timer on script

$BING_API = "711A2418AB0B724625DD04F2188B6A5C63270EB6";
$ENTIRE_WEB_API = "e15e0445fe57edda9bda4b42f0b5f220";
$BLEKKO_API = "b58f6ba2";

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$fullQuery = STEM_AND_STOP($search);        //function which takes care of stemming and stopword removal
echo"<pre>";
print_r($fullQuery);
echo"</pre>";
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$requestBING = "http://api.bing.net/json.aspx?AppId=" . $BING_API . '&Query=' . urlencode($fullQuery) . '&Sources=Web&Web.Count=50';
$requestENTIRE_WEB = "http://www.entireweb.com/xmlquery?pz=" . $ENTIRE_WEB_API . "&ip=86.46.149.204&q=" . urlencode($fullQuery) . "&format=json&n=50";
$requestBLEKKO = "http://blekko.com/?q=" . urlencode($fullQuery) . "+/json+/ps=50&auth=<" . $BLEKKO_API . ">&p=1";

$response1 = file_get_contents($requestBING, TRUE);          //TRUE returns values in an array
$response2 = file_get_contents($requestENTIRE_WEB, TRUE);
$response3 = file_get_contents($requestBLEKKO, TRUE);

$BING = json_decode($response1);          //using JSON to parse the results from above in to an associative array
$ENTIRE_WEB = json_decode($response2);
$BLEKKO = json_decode($response3);

$End = getTime(); 


echo('<ul ID="resultList">');
echo "Time taken = ".number_format(($End - $Start),2)." secs";
foreach ($BING->SearchResponse->Web->Results as $value) {
    if (isset($value->Description)){
    echo('<li class="resultlistitem"><a href="' . $value->Url . '">');
    echo('<h3>' . $value->Title . '</h3></a>');
    echo('<p>' . $value->Description . "Bing" . '</p>');
    }
}

foreach ($ENTIRE_WEB->hits as $value) {
    if (isset($value->snippet)){
    echo('<li class="resultlistitem"><a href="' . $value->url . '">');
    echo('<h3>' . $value->title . '</h3></a>');
    echo('<p>' . $value->snippet . "entireWeb" . '</p>');
    }
}

foreach ($BLEKKO->RESULT as $value) {
    if (isset($value->snippet)){
    echo('<li class="resultlistitem"><a href="' . $value->url . '">');
    echo('<h3>' . $value->url_title . '</h3></a>');
    echo('<p>' . $value->snippet . "Blekko" . '</p>');
    }
}

echo("</ul>");
?>