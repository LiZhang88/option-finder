<?php
$q=$_GET["q"];
$d=$_GET["d"];
$y=$_GET["y"];

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

$sql="select distinct month(ExpDate) from $q where (Options='$d') and (year(ExpDate)=$y) order by month(ExpDate)";
$result = mysql_query($sql);


while($row = mysql_fetch_row($result)){
if($row[0]<10){
echo "0".$row[0].",";
}
else
{
echo $row[0].",";
}
}

mysql_close($con);
?>