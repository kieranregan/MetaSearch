<?php

include ("functions.php");

$BING_API = "711A2418AB0B724625DD04F2188B6A5C63270EB6";
$requestBING = 'http://api.bing.net/json.aspx?AppId=' . $BING_API . '&Query=' . urlencode($search) . '&Sources=Web&Web.Count=3';
$response = file_get_contents($requestBING, TRUE);          //TRUE returns values in an array

$BING = json_decode($response);          //using JSON to parse the results from above in to an associative array


$scoreBING = 51;  //variable used for Borda Count initalised to 51
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

$index = getIndex($bordaBING);
/*
echo"<pre>";
print_r($index);
echo"</pre>";
*/

$query = array();
$a =0;
$b=0;

$docCount = count($index['docCount']);
foreach ($index['dictionary'] as $term => $docID) {
$entry = $index['dictionary'][$term];
foreach ($entry['postings'] as $docID => $postings) {    
echo"</pre>";
   ;
  echo "Document $docID and term $term give TFIDF: " .($postings['tf'] * log($docCount / $entry['df'], 2)) ."</br>";
  echo "\n";
  echo"</pre>";
  
  if($term == $token){
        $query = array("query"=>$term);
    }
    
}
}
echo"<pre>";
     print_r($query);
  echo"</pre>";
/*
echo"<pre>";

echo"</pre>";
}  
 */
?>

