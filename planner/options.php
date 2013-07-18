<?php
session_start();
if(isset($_SESSION['user']) && $_SESSION['user']!='' ){$username= $_SESSION['user'];}
else
{
    header("Location: login.php"); 
}
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
font-size:18px;
}
h2
{
color:rgb(0,191,255);
}
.content
{
position:relative;
}
.header { height:120px; }

.footer{
position:relative;
top:350px;}

input{
background: #fff;
border: 1px solid #c6c9cc;
border-radius: 4px;
box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.1), 0 1px 0 #fff;
font: 13px/20px 'Droid Sans', Arial, 'Helvetica Neue', 'Lucida Grande', sans-serif;
margin: 0 0 20px 0;
padding: 5px;
width: 250px;
height:30;
font-size:100%;
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

</script>
</head>

<body>


      

<div id='cssmenu' align="center">
<ul>
   <li style="width:50px"><span>&nbsp </span></li>
   <li><a href='home.html'><span>Home</span></a></li>  
   <li><a href='#'><span>About</span></a></li>
   <li ><a href='logged.php'><span>Calender</span></a></li>
   <li ><a href='bmi.php'><span>BMI Calculator</span></a></li>
   <li><a href='options.php'><span>Options</span></a></li>
   <li><a href='login.php'><span>Log Out</span></a></li>
</ul>
</div>


<div style="position:relative;top:40px" align="center">
<h2 class="content">Options</h2>
<div style="position:relative;top:20px">
<form name="main" method="post">
Enter you mobile number to recieve sms alert for your plans.<br/><br />
Mobile:(+91)<input type="text" id="no" name="no"></input>
<br/><br />
<input type="submit" name="submit" value="Save" class="btn"   />
</form>
</div>
</div>


<div class="footer" align="center">
<text style="color:rgb(0,191,255)">Devoloped and Maintained by:</text><br />
AnanthaNatarajan.S<br />
 112112008<br /><br /> &nbsp

</div>



<?php

#############################
#   						#
#     Anantha Natarajan.S   #  
#         112112008	        #
#         sananth12         #
#							#
#############################

if(isset($_POST['submit']))
{


$conid=mysql_connect("localhost","root","");
mysql_select_db("project",$conid);
	
}
?>
</body>

</html>