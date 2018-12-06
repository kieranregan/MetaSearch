<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>MetaSearch</title>
    </head>
    <body>
        <div style='text-align: center'>
            <h1>BING+EntireWEB+BLEKKO</h1>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="search" size="50" />
                <input type="radio" name="agg" value="1" checked="checked"/> <label>Meta Search</label>
                <input type="radio" name="agg" value ="2"/><label>Non-Aggregated </label></br>
                <input type="checkbox" name="STEM" value="Yes" /><label>Turn on Stemming and Stopword Removal</label>

                <input type="submit" name="submit" value="SEARCH!" size="100" />
            </form>
        </div>
    </body>
</html>

<?php
if (isset($_POST['submit'])) {       //checks if the user pressed the submit button
    
    $search = strtolower(trim($_POST ['search']));      //convert user entered query to lowercase
    $search = preg_replace('/[?!.,()*]|[-]|\'/','', $search);

    //////////BOOLEAN PART//////////////////////////////////////////////////////////////////////////////////////////
    
    $search = preg_replace('/\band \b/', '+', $search);  //if we dont use the boundary england comes back as england
    $search = preg_replace('/\bnot \b/', '-', $search);     //BOOLEAN search part
    $search = preg_replace('/\bor\b/', 'OR', $search);

    echo $search;
    /////////////////////////////////////////////////////////////////////////////////////////////////////////s
    if (strlen($search) == 0) {          //if nothing has been typed in the search box
        echo "<p>Error: empty search</p>";
        return;
    }

    $selected_radio = $_POST['agg'];
    if (($selected_radio == '1') && (!empty($_POST['STEM']))) {  
        include("AGG_STEMON.php");
    }
    elseif(($selected_radio == '1') &&(empty($_POST['STEM']))){
        include("AGG_STEMOFF.php");
    }
    elseif(($selected_radio == '2') &&(!empty($_POST['STEM']))){
        include("NonAGG_STEMON.php");
    }
    elseif(($selected_radio == '2') &&(empty($_POST['STEM']))){
    include("NonAGG_STEMOFF.php");
}
}
?>