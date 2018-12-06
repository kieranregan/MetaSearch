<?php

$con = mysql_connect("localhost","root","");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("eval", $con)or die(mysql_error());


$query = "SELECT AVG(average_prec) FROM agg_stemon"; 
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)){
	echo "<b>The Mean Average Precision of Aggregated with Stemming and StopWord Removal is:  </b>".$row['AVG(average_prec)'];
	echo "<br />";
}
$query = "SELECT AVG(recall) FROM agg_stemon"; 
$result = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_array($result)){
	echo "<b>The Average Recall of Aggregated with Stemming and StopWord Removal is:  </b>".$row['AVG(recall)'];
	echo "<br />";
}

 
$result = mysql_query("SELECT * FROM agg_stemon");

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
