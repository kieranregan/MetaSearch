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
    foreach($array as $value){
    echo('<h2><a href="' . $value['URL'] . '"></h2>');
    echo('<h4>' . $value['Title'] .'</h3></a>');
    echo('<p>'.$value["Summary"]." <b>Found on </b>". $value["Engine"] .'</p>');
    echo('<p1>' .$value['URL'] . " .Score: ". $value['Score'] . '</p1>');
}
 
}
?>