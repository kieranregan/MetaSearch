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

foreach ($YAHOO->ResultSet->Result as $value) {
    if (isset($value->Summary)){
    echo('<li class="resultlistitem"><a href="' . $value->Url . '">');
    echo('<h3>' . $value->Title . '</h3></a>');
    echo('<p>' . $value->Summary . "Yahoo!" . '</p>');
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