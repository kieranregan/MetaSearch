<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Evaluation</title>
    </head>
    <body>
        <div style='text-align: center'>
            <h1>Check Precision and Recall v Google</h1>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" name="search" size="50" /></br>
                <input type="radio" name="agg" value="1"/> <label>MetaSearch</label></br>
                <input type="radio" name="agg" value ="2"checked ="checked"/><label>Non-Aggregated</label></br>
                <input type="checkbox" name="STEM" value="Yes" checked="checked" /><label>Turn on Stemming and Stopword Removal</label>
                <input type="submit" name="submit" value="GO!" size="100" /></br>
                </br>
                </br>
            </form>
            <form method ="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h2>Select an option to display results</h2>
                <input type="radio" name ="results" value ="3" /><label>Meta Results</label></br>
                <input type="radio" name ="results" value ="4" /><label>Non Agg Results</label></br>
                <input type="radio" name ="results" value ="5" /><label>Meta Stemming&StopWord Removal</label></br>
                <input type="radio" name ="results" value ="6" /><label>Non Agg Stemming&StopWord Removal</label></br>
                <input type="submit" name ="rsubmit" value="submit" size="100"/></br>
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

    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////s
    if (strlen($search) == 0) {          //if nothing has been typed in the search box
        echo "<p>Error: empty search</p>";
        return;
    }

    $selected_radio = $_POST['agg'];
    if (($selected_radio == '1') && (!empty($_POST['STEM']))) {  
        include("aggSTOP_ON.php");
    }
    elseif(($selected_radio == '1') &&(empty($_POST['STEM']))){
        include("EvaluateAGG.php");
    }
    elseif(($selected_radio == '2') &&(!empty($_POST['STEM']))){
        include("nonaggSTOP_ON.php");
    }
    elseif(($selected_radio == '2') &&(empty($_POST['STEM']))){
    include("EvaluateNON.php");
}
}

if(isset($_POST['rsubmit'])){
    $selected_radio2 = $_POST['results'];
    if($selected_radio2 == '3'){
        include("resultsAGG.php");
    }
    else if($selected_radio2=='4'){
        include("resultsNON.php");
    }
    else if($selected_radio2=='5'){
        include("resultsAGG_STOP_ON.php");
    }
    else if($selected_radio2=='6'){
        include("resultsNON_STOP_ON.php");
    }
}
?>