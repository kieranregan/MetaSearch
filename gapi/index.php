<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Google</title>
    </head>
    <body>
        <?php
        if (isset($_POST['submit'])) {       //checks if the user pressed the submit button
            $search = trim($_POST ['search']);

            if (strlen($search) == 0) {          //if nothing has been typed in the search box
                echo "<p>Error: empty search</p>";
            } else {
                $getGOOGLE1 = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=1&q=" . urlencode($search) . "&key=AIzaSyDi7frL2OIehjKScgtIOjdNBr8NcSOpB8M";
                /*
                $getGOOGLE2 = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=8&q=" . urlencode($search) . "&key=ABQIAAAAN6GYi_pyoNnKLgpzxa3OPhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQ1uXi_1CPTti0LIgQwioQCoBBLFQ";
                $getGOOGLE3 = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=16&q=" . urlencode($search) . "&key=ABQIAAAAN6GYi_pyoNnKLgpzxa3OPhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQ1uXi_1CPTti0LIgQwioQCoBBLFQ";
                $getGOOGLE4 = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=24&q=" . urlencode($search) . "&key=ABQIAAAAN6GYi_pyoNnKLgpzxa3OPhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQ1uXi_1CPTti0LIgQwioQCoBBLFQ";
                $getGOOGLE5 = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=32&q=" . urlencode($search) . "&key=ABQIAAAAN6GYi_pyoNnKLgpzxa3OPhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQ1uXi_1CPTti0LIgQwioQCoBBLFQ";
                $getGOOGLE6 = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=40&q=" . urlencode($search) . "&key=ABQIAAAAN6GYi_pyoNnKLgpzxa3OPhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQ1uXi_1CPTti0LIgQwioQCoBBLFQ";
                $getGOOGLE7 = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=48&q=" . urlencode($search) . "&key=ABQIAAAAN6GYi_pyoNnKLgpzxa3OPhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQ1uXi_1CPTti0LIgQwioQCoBBLFQ";
                $getGOOGLE8 = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=large&start=56&q=" . urlencode($search) . "&key=ABQIAAAAN6GYi_pyoNnKLgpzxa3OPhT2yXp_ZAY8_ufC3CFXhHIE1NvwkxQ1uXi_1CPTti0LIgQwioQCoBBLFQ";
                */
                $response1 = file_get_contents($getGOOGLE1, TRUE);
                $response2 = file_get_contents($getGOOGLE2, TRUE);
                $response3 = file_get_contents($getGOOGLE3, TRUE); 
                $response4 = file_get_contents($getGOOGLE4, TRUE);
                $response5 = file_get_contents($getGOOGLE5, TRUE);
                $response6 = file_get_contents($getGOOGLE6, TRUE);
                $response7 = file_get_contents($getGOOGLE7, TRUE);
                $response8 = file_get_contents($getGOOGLE8, TRUE);
                
                $decode1 = json_decode($response1);
                $decode2 = json_decode($response2);
                $decode3 = json_decode($response3);
                $decode4 = json_decode($response4);
                $decode5 = json_decode($response5);
                $decode6 = json_decode($response6);
                $decode7 = json_decode($response7);
                $decode8 = json_decode($response8);
                
                $recall1 = array();
                $recall2 = array();
                $recall3 = array();
                $recall4 = array();
                $recall5 = array();
                $recall6 = array();
                $recall7 = array();
                $recall8 = array(); 
                
                //for($i=0; $i<64; $i++){
                foreach($decode1->responseData->results as $value){
                    $recall1[] = array("URL"=>$value->url);
                }
                
                foreach($decode2->responseData->results as $value){
                    $recall2[] = array("URL"=>$value->url);
                }
                
                foreach($decode3->responseData->results as $value){
                    $recall3[] = array("URL"=>$value->url);
                }
                foreach($decode4->responseData->results as $value){
                    $recall4[] = array("URL"=>$value->url);
                }
                
                foreach($decode5->responseData->results as $value){
                    $recall5[] = array("URL"=>$value->url);
                }
                
                foreach($decode6->responseData->results as $value){
                    $recall6[] = array("URL"=>$value->url);
                }
                  
                foreach($decode7->responseData->results as $value){
                    $recall7[] = array("URL"=>$value->url);
                }
                
                foreach($decode8->responseData->results as $value){
                    $recall8[] = array("URL"=>$value->url);
                }
                
       
                $array2 = array_merge($recall1, $recall2, $recall3, $recall4, $recall5, $recall6, $recall7, $recall8);
                echo "<pre>";
                print_r($array2);
               // print_r($food2);
                echo"</pre>";
            }
        }
        ?>

        <div style='text-align: center'>
            <h1>Search - powered by Google</h1>
            <form method="post" action="index.php">
                <input type="text" name="search" size="50" />
                <input type="submit" name="submit" value="Bing" />
            </form>
        </div>
    </body>
</html>
