<link href="metaSTYLE.css" rel="stylesheet" type="text/css" />
<?php
function getTime() 
    { 
    $a = explode (' ',microtime()); 
    return(double) $a[0] + $a[1]; 
    } 

function add_common_results($array1, $array2){
    $a=$b=$c=$d=$e=0; 
    $combined = array();
    
    foreach ($array1 as $one) {           //finds results common to YAHOO and BING and adds score
    foreach ($array2 as $two) {
        if ($one["URL"] == $two["URL"]) {
            $a= $one['Engine'] . "," . $two['Engine'];
            $b = $one['Title'];
            $c = $one["URL"];
            $d = $one["Summary"];
            $e = $one["Score"] + $two["Score"];
        
            $combined[] = array("Engine" => $a, //creating a new array with scores added
               "Title" =>$b,
                "URL" => $c,
                "Summary" => $d,
                "Score" => $e
                );
        }
    }
}
    return $combined;
}

function remove_duplicates($array){     //function to remove duplicate values
    $out_array = array();
    $key_array = array();
    foreach ($array as $i => $row) {
        if (empty($key_array[$row['URL']])) {
            $out_array[] = $row;             
        }
        $key_array[$row['URL']] = 1;
    }
    return $out_array;
}

function sort_scores($a, $b) {      //function to sort results from highest score to lowest score
        return ($a['Score'] == $b['Score']) ? 0 : (($a['Score'] > $b['Score']) ? -1 : 1);
    }
    
function print_results($array){
	echo('<ul>');
    foreach($array as $value){
    echo('<h4><a href="' . $value['URL'] . '"></h4>');
    echo('<h4>' . $value['Title'] .'</h4></a>');
    echo('<p class="Summary">'.$value["Summary"]. '</p>');
	echo('<p class="engine">'. "Found on ". $value["Engine"] . '</p>');
    echo('<p class="score">' .$value['URL'] . " .Score: ". $value['Score'] . '</p>');
}   
	echo('</ul>');
}

function STEM_AND_STOP($search) {
    require_once 'PorterStemmer.php';

    $file = file_get_contents('stopwords.txt');     //get contents of the stopword list to string $file
    $stop = explode("\n", $file);                   //use explode function to put the words into an array
    $stop_words = array_map('trim', $stop);          //get rid of white space

    $keywords = explode(" ", $search);              //convert user entered string to an array

    foreach ($keywords as $word) {
        if (!in_array($word, $stop_words) && (trim($word) != '')) {

            $STOP_REMOVED[] = $word;                        //puts the stemmed words in an array
        }
    }
    foreach ($STOP_REMOVED as $word) {
        $word = PorterStemmer::Stem($word);         //calls the porter stemmer algorithim class
        $word = preg_replace('/[?!.,()+*]|[-]|\'/', '', $word);
        $STEM_WORDS[] = $word;                                    //new array with stop words removed form query
    }


    $SEARCH = implode(" ", $STOP_REMOVED);          //converts the new arrays to a strgin
    $stem = implode(" OR ", $STEM_WORDS);           //uses OR to search for all the stem words as well

    $fullQuery = $SEARCH . " OR " . $stem;            //joins the 2 together

    return $fullQuery;
}
?>