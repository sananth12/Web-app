
<html>
<?php
session_start();
if(isset($_SESSION['user']) && $_SESSION['user']!='' ){$username= $_SESSION['user'];}
else
{
    header("Location: login.php"); 
}
?>
<head>
<link href="./menu_assets/styles.css" rel="stylesheet" type="text/css">
<link rel="icon" 
      type="image/png" 
      href="images/favicon.ico">
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
.btn
{
background: #fff;
border: 1px solid #c6c9cc;
border-radius: 4px;
box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.1), 0 1px 0 #fff;
font-family:"Helvetica Neue",Helvetica,Arial,Verdana,sans-serif;
font-size:100%;
margin: 0 0 20px 0;
padding: 5px;
width: 200px;
height:35;
cursor:hand;
}
</style>


<script>
function cval()
{
  document.getElementById("value1").value=document.getElementById("wt").value;
  bmi();
}
function cval2()
{
  document.getElementById("value2").value=document.getElementById("tt").value;
  bmi();
}

function bmi()
{
  var w=document.getElementById("wt").value;
  var h=document.getElementById("tt").value;
  var ans=w/(h*h);
  var s;
  if(ans<15)
  {
    s="Severely underweight";
	document.getElementById("bmi").innerHTML = ans+"<br />"+"<text style=\"color:red\">"+s+"</text>"; 
  }
  else if(ans<18.5)
  {
     s="Under weight";
	 document.getElementById("bmi").innerHTML = ans+"<br />"+"<text style=\"color:pink\">"+s+"</text>"; 
  }
  else if(ans<25)
  {
    s="Healthy Weight"
	document.getElementById("bmi").innerHTML = ans+"<br />"+"<text style=\"color:green\">"+s+"</text>"; 
  }
  else if(ans<30)
  {
     s="Over weight"
	 document.getElementById("bmi").innerHTML = ans+"<br />"+"<text style=\"color:pink\">"+s+"</text>"; 
  }
  else if(ans<40)
  {
     s="Severely obese"
	 document.getElementById("bmi").innerHTML = ans+"<br />"+"<text style=\"color:red\">"+s+"</text>"; 
  }
  else
  {
     s="DANGER x_x";
	 document.getElementById("bmi").innerHTML = ans+"<br />"+"<text style=\"color:red\">"+s+"</text>"; 
  }
  
 document.getElementById("ibmi").value = ans; 
}
</script>

<title>Total-Planner</title>
</head>

<body>


      

<div id='cssmenu' align="center">
<ul>
   <li style="width:50px"><span>&nbsp </span></li>
   <li><a href='home.html'><span>Home</span></a></li>  
   <li><a href='#'><span>About</span></a></li>
   <li ><a href='logged.php'><span>Calender</span></a></li>
   <li class="active"><a href='bmi.html'><span>BMI Calculator</span></a></li>
    <li><a href='graph.php'><span>Statistics</span></a></li>
   <li><a href='options.php'><span>Options</span></a></li>
   <li><a href='login.php'><span>Log Out</span></a></li>
</ul>
</div>


<div style="position:relative;top:80px" align="center">
<h2 class="content">BMI Calculator</h2>
<div style="position:relative;top:20px">
<text style="color:rgb(0,191,255);font-size:20px">Weight(kg)</text><br />
<input type="range" min="20" max="120" step="1" id="wt"  onchange="cval()"/> <input size="3"  type="text" id="value1"></input>
<br/>
<text style="color:rgb(0,191,255);font-size:20px">Height(m)</text><br />
<input type="range" min="1.00" max="2.10" step="0.01"  id="tt" onchange="cval2()"/> <input size="4"  type="text" id="value2"></input>
<br/><br />
<text style="color:orange;font-size:20px">Your BMI:</text><br />
<div id="bmi" style="font-size:20px"></div>
<br />

<form name="main" method="post">
<input type="hidden" id="ibmi" name="ibmi" value="" />
<input type="submit" name="submit" value="Update BMI" class="btn"   />
</form>

</div>
</div>


<div class="footer" align="center">
<text style="color:rgb(0,191,255)">Devoloped and Maintained by:</text><br />
AnanthaNatarajan.S<br />
 112112008<br /><br /> 
<a href="http://facebook.com/sananth12"><img src="images/facebok-icon.png" ></a>
<a href="https://plus.google.com/110111970750333332975/posts?tab=XX"><img src="images/gplus-icon.png" ></a>
<a href="https://twitter.com/AnanthaNatarjan"><img src="images/twitter-icon.png" ></a>

</div>



<?php

#############################
#                           #
#     Anantha Natarajan.S   #  
#         112112008         #
#         sananth12         #
#                           #
#############################

if(isset($_POST['submit']))
{
include "includes/connect.php";

//$conid=mysql_connect("localhost","root","");
//mysql_select_db("project",$conid);

$bmi=$_REQUEST['ibmi'];
$date=date("Ymd");

mysql_query("INSERT INTO `".$_SESSION['user']."` (date,1t,2t,3t,4t,5t,array,total,done,bmi) 
             VALUES ('$date','','','','','','','','','$bmi')
			 ON DUPLICATE KEY UPDATE
			 bmi='$bmi'	");
		
echo "<script>alert('Today\'s BMI has been saved.')</script>";		
}
?>
</body>

</html>
