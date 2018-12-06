<?php
include ("functions.php");
$Start = getTime();         //function that starts timer on script

$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("eval", $con)or die(mysql_error());

$BING_API = "711A2418AB0B724625DD04F2188B6A5C63270EB6";
$ENTIRE_WEB_API = "e15e0445fe57edda9bda4b42f0b5f220";
$BLEKKO_API = "b58f6ba2";
$GOOGLE_API = "ABQIAAAAN6GYi_pyoNnKLgpzxa3OPhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQ1uXi_1CPTti0LIgQwioQCoBBLFQ";

$search = STEM_AND_STOP($search);  //turning steming and stopword removal on

$requestBING = "http://api.bing.net/json.aspx?AppId=" . $BING_API . '&Query=' . urlencode($search) . '&Sources=Web&Web.Count=50';
$requestENTIRE_WEB = "http://www.entireweb.com/xmlquery?pz=" . $ENTIRE_WEB_API . "&ip=86.46.149.204&q=" . urlencode($search) . "&format=json&n=50";
$requestBLEKKO = "http://blekko.com/?q=" . urlencode($search) . "+/json+/ps=50&auth=<" . $BLEKKO_API . ">&p=1";

$response1 = file_get_contents($requestBING, TRUE);          //TRUE returns values in an array
$response2 = file_get_contents($requestENTIRE_WEB, TRUE);
$response3 = file_get_contents($requestBLEKKO, TRUE);

$BING = json_decode($response1);          //using JSON to parse the results from above in to an associative array
$ENTIRE_WEB = json_decode($response2);
$BLEKKO = json_decode($response3);

$newBing = array();         //declaring new arrays which will hold the values we want from the google results
$newEntire = array();
$newBlekko = array();

foreach ($BING->SearchResponse->Web->Results as $value) {
    $newBing[] = array("URL"=>$value->Url);
}
foreach ($ENTIRE_WEB->hits as $value) {
    $newEntire[] = array("URL"=>$value->url);
}
foreach ($BLEKKO->RESULT as $value) {
    $newBlekko[] = array("URL"=>$value->url);
}

/*print_r($newBing);
print_r($newYahoo);
print_r($newBlekko);*/

$list = array_merge($newBing,$newEntire, $newBlekko);


$requestGOOGLE1 ="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=1&q=" . urlencode($search) . "&key=" .$GOOGLE_API;
$requestGOOGLE2 ="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=8&q=" . urlencode($search) . "&key=" .$GOOGLE_API;
$requestGOOGLE3 ="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=16&q=" . urlencode($search) . "&key=" .$GOOGLE_API;
$requestGOOGLE4 ="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=24&q=" . urlencode($search) . "&key=" .$GOOGLE_API;
$requestGOOGLE5 ="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=32&q=" . urlencode($search) . "&key=" .$GOOGLE_API;
$requestGOOGLE6 ="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=40&q=" . urlencode($search) . "&key=" .$GOOGLE_API;
$requestGOOGLE7 ="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=48&q=" . urlencode($search) . "&key=" .$GOOGLE_API;
$requestGOOGLE8 ="http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=56&q=" . urlencode($search) . "&key=" .$GOOGLE_API;



$response4 = file_get_contents($requestGOOGLE1, TRUE);          //google only displays 8 results per page so multiple requests have to be made
$response5 = file_get_contents($requestGOOGLE2, TRUE);
$response6 = file_get_contents($requestGOOGLE3, TRUE);
$response7 = file_get_contents($requestGOOGLE4, TRUE);
$response8 = file_get_contents($requestGOOGLE5, TRUE);
$response9 = file_get_contents($requestGOOGLE6, TRUE);
$response10 = file_get_contents($requestGOOGLE7, TRUE);
$response11 = file_get_contents($requestGOOGLE8, TRUE);

$decode1 = json_decode($response4);         //parsing the results from google
$decode2 = json_decode($response5);
$decode3 = json_decode($response6);
$decode4 = json_decode($response7);
$decode5 = json_decode($response8);
$decode6 = json_decode($response9);
$decode7 = json_decode($response10);
$decode8 = json_decode($response11);

$recall1 = array();         //declaring new arrays which will hold the values we want from the google results
$recall2 = array();
$recall3 = array();
$recall4 = array();
$recall5 = array();
$recall6 = array();
$recall7 = array();
$recall8 = array();

foreach ($decode1->responseData->results as $value) {       //looping through the google results and putting the URL in the new arrays
    $recall1[] = array("URL" => $value->url);
}

foreach ($decode2->responseData->results as $value) {
    $recall2[] = array("URL" => $value->url);
}

foreach ($decode3->responseData->results as $value) {
    $recall3[] = array("URL" => $value->url);
}
foreach ($decode4->responseData->results as $value) {
    $recall4[] = array("URL" => $value->url);
}

foreach ($decode5->responseData->results as $value) {
    $recall5[] = array("URL" => $value->url);
}

foreach ($decode6->responseData->results as $value) {
    $recall6[] = array("URL" => $value->url);
}

foreach ($decode7->responseData->results as $value) {
    $recall7[] = array("URL" => $value->url);
}

foreach ($decode8->responseData->results as $value) {
    $recall8[] = array("URL" => $value->url);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$google = array_merge($recall1, $recall2, $recall3, $recall4, $recall5, $recall6, $recall7, $recall8);  

$End = getTime();
    echo "Time taken = " . number_format(($End - $Start), 2) . " secs";

$No_Of_Rel_Docs = 0;
$Total_Documents = 0;
$AVG_PRECISION=0;
                                //used to find the number of relevant documents contained in the meta search results
    foreach ($list as $one) {         //goes through the meta search array for all 3 results if a result was found in all 3 
        $Total_Documents = $Total_Documents +1;
        foreach ($google as $two) {             //this part checks google URLS
            if ($one["URL"] == $two["URL"]) {
                $No_Of_Rel_Docs = $No_Of_Rel_Docs + 1;       //increases the value of the No of Relevant Documetns
                
                    //calculating avg precision for each recall point
                $AVG_PRECISION = $AVG_PRECISION + ($No_Of_Rel_Docs/$Total_Documents);
                //echo"</br>";
                //echo "Avg Precision". $AVG_PRECISION. " . Total Documents: " .$Total_Documents . "</br>"; 
            }
        }
    }
$precision = 0;
$precision = $No_Of_Rel_Docs / $Total_Documents;       //Formula for total precision
$recall = 0;
$recall = $No_Of_Rel_Docs/64;

$AVG_PRECISION = $AVG_PRECISION/$No_Of_Rel_Docs;

mysql_query("INSERT INTO non_agg_stemon (query, total_documents, relevant, prec, recall, average_prec) 
        VALUE ('$search' ,'$Total_Documents','$No_Of_Rel_Docs','$precision','$recall','$AVG_PRECISION')") or die(mysql_error()); 
        
mysql_close($con);
  
echo "<pre>";
echo "</br>";
echo "Query: " .$search. "</br>";
echo "Total Documents:" . $Total_Documents . "</br>";
echo "Relevant: " . $No_Of_Rel_Docs . "</br>";
echo "Precision: " .$precision . "</br>";
echo "Recall: " . $recall. "</br>";
echo "Avg Precission: " . $AVG_PRECISION;
echo "</pre>";

?>