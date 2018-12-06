<?php

function getIndex($collection) {
//require_once 'PorterStemmer.php';

    $dictionary = array();
    $docCount = array();

    foreach ($collection as $docID => $doc) {
        $terms1 = explode(" ", $doc['Title']);
        $terms2 = explode(" ", $doc['Summary']);

        $allterms = array_merge($terms1, $terms2);
        $allterms = implode(" ",$allterms);
        
        $allterms = preg_replace('/[?!.,()*]|[-]|\'/','', $allterms);
        $allterms = strtolower(trim($allterms));      //convert user entered query to lowercase
        $allterms = explode(" ", $allterms);

        $file = file_get_contents('stopwords.txt');     //get contents of the stopword list to string $file
        $stop = explode("\n", $file);                   //use explode function to put the words into an array
        $stop_words = array_map('trim', $stop);          //get rid of white space
        //convert user entered string to an array

        foreach ($allterms as $word) {
              //$word = PorterStemmer::Stem($word);        //calls the porter stemmer algorithim class
            if (!in_array($word, $stop_words) && (trim($word) != '')) {     //if word in the user query is not in stop word list put it in a new aray
                $searchWords[] = $word;
            }
        }
        
        $docCount[$docID] = count($searchWords);

        foreach ($searchWords as $term) {
            if (!isset($dictionary[$term])) {
                $dictionary[$term] = array('df' => 0, 'postings' => array());
            }
            if (!isset($dictionary[$term]['postings'][$docID])) {
                $dictionary[$term]['df']++;
                $dictionary[$term]['postings'][$docID] = array('tf' => 0);
            }

            $dictionary[$term]['postings'][$docID]['tf']++;
        }
        
    }
    
    return array('docCount' => $docCount, 'dictionary' => $dictionary);
}

function getIndex2() {
    $collection = array(
        1 => 'this string is a short string but a good string',
        2 => 'this one isn\'t quite like the rest but is here',
        3 => 'this is a different short string that\' not as short'
    );

    $dictionary = array();
    $docCount = array();

    foreach ($collection as $docID => $doc) {
        $terms = explode(' ', $doc);
        $docCount[$docID] = count($terms);

        foreach ($terms as $term) {
            if (!isset($dictionary[$term])) {
                $dictionary[$term] = array('df' => 0, 'postings' => array());
            }
            if (!isset($dictionary[$term]['postings'][$docID])) {
                $dictionary[$term]['df']++;
                $dictionary[$term]['postings'][$docID] = array('tf' => 0);
            }

            $dictionary[$term]['postings'][$docID]['tf']++;
        }
    }

    return array('docCount' => $docCount, 'dictionary' => $dictionary);
}

?>