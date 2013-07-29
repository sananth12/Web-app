<html>

<head>
<title>Total-Planner</title>
<style>
body{
font-family:"Helvetica Neue",Helvetica,Arial,Verdana,sans-serif;
color:inherit;
font-size:22px;
}
</style>
</head>
<body align="center">

<?php
#############################
#                            #
#     Anantha Natarajan.S    #  
#         112112008          #
#         sananth12          #
#                            #
#############################


if (isset($_POST['submit']))
{
  
  
 // $conid=mysql_connect("localhost","root","");
  include "includes/connect.php"; 

$flag=0;
$name=$_REQUEST["name"];
$username=$_REQUEST["username"];
$dob=$_REQUEST["txtDate"];
$rep_pass=$_REQUEST["rep_pass"];
$password=$_REQUEST["password"];
$hash=crypt($password);
$email=$_REQUEST["email"];
$phone=$_REQUEST["mob"];

## Validations done server-side ##
if($name=="")
{echo "<p><text style=\"color:red\" >Error:</text> Name field must not be left empty </p><br>";$flag++;}
if($username=="")
{echo "<p><text style=\"color:red\" >Error:</text> User-name field must not be left empty </p><br>";$flag++;}

if($email =="")
{echo "<p><text style=\"color:red\" >Error:</text> E-mail field must not be left empty </p><br>";$flag++;}

if($email!="")
{
   if (!filter_var($email, FILTER_VALIDATE_EMAIL))
   {
    echo "<p><text style=\"color:red\" >Error:</text> E-mail id invalid </p><br>";$flag++;
   }
   if(strpos($email,"spambot.org") || strpos($email,"mailinator.com"))
   {
    echo "<p><text style=\"color:red\" >Error:</text> E-mail id is Blacklisted ! </p><br>";$flag++;
   } 
}


if($password =="")
{echo "<p><text style=\"color:red\" >Error:</text>  Password field must not be left empty </p><br>";$flag++;}
if($password!="")
{ 
  if(strlen($password)<5 || strlen($password)>10)
  {echo "<p><text style=\"color:red\" >Error:</text> Password must contain 5-10 characters </p><br>";$flag++;}
 
  if(preg_match('/\W/',$password))
  {
  
   echo "<p><text style=\"color:red\" >Error:</text> Password must contain a-z, A-Z ,0-9, _ characters only</p><br>";$flag++;
  }
}
if($rep_pass =="")
{echo "<p><text style=\"color:red\" >Error:</text> Repeat password field must not be left empty </p><br>";$flag++;}

if($rep_pass != $password)
{echo "<p><text style=\"color:red\" >Error:</text> Repeat Password field does'nt match the Password</p><br>";$flag++;}

/*
if (mysql_query("CREATE DATABASE project",$conid))
  {
  echo "<p>Database created</p><br />";
  }*/

if($flag==0)
  {
   // mysql_select_db("project", $conid);
	
	$username = mysql_real_escape_string($username);
    mysql_query("CREATE TABLE `".$username."` ( date DATE,1t VARCHAR(30),2t VARCHAR(30),3t VARCHAR(30),4t VARCHAR(30),5t VARCHAR(30), array VARCHAR(30), total INT, done INT,bmi FLOAT,phone VARCHAR(20) DEFAULT '$phone')  ");
   	mysql_query("alter table `".$username."` add unique index(date)");
	mysql_query("INSERT INTO user_info  (Name,Username,Password,Dob,email,phone)
	VALUES ('$name','$username','$password', '$dob','$email','$phone')");	
	
	
	 	
	
	//echo "<p style=\"color:green\">Succesfully Registered !!</p>";
    echo "<script>alert('Registered Succesfully')
	       var t=setTimeout(function(){window.location.assign('login.php')},500)
		</script>";
	
   }
	
	mysql_close($conid);
  }


?>



</body>

</html>
