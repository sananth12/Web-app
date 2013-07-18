<?php
session_start();
if(isset($_SESSION['user']) && $_SESSION['user']!='' ){$username=$_SESSION['user'];}
else
{
    header("Location: login.php"); 
}

header("Content-type: image/png");

$arrval =array(0);
//$arrval = array(12,123,21,32,77,85,166,176,163,121);

$conid=mysql_connect("localhost","root","");
mysql_select_db("project",$conid);

$s=mysql_query("SELECT * FROM sananth12 WHERE bmi!='NULL'");

while($row=mysql_fetch_assoc($s))
{
   array_push($arrval,$row['total']);
  
}

//array_push($arrval,);

$height = 260;

$width = 330;

$im = imagecreate($width,$height);

$white = imagecolorallocate($im,255,255,255);

$gray = imagecolorallocate($im,200,200,200);

$black = imagecolorallocate($im,0,0,0);

$red = imagecolorallocate($im,255,0,0);

$x = 21;

$y = 11;

$num = 0;

while($x<=$width && $y<=$height){

$prcnt = ((($height-50)-($y-1))/($height-60))*100;

imageline($im, 21, $y, $width-10, $y, $gray);

imageline($im, $x, 11, $x, $height-50, $gray);

imagestring($im,2,1,$y-10,$prcnt.'%',$red);

imagestring($im,2,$x-3,$height-40,$num,$red);

$x += 30;

$y += 20;

$num++;

}

$tx = 20;

$ty = 210;

foreach($arrval as $values){

$cx = $tx + 30;

$cy = 200-$values;

imageline($im,$tx,$ty,$cx,$cy,$red);

imagestring($im,5,$cx-3,$cy-13,'.',$red);

$ty = $cy;

$tx = $cx;

}

imageline($im, 20, 11, 20, $height-50, $black);

imageline($im, 20, $height-49, $width-10, $height-49, $black);

imagestring($im,3,10,$height-20,'Bmi Graph',$red);

imagepng($im);

?>