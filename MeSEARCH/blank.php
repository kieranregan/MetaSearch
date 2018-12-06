<?php

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
