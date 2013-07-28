
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
top:300px;

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




</head>

<body>


      

<div id='cssmenu' align="center">
<ul>
   <li style="width:50px"><span>&nbsp </span></li>
   <li><a href='home.html'><span>Home</span></a></li>  
   <li><a href='#'><span>About</span></a></li>
   <li ><a href='logged.php'><span>Calender</span></a></li>
   <li ><a href='bmi.php'><span>BMI Calculator</span></a></li>
   <li class="active"><a href='graph.php'><span>Statistics</span></a></li>
   <li><a href='login.php'><span>Log Out</span></a></li>
</ul>
</div>


<div style="position:relative;top:80px" align="center">
<h2 class="content">Statistics</h2>
<div style="position:relative;top:20px">
<img src="graph-lib.php"/>
</div>
<br />
<br />
<div style="position:relative;top:20px">
<img src="bmi-graph.php"/>
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




</body>

</html>
