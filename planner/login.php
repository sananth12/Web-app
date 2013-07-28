<?php
session_start();
if(isset($_SESSION['user']) && $_SESSION['user']!='')
{ 
session_destroy();
}
?>
<html>

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
top:200px;
bottom:10px;
}
input{
background: #fff;
border: 1px solid #c6c9cc;
border-radius: 4px;
box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.1), 0 1px 0 #fff;
font: 13px/20px 'Droid Sans', Arial, 'Helvetica Neue', 'Lucida Grande', sans-serif;
margin: 0 0 20px 0;
padding: 5px;
width: 250px;
height:35;
font-size:100%;
/*border-color:blue;*/
}
.error
{
color:orange;
}
</style>

<script>
function checkform()
    {
      var flag=0;
      var password=document.getElementById("pass");
      
       if(document.getElementById("username").value=="")
     {
              document.getElementById("username").disabled = true;
         document.getElementById("username").style.borderColor = 'yellow';        
          document.getElementById("username").disabled = false;
         document.getElementById("username_error").innerHTML = "This field must not be left empty";    
         flag++;// return false;
     } 
   
     if(password.value=="")
     {
       document.getElementById("pass").disabled = true;
         document.getElementById("pass").style.borderColor = 'yellow';        
          document.getElementById("pass").disabled = false;
         document.getElementById("pass_error").innerHTML = "This field must not be left empty";    
         flag++;// return false;
     }
	 
	 if(flag!=0)
      return false;
     else
      return true;	 
     }
	
</script>
<title>Total-Planner</title>
</head>

<body>


      

<div id='cssmenu' align="center">
<ul>
   <li style="width:50px"><span>&nbsp </span></li>
   <li ><a href='home.html'><span>Home</span></a></li>
   <li><a href='register.html'><span>Register</span></a></li>
   <li class="active"><a href='login.php'><span>Login</span></a></li>
   <li><a href='#'><span>About</span></a></li>
    
</ul>
</div>


<div style="position:relative;top:80px" align="center">
<h2 class="content">Login</h2>
<div style="position:relative;">

<form  name="mainform" method="post">

<table>

<tr>
<td><div id="error" class="error"></div></td>
</tr>

<tr >
<td >
User name:</td>
</tr>
<tr ><td><div id="username_error" class="error"></div></td></tr>
<tr><td>
<input type="text" id="username" name="username"></input></td>
</tr>

<tr>
<td>Password:</td>
</tr>
<tr ><td><div id="pass_error" class="error"></div></td></tr>
<tr>
<td>
<input type="password" id="pass" name="pass" ></input></td>
</tr>


</table>
<input name="submit" type="submit" value="Login" onclick="return checkform()" />
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
#   						#
#     Anantha Natarajan.S   #  
#         112112008	        #
#         sananth12         #
#							#
#############################

if(isset($_POST['submit']))
{
   include "includes/connect.php";
   
$username=$_POST['username'];
$password=$_POST['pass'];

//$conid=mysql_connect("localhost","root","");
//mysql_select_db("project",$conid);


$s=mysql_query("SELECT * FROM user_info WHERE Username='$username' ");
$num=mysql_num_rows($s);

if($num >=1)
{
   $row=mysql_fetch_assoc($s);
   if($password==$row['Password'])
   {
      session_start();
	  $_SESSION['user']=$username;
	  
      header("Location: logged.php");
   }
   else
   {
      echo  "<script>    
            document.getElementById(\"error\").innerHTML = \"Wrong Password !\";
			 </script>";
   }
}

else{
echo "<script>    
            document.getElementById(\"error\").innerHTML = \"Username not found !\";
	  </script>";
}

}

?>

</body>
</html>
