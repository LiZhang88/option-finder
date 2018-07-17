<?php
$q=$_GET["q"];
$d=$_GET["d"];
$y=$_GET["y"];
$m=$_GET["m"];
$r=$_GET["r"];

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

$sql="select distinct Strike from $q where (Options='$d') and (year(ExpDate)=$y) and (month(ExpDate)=$m) and (day(ExpDate)=$r) order by cast(Strike as decimal(6,2))";
$result = mysql_query($sql);


while($row = mysql_fetch_row($result)){
echo $row[0].",";

}

mysql_close($con);
?>