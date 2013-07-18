<?php
session_start();
if(isset($_SESSION['user']) && $_SESSION['user']!='' ){$username=$_SESSION['user'];}
else
{
    header("Location: login.php"); 
}
//$conid=mysql_connect("localhost","root","");
//mysql_select_db("project",$conid);
include "includes/connect.php";

?>

<html>

<head>
<link href="./menu_assets/styles.css" rel="stylesheet" type="text/css">
<style>
body 
{
background-color:rgb(57,57,57);
font-family:"Helvetica Neue",Helvetica,Arial,Verdana,sans-serif;
color:rgb(195,195,195);

}
h2
{
color:rgb(0,191,255);
}
.content
{
position:relative;
//left:630px;
}
.header { height:120px; }

.footer{
position:relative;
top:350px;

}
.month
{
font-family:"Helvetica Neue",Helvetica,Arial,Verdana,sans-serif;
color:rgb(0,191,255);
font-size:25px;
cursor:hand;
}
table
{
border: 1px  solid rgb(0,191,255);
border-collapse:collapse;
font-size:20px;
}
td
{
text-align:center;
padding:8px;
width:150px;
border: 1px  solid rgb(0,191,255);
}
.day
{
height:100px;
}
.calender
{
position:relative;
top:10px;
}
.dd
{
cursor:hand;
}
#new-event {
	background-color: #F9F9F9;
	border: 1px solid #727272;
	//box-shadow: 10px 11px 15px #9F9F9F;
	position: absolute;
	width: 400px;
	display: none;
}
#new-event textarea {
	width: 100%;
	height: 270px;
}
</style>

<script>

function init()
{
 var date= new Date();
 var month=date.getMonth();
 var poss=[31,28,31,30,31,30,31,31,30,31,30,31];
 var list= ["January","February","March","April","May","June","July","August","September","October","November","December"];
 document.getElementById("month").innerHTML=list[month]+" "+date.getFullYear() ;
 
 var days=poss[month];
 var year = date.getFullYear();
 if (month==1)
	 {if(year % 400 === 0 || ( year % 4 === 0 && year % 100 !== 0))
	 days=29;
	 }
  var myDate=new Date();
  myDate.setDate(1);
  var start=myDate.getDay();
  
   
   var i=0;
   var j=1;
   for(i=start+1;i<=days;i++,j++)
   {
     document.getElementById(i).innerHTML=j;
	 
   }
 
}
var myDate=new Date();
function prev()
{
 var list= ["January","February","March","April","May","June","July","August","September","October","November","December"];
 
  
  myDate.setDate(1);
  if(myDate.getMonth()!=0)
  myDate.setMonth(myDate.getMonth()-1);
  else
   {myDate.setMonth(11);
    myDate.setFullYear(myDate.getFullYear()-1);
   }
   
  var start=myDate.getDay();
  document.getElementById("month").innerHTML=list[myDate.getMonth()]+" "+myDate.getFullYear();
    var start=myDate.getDay();
	//document.getElementById("month").innerHTML=start
   
   var poss=[31,28,31,30,31,30,31,31,30,31,30,31];
   var month=myDate.getMonth();
   var days=poss[myDate.getMonth()];
   var year = myDate.getFullYear();
   if (month==1)
	 {if(year % 400 === 0 || ( year % 4 === 0 && year % 100 !== 0))
	 days=29;
	 }
   var i=0;
   var j=1;
  
   for(i=1;i<=42;i++)
   {
    document.getElementById(i).innerHTML="";
   }
  
   for(i=start+1;j<=days;i++,j++)
   {
	 document.getElementById(i).innerHTML=j;
	 
   }
}

function next()
{
 var list= ["January","February","March","April","May","June","July","August","September","October","November","December"];
 
  
  myDate.setDate(1);
  if(myDate.getMonth()!=11)
  myDate.setMonth(myDate.getMonth()+1);
  else
   {myDate.setMonth(0);
    myDate.setFullYear(myDate.getFullYear()+1);
   }
   
  var start=myDate.getDay();
  document.getElementById("month").innerHTML=list[myDate.getMonth()]+" "+myDate.getFullYear();
    var start=myDate.getDay();
	//document.getElementById("month").innerHTML=start
   
   var poss=[31,28,31,30,31,30,31,31,30,31,30,31];
   var month=myDate.getMonth();
   var days=poss[myDate.getMonth()];
   var year = myDate.getFullYear();
   if (month==1)
	 {if(year % 400 === 0 || ( year % 4 === 0 && year % 100 !== 0))
	 days=29;
	 }
   var i=0;
   var j=1;
  
   for(i=1;i<=42;i++)
   {
    document.getElementById(i).innerHTML="";
   }
  
   for(i=start+1;j<=days;i++,j++)
   {
     
	 document.getElementById(i).innerHTML=j;
   }
}

function plan(n)
{
   
   window.location.href = "event.php?day=" + document.getElementById(n).innerHTML + "&month=" + document.getElementById("month").innerHTML+"&mm="+ (myDate.getMonth()+1)+"&yy="+myDate.getFullYear();
   
	
 }
 
</script>


<body onload="init()">

<div id='cssmenu' align="center">
<ul>
   <li style="width:50px"><span>&nbsp </span></li>
   <li><a href='home.html'><span>Home</span></a></li>  
   <li><a href='#'><span>About</span></a></li>
   <li class='active'><a href='#'><span>Calender</span></a></li>
   <li ><a href='bmi.php'><span>BMI Calculator</span></a></li>
   <li><a href='graph.php'><span>Statistics</span></a></li>
   <li><a href='options.php'><span>Options</span></a></li>
   <li><a href='login.php'><span>Log Out</span></a></li>
</ul>
</div>


<div style="position:relative;top:20px" align="center">
<h2 class="content">Planner</h2>
<div style="position:relative;top:20px">

<span class="month" style="color:orange" onclick="prev()"> << </span>
&nbsp &nbsp 
<span id='month' class="month" style="cursor:none"></span>

&nbsp &nbsp 
<span class="month" style="color:orange" onclick="next()"> >> </span> 

<br />

<table class="calender">

<tr>
<td>Sunday</td>
<td>Monday</td>
<td>Tuesday</td>
<td>Wednesday</td>
<td>Thursday</td>
<td>Friday</td>
<td>Saturday</td>
</tr>
<tr class="day">
<td><div class="dd" id="1" onclick="plan(1)"></div> <div width="50px"><div></td>
<td><div class="dd" id="2" onclick="plan(2)"></div></td>
<td><div class="dd" id="3" onclick="plan(3)"></div></td>
<td><div class="dd" id="4" onclick="plan(4)"></div></td>
<td><div class="dd" id="5" onclick="plan(5)"></div></td>
<td><div class="dd" id="6" onclick="plan(6)"></div></td>
<td><div class="dd" id="7" onclick="plan(7)"></div></td>
</tr>

<tr class="day">
<td><div class="dd" id="8" onclick="plan(8)"></div></td>
<td><div class="dd" id="9" onclick="plan(9)"></div></td>
<td><div class="dd" id="10" onclick="plan(10)"></div></td>
<td><div class="dd" id="11" onclick="plan(11)"></div></td>
<td><div class="dd" id="12" onclick="plan(12)"></div></td>
<td><div class="dd" id="13" onclick="plan(13)"></div></td>
<td><div class="dd" id="14" onclick="plan(14)"></div></td>
</tr >

<tr class="day">
<td><div class="dd" id="15" onclick="plan(15)"></div></td>
<td><div class="dd" id="16" onclick="plan(16)"></div></td>
<td><div class="dd" id="17" onclick="plan(17)"></div></td>
<td><div class="dd" id="18" onclick="plan(18)"></div></td>
<td><div class="dd" id="19" onclick="plan(19)"></div></td>
<td><div class="dd" id="20" onclick="plan(20)"></div></td>
<td><div class="dd" id="21" onclick="plan(21)"></div></td>
</tr>

<tr class="day">
<td><div class="dd" id="22" onclick="plan(22)"></div></td>
<td><div class="dd" id="23" onclick="plan(23)"></div></td>
<td><div class="dd" id="24" onclick="plan(24)"></div></td>
<td><div class="dd" id="25" onclick="plan(25)"></div></td>
<td><div class="dd" id="26" onclick="plan(26)"> </div></td>
<td><div class="dd" id="27" onclick="plan(27)"></div></td>
<td><div class="dd" id="28" onclick="plan(28)"></div></td>
</tr>

<tr class="day">
<td><div class="dd" id="29" onclick="plan(29)"></div></td>
<td><div class="dd" id="30" onclick="plan(30)"></div></td>
<td><div class="dd" id="31" onclick="plan(31)"></div></td>
<td><div class="dd" id="32" onclick="plan(32)"></div></td>
<td><div class="dd" id="33" onclick="plan(33)"></div></td>
<td><div class="dd" id="34" onclick="plan(34)"></div></td>
<td><div class="dd" id="35" onclick="plan(35)"></div></td>
</tr>

<tr class="day">
<td><div class="dd" id="36" onclick="plan(36)"></div></td>
<td><div class="dd" id="37" onclick="plan(37)"></div></td>
<td><div class="dd" id="38" onclick="plan(38)"></div></td>
<td><div class="dd" id="39" onclick="plan(39)"></div></td>
<td><div class="dd" id="40" onclick="plan(40)"></div></td>
<td><div class="dd" id="41" onclick="plan(41)"></div></td>
<td><div class="dd" id="42" onclick="plan(42)"></div></td>
</tr>


</table>

</div>
</div>
<div id="new-event">
		<textarea id="event-txt"></textarea>
		<div id="event-bar">
			<button id="delete-event">Delete</button>
			<button id="create-event">Create event</button> |
			<button id="cancel-event" onclick="cancel()">Cancel</a>
		</div>
	</div>
<div id="dates" style="display:none"></div>
<div id="ttd" style="display:none"></div>

<div class="footer" align="center">
<text style="color:rgb(0,191,255)">Devoloped and Maintained by:</text><br />
AnanthaNatarajan.S<br />
 112112008<br /><br /> &nbsp

</div>

</body>

</html>