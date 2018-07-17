<?php
$q=$_GET["q"];
$d=$_GET["d"];

$con = mysql_connect("localhost", "lzhang", "lzhangUNT");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

$db_selected = mysql_select_db("OptionData", $con);

if (!$db_selected)
  {
  die ("Can\'t use test_db : " . mysql_error());
  }

$sql="select distinct year(ExpDate) from $q where Options='$d'";
$result = mysql_query($sql);


while($row = mysql_fetch_row($result)){
echo $row[0].",";

}

mysql_close($con);
?>