<html>
<body>
<?
$symbol=$_POST["symbol"];
$symbol=strtoupper($symbol);
$parameter=$_POST["parameter"];
$lastCname='';
$today=date("Y-m-d",strtotime("-1 day"));
$day1=date("Y-m-d",strtotime("-2 day"));
$day2=date("Y-m-d",strtotime("-3 day"));
$day3=date("Y-m-d",strtotime("-4 day"));
$day4=date("Y-m-d",strtotime("-5 day"));
$day5=date("Y-m-d",strtotime("-6 day"));
?>

<?
echo "SYMBOL:$symbol          ";
echo "PARAMETER:$parameter       ";
echo "DATE:$today          ";
echo "<hr />";
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
$sql="select * from $symbol where (Rdate='$today')  or (Rdate='$day1')or (Rdate='$day2')or (Rdate='$day3')or (Rdate='$day4')or (Rdate='$day5') order by cName,Rdate";
$result=mysql_query($sql);
?>
<table width="500" border="1">
<?
echo "<tr>";
echo "<td>Vol</td>";
echo "<td>Today</td>";
echo "<td>Day-1</td>";
echo "<td>Day-2</td>";
echo "<td>Day-3</td>";
echo "<td>Day-4</td>";
echo "<td>Day-5</td>";
echo "</tr>";
$Vol=array();
//$OpenI=array();
$i=0;
while($row = mysql_fetch_row($result)){
if($lastCname==$row[4]){
//echo "<tr><td>old</td></tr>";
}
else{
if($lastCname!=''){
//echo "<tr><td>new</td></tr>";
$Vsum=0;
//$Osum=0;
for($j=0;$j<$i-1;$j++){
    $Vsum=$Vsum+$Vol[$j];
//    $Osum=$Osum+$OpenI[$j];
}
$Vsum=$Vsum/($i-1);
//$Osum=$Osum/($i-1);
$i=$i-1;
//echo "<tr><td>$Vsum</td></tr>";
//echo "<tr><td>$Vol[$i]</td></tr>";
if(($Vol[$i]>($Vsum*$parameter))&&($Vsum!=0)){
echo "<tr>";
echo "<td><a href=\"Cdetail.php?contract=$lastCname\">$lastCname    </a></td>";
echo "<td>$Vol[$i]    </td>";
for($j=$i-1;$j>=0;$j--){
echo "<td>$Vol[$j]    </td>";
}

echo "</tr>";
}
//if($OpenI[$i]>($Osum*$parameter)){
//echo "<tr>";
//echo "<td>OpenInt:    </td>";
//echo "<td>ContactName:$lastCname    </td>";
//for($j=0;$j<$i;$j++){
//echo "<td>Day$j:$OpenI[$j]    </td>";
//}
//echo "<td>Today:$OpenI[$i]    </td>";
//echo "</tr>";
//}


$i=0;
}
}
//$OpenI[$i]=$row[10];
$Vol[$i]=$row[11];
$i++;
$lastCname=$row[4];
//echo "<tr>";
//echo "<td>$row[0]</td>";
//echo "<td>$row[3]</td>";
//echo "<td>$row[4]</td>";
//echo "<td>$row[10]</td>";
//echo "<td>$row[11]</td>";
//echo "</tr>";
}
?>
</table>
<hr />
<table width="500" border="1">
<?
$sql="select * from $symbol where (Rdate='$today')  or (Rdate='$day1')or (Rdate='$day2')or (Rdate='$day3')or (Rdate='$day4')or (Rdate='$day5') order by cName,Rdate";
$result=mysql_query($sql);
echo "<tr>";
echo "<td>OpenInt</td>";
echo "<td>Today</td>";
echo "<td>Day-1</td>";
echo "<td>Day-2</td>";
echo "<td>Day-3</td>";
echo "<td>Day-4</td>";
echo "<td>Day-5</td>";
echo "</tr>";
//$Vol=array();
$OpenI=array();
$i=0;
while($row = mysql_fetch_row($result)){
if($lastCname==$row[4]){
//echo "<tr><td>old</td></tr>";
}
else{
if($lastCname!=''){
//echo "<tr><td>new</td></tr>";
//$Vsum=0;
$Osum=0;
for($j=0;$j<$i-1;$j++){
//    $Vsum=$Vsum+$Vol[$j];
    $Osum=$Osum+$OpenI[$j];
}
//$Vsum=$Vsum/($i-1);
$Osum=$Osum/($i-1);
$i=$i-1;
//echo "<tr><td>$Vsum</td></tr>";
//echo "<tr><td>$Vol[$i]</td></tr>";
//if($Vol[$i]>($Vsum*$parameter)){
//echo "<tr>";
//echo "<td>$lastCname    </td>";
//echo "<td>$Vol[$i]    </td>";
//for($j=$i-1;$j>=0;$j--){
//echo "<td>$Vol[$j]    </td>";
//}

//echo "</tr>";
//}
if(($OpenI[$i]>($Osum*$parameter))&&($Osum!=0)){
echo "<tr>";
echo "<td><a href=\"Cdetail.php?contract=$lastCname\">$lastCname    </a></td>";
echo "<td>$OpenI[$i]    </td>";
for($j=$i-1;$j>=0;$j--){
echo "<td>$OpenI[$j]    </td>";
}

echo "</tr>";
}


$i=0;
}
}
$OpenI[$i]=$row[10];
//$Vol[$i]=$row[11];
$i++;
$lastCname=$row[4];
//echo "<tr>";
//echo "<td>$row[0]</td>";
//echo "<td>$row[3]</td>";
//echo "<td>$row[4]</td>";
//echo "<td>$row[10]</td>";
//echo "<td>$row[11]</td>";
//echo "</tr>";
}
?>
</table>
<?
mysql_close($con);
?>

<form action="option.html">
	<input type="submit" name="submit" value="BACK" ></input>
</form>
</body>
</html>