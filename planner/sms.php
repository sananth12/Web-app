<?php 
include "includes/connect.php";


//$conid=mysql_connect("localhost","root","");
//mysql_select_db("project",$conid);

$date=date("Y-m-d");


$s=mysql_query("SELECT * FROM user_msg WHERE date='$date'");
if($s!="")
{
$num=mysql_num_rows($s);
if($num>=1)
 {while ($row = mysql_fetch_assoc($s)) 
   {
    $msg= $row["msg"];
	$target= $row["target"];
    
	send( $target,$msg);
   }
   }
}


echo "Processing";

function send($phone, $msg)
{
  $uid='9442221004';
  $pwd='delta';
  echo "entry";
$curl = curl_init();

  $timeout = 300;
 
 $result = array();

 curl_setopt($curl, CURLOPT_URL, "http://sms.fullonsms.com/login.php");

  curl_setopt($curl, CURLOPT_POST, 1);

  curl_setopt($curl, CURLOPT_POSTFIELDS, "MobileNoLogin=".$uid."&LoginPassword=".$pwd);
  
  curl_setopt($curl, CURLOPT_COOKIESESSION, 1);
 
 curl_setopt($curl, CURLOPT_COOKIEFILE, "cookie_sms");
 
 curl_setopt($curl, CURLOPT_COOKIEJAR,  "cookie_sms");

  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 
 curl_setopt($curl, CURLOPT_REFERER, "http://sms.fullonsms.com/login.php");
 
 $text = curl_exec($curl);
//echo $text;
//echo $phone." ".$msg; 

 $msg = urlencode(substr($msg, 0, 160));
  
$pharr =  $phone;
 
curl_setopt($curl, CURLOPT_URL, "http://sms.fullonsms.com/home.php");
 
 $text = curl_exec($curl);

  $p=$pharr;

    $p = urlencode($p);

 
   curl_setopt($curl, CURLOPT_URL, 'http://sms.fullonsms.com/home.php');
 
  /* curl_setopt($curl, CURLOPT_REFERER, "http://sms.fullonsms.com/home.php?show=contacts");*/
 
   curl_setopt($curl, CURLOPT_POST, 1);
 
   curl_setopt($curl, CURLOPT_POSTFIELDS,
      "ActionScript=%2Fhome.php&CancelScript=%2Fhome.php&HtmlTemplate=%2Fvar%2Fwww%2Fhtml%2Ffullonsms%2FStaticSpamWarning.html&MessageLength=140&MobileNos=$p&Message=$msg&Gender=0&FriendName=Your+Friend+Name&ETemplatesId=&TabValue=contacts");
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   
 $contents = curl_exec($curl);

 //echo $text;

echo "Done";
}
 
?>