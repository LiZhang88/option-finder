<html>
<body>
<?
$day=$_POST["day"];
$month=$_POST["month"];
$year=$_POST["year"];
$stock_name=strtoupper($_POST["stock"]);
$option=$_POST["option"];
$strike=$_POST["strike"];
?>

<?
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
$sql="select * from $stock_name where (ExpDate=$year$month$day) and (Options='$option') and (Strike=$strike)";
$result=mysql_query($sql);
?>
<table cellspacing='10'>
<tr>
<th>
	Recording Date
</th>
<th>
	Expration Date
</th>
<th>
	Options
</th>
<th>
	Strike
</th>
<th>
	Contract Name
</th>
<th>
	Last
</th>
<th>
	Bid
</th>
<th>
	Ask
</th>
<th>
	Change
</th>
<th>
	%Change
</th>
<th>
	Volume
</th>
<th>
	Open 
	<br>Interest</br>
</th>
<th>
	Implied
	<br>Volatility</br>
</th>	
</tr>
<?
while($row = mysql_fetch_row($result)){
echo "<tr>";
echo "<td>$row[0]</td>";
echo "<td>$row[1]</td>";
echo "<td>$row[2]</td>";
echo "<td>$row[3]</td>";
echo "<td>$row[4]</td>";
echo "<td>$row[5]</td>";
echo "<td>$row[6]</td>";
echo "<td>$row[7]</td>";
echo "<td>$row[8]</td>";
echo "<td>$row[9]</td>";
echo "<td>$row[10]</td>";
echo "<td>$row[11]</td>";
echo "<td>$row[12]</td>";
echo "</tr>";
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