var xmlHttp
var xmlHttp2
var xmlHttp3
var xmlHttp4
function getYear(str1,str2)
{ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url="getyear.php"
url=url+"?q="+str1.toUpperCase();
url=url+"&d="+str2
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}

function getMonth(str1,str2,str3)
{ 
xmlHttp2=GetXmlHttpObject()
if (xmlHttp2==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url="getmonth.php"
url=url+"?q="+str1.toUpperCase();
url=url+"&d="+str2
url=url+"&y="+str3
url=url+"&sid="+Math.random()
xmlHttp2.onreadystatechange=stateChanged2 
xmlHttp2.open("GET",url,true)
xmlHttp2.send(null)
}

function getDay(str1,str2,str3,str4)
{ 
xmlHttp3=GetXmlHttpObject()
if (xmlHttp3==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url="getday.php"
url=url+"?q="+str1.toUpperCase();
url=url+"&d="+str2
url=url+"&y="+str3
url=url+"&m="+str4
url=url+"&sid="+Math.random()
xmlHttp3.onreadystatechange=stateChanged3 
xmlHttp3.open("GET",url,true)
xmlHttp3.send(null)
}

function getStrike(str1,str2,str3,str4,str5)
{ 
xmlHttp4=GetXmlHttpObject()
if (xmlHttp4==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 }
var url="getstrike.php"
url=url+"?q="+str1.toUpperCase();
url=url+"&d="+str2
url=url+"&y="+str3
url=url+"&m="+str4
url=url+"&r="+str5
url=url+"&sid="+Math.random()
xmlHttp4.onreadystatechange=stateChanged4 
xmlHttp4.open("GET",url,true)
xmlHttp4.send(null)
}

function stateChanged() //change stock_name
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 var str=xmlHttp.responseText;
 BuildSel(str,document.getElementById("year"));
 getMonth(getname(),getoption(),getyear());
 getDay(getname(),getoption(),getyear(),getmonth());
 getStrike(getname(),getoption(),getyear(),getmonth(),getday());
 } 
}
function stateChanged2() //change year
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 var str=xmlHttp2.responseText;
 BuildSel(str,document.getElementById("month"));
 getDay(getname(),getoption(),getyear(),getmonth());
 getStrike(getname(),getoption(),getyear(),getmonth(),getday());
 } 
}

function stateChanged3() //change month
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 var str=xmlHttp3.responseText;
 BuildSel(str,document.getElementById("day"));
 getStrike(getname(),getoption(),getyear(),getmonth(),getday());

 } 
}

function stateChanged4() //change day
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 var str=xmlHttp4.responseText;
 BuildSel(str,document.getElementById("strike"));

 } 
}
function BuildSel(str,sel)    
{
    sel.options.length=0;     
    var arrstr = new Array();     
    arrstr = str.split(",");
    if(str.length>0){           
        for(var i=0;i<arrstr.length-1;i++){     
            sel.options.add(new Option(arrstr[i],arrstr[i]));
	}
    }         
    sel.options[0].selected=true; 
}
// GetObject
function GetXmlHttpObject()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 //Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}
function getname()
{
	stock_name=document.getElementById("stock").value;
	return  stock_name;
}
function getoption()
{
	option=document.getElementById("option").value;
	return  option;
}
function getyear()
{
	year=document.getElementById("year").value;
	return  year;
}
function getmonth()
{
	month=document.getElementById("month").value;
	return  month;
}
function getday()
{
	day=document.getElementById("day").value;
	return  day;
}
function getstrike()
{
	strike=document.getElementById("strike").value;
	return  strike;
}