<?php

$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("evaluation", $con)or die(mysql_error());


$query = "SELECT AVG(average_prec) FROM metasearch"; 
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)){
	echo "<b>The Mean Average Precision of Aggregated is:  </b>".$row['AVG(average_prec)'];
	echo "<br />";
}
$query = "SELECT AVG(recall) FROM metasearch"; 
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)){
	echo "<b>The Average Recall is:  </b>".$row['AVG(recall)'];
	echo "<br />";
}

 
$result = mysql_query("SELECT * FROM metasearch");

echo "<table border='1'>
<tr>
<th>Query</th>
<th>Total Documents</th>
<th>Relevant</th>
<th>Precision</th>
<th>Recall</th>
<th>Average Precison</th>
</tr>";

while($row = mysql_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['query'] . "</td>";
  echo "<td>" . $row['total_documents'] . "</td>";
  echo "<td>" . $row['relevant'] . "</td>";
  echo "<td>" . $row['prec'] . "</td>";
  echo "<td>" . $row['recall'] . "</td>";
  echo "<td>" . $row['average_prec'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysql_close($con);
?>
