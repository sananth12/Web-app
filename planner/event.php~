<?php
session_start();
if(isset($_SESSION['user']) && $_SESSION['user']!='' )
{
include "includes/connect.php";
//$conid=mysql_connect("localhost","root","");
//mysql_select_db("project",$conid);

$mm=$_GET['mm'];
$yy=$_GET['yy'];
$dd=$_GET['day'];
if($dd<10)
$dd="0".$dd;
if($mm<10)
$mm="0".$mm;
$dat=$yy.$mm.$dd;

$username = mysql_real_escape_string($_SESSION['user']);
$s=mysql_query("SELECT * FROM `".$username."` WHERE date='$dat'");
if($s!="")
$num=mysql_num_rows($s);
if($num >=1)
{
   $row=mysql_fetch_assoc($s);
}
}
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

}
h2
{
font-family:"Helvetica Neue",Helvetica,Arial,Verdana,sans-serif;
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

.input1{
background: rgb(57,57,57);
//border: 1px solid #c6c9cc;
border:none;
border-bottom:1px solid #c6c9cc;
//border-radius: 4px;

font: 13px/20px 'Droid Sans', Arial, 'Helvetica Neue', 'Lucida Grande', sans-serif;
margin: 0 0 20px 0;
padding: 5px;
width: 250px;
height:35;
font-size:20px;
color:white;

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
width: 250px;
height:35;
cursor:hand;
}
.box{
width:25px;
position:relative;
top:2px;
}

</style>
</head>

<body>


      

<div id='cssmenu' align="center">
<ul>
     <li style="width:50px"><span>&nbsp </span></li>
   <li><a href='home.html'><span>Home</span></a></li>  
   <li><a href='#'><span>About</span></a></li>
   <li ><a href='logged.php'><span>Calender</span></a></li>
   <li class="active"><a href='#'><span>Plan</span></a></li>
   <li ><a href='bmi.php'><span>BMI Calculator</span></a></li>
   <li><a href='graph.php'><span>Statistics</span></a></li>
   <li><a href='options.php'><span>Options</span></a></li>
   <li><a href='login.php'><span>Log Out</span></a></li>
</ul>
</div>


<div style="position:relative;top:40px" align="center">
<h2 class="content"><?php echo $_GET['day']." ".$_GET['month'];?></h2>
<div style="position:relative;">
<div style="font-family:Helvetica Neue,Helvetica,Arial,Verdana,sans-serif; color:rgb(0,191,255); font-size:25px;">
Things To Do Today
</div>
<br />

<form id="main" class="main" method="post" >
<table>
<tr>
<td style="font-size:22px;color:orange">1. &nbsp </td>
<td> <input type="text" id="1" name="1" class="input1" value="<?php  if($num>0){echo $row['1t'];} ?>"></input></td>
<td>
<input type="checkbox" class="box" name="1c" id="1c" <?php if($row['array'][0]=="1"){echo "checked";} ?>  /> 
</td>
</tr>

<tr>
<td style="font-size:22px;color:orange">2. &nbsp </td>
<td><input type="text" class="input1" name="2" id="2" value="<?php  if($num>0){echo $row['2t'];} ?>"></input></td>
<td> 
<input type="checkbox" class="box" id="2c" name="2c" <?php if($row['array'][1]=="1"){echo "checked";} ?> /> 
</td>
</tr>
<tr>
<td style="font-size:22px;color:orange">3. &nbsp </td>
<td><input type="text" class="input1" name="3" id="3" value="<?php if($num>0){echo $row['3t'];} ?>"></input> </td>
<td>
<input type="checkbox" class="box" name="3c" id="3c" <?php if($row['array'][2]=="1"){echo "checked";} ?> />  
</td>
</tr>
<tr>
<td style="font-size:22px;color:orange"> 4. &nbsp </td>
<td><input type="text" class="input1" name="4" id="4" value="<?php  if($num>0){echo $row['4t'];} ?>"></input> </td>
<td> 
<input type="checkbox" class="box" name="4c" id="4c" <?php if($row['array'][3]=="1"){echo "checked";} ?> /> 
</td>
</tr>
<tr>
<td style="font-size:22px;color:orange">5. &nbsp </td>
<td><input type="text" class="input1" name="5" id="5" value="<?php  if($num>0){echo $row['5t'];} ?>"></input> </td>
<td> 
<input type="checkbox" class="box" name="5c" id="5c"  <?php if($row['array'][4]=="1"){echo "checked";} ?> /> 
</td>
</tr>





</table>
<input name="submit" type="submit" value="Save" class="btn"  />
</form>

</div>
</div>


<div class="footer" align="center">
<text style="color:rgb(0,191,255)">Devoloped and Maintained by:</text><br />
AnanthaNatarajan.S<br />
 112112008<br /><br /> &nbsp

</div>



<!--
<div class="slideThree"  >	
	<input type="checkbox" value="None" id="slideThree" name="check" style="visibility:hidden"  />
	<label for="slideThree"></label>
</div>
-->

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

$username = mysql_real_escape_string($_SESSION['user']);
$target=$_SESSION['phone'];
$mm=$_GET['mm'];
$yy=$_GET['yy'];
$dd=$_GET['day'];
if($dd<10)
$dd="0".$dd;
if($mm<10)
$mm="0".$mm;
$dat=$yy.$mm.$dd;

$array="";
$done=0;
$count=0;
$msg="1.)";
if($_REQUEST['1']!="")
{
$t1=$_REQUEST['1']; 
$msg=$msg." ".$_REQUEST['1'];
$count++;
if(isset($_REQUEST['1c']))
{$done++;$array=$array."1";}
else
$array=$array."0";
}

if($_REQUEST['2']!="")
{
$t2=$_REQUEST['2'];

$msg=$msg." 2.) ".$_REQUEST['2'];
$count++;
if(isset($_REQUEST['2c']))
{$done++;$array=$array."1";}
else
$array=$array."0";
}

if($_REQUEST['3']!="")
{
$t3=$_REQUEST['3'];

			 
$msg=$msg." 3.) ".$_REQUEST['3'];
$count++;
if(isset($_REQUEST['3c']))
{$done++;$array=$array."1";}
else
$array=$array."0";
}

if($_REQUEST['4']!="")
{
$t4=$_REQUEST['4'];

$msg=$msg." 4.) ".$_REQUEST['4'];
$count++;
if(isset($_REQUEST['4c']))
{$done++;$array=$array."1";}
else
$array=$array."0";
}
if($_REQUEST['5']!="")
{
$t5=$_REQUEST['5'];

$msg=$msg." 5.) ".$_REQUEST['5'];
$count++;
if(isset($_REQUEST['5c']))
{$done++;$array=$array."1";}
else
$array=$array."0";
}

$phones=mysql_fetch_assoc(mysql_query("SELECT * FROM user_info WHERE username='$username'"));
$phone=$phones['phone'];
mysql_query("INSERT INTO `".$username."`(date,1t,2t,3t,4t,5t,array,total,done) 
             VALUES ('$dat','$t1','$t2','$t3','$t4','$t5','$array','$count','$done')
			 ON DUPLICATE KEY UPDATE
			 1t='$t1',2t='$t2' ,3t='$t3',4t='$t4',5t='$t5',array='$array',total='$count',done='$done'	");

$s=mysql_query("SELECT * FROM user_msg WHERE date='$dat' AND username='$username' ");


	$nu=mysql_num_rows($s);
   if($nu>0)
   {
     mysql_query("UPDATE user_msg 
				  SET msg='$msg',target='$phone'
				  WHERE date='$dat' AND username='$username'");
   }
   else
   {
    mysql_query("INSERT INTO user_msg (date,username,target,msg)
             VALUES ('$dat','$username','$phone','$msg') ");
	 
   }







header("Location:"."http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
mysql_close($conid);			  
}
?>
</body>
</html>