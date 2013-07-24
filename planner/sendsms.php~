<?php 
include "includes/connect.php";
//$hour = date('G'); // 0 .. 23
// $day  = date('N');

//$conid=mysql_connect("localhost","root","");
//mysql_select_db("project",$conid);

$date=date("Y-m-d");
//echo $date;

$s=mysql_query("SELECT * FROM user_msg WHERE date='$date'");
if($s!="")
{
$num=mysql_num_rows($s);
if($num>=1)
 {while ($row = mysql_fetch_assoc($s)) 
   {
    $msg= $row["msg"];
	$target= $row["target"];
    
	sendFullonSMS ( '9442221004' , 'delta' ,$target,$msg);
   }
   }
}





echo "Processing";

function sendFullonSMS($uid, $pwd, $phone, $msg)
{
ini_set('max_execution_time', 300);
  echo "entry";
$curl = curl_init();

  $timeout = 300;
 
 $result = array();


 curl_setopt($curl, CURLOPT_URL, "http://sms.fullonsms.com/login.php");

  curl_setopt($curl, CURLOPT_POST, 1);

  curl_setopt($curl, CURLOPT_POSTFIELDS, "MobileNoLogin=".$uid."&LoginPassword=".$pwd."&x=64&y=5&red=");
 
  
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
  
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);    
 
  curl_setopt($curl, CURLOPT_COOKIESESSION, 1);
 
 curl_setopt($curl, CURLOPT_COOKIEFILE, "cookie_fullonsms");
 
 curl_setopt($curl, CURLOPT_COOKIEJAR,  "cookie_fullonsms");

  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  
curl_setopt($curl, CURLOPT_MAXREDIRS, 20);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
 
 
 curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 100);
 
 curl_setopt($curl, CURLOPT_REFERER, "http://sms.fullonsms.com/login.php");
 
 $text = curl_exec($curl);
//echo $text;
//echo $phone." ".$msg; 
  // Check if any error occured
 
 if (curl_errno($curl))
  
  return "access error : ". curl_error($curl);

   
  // Check for proper login
 
   if(!stristr($text,"http://sms.fullonsms.com/landing_page.php")  && !stristr($text,"http://sms.fullonsms.com/home.php?show=contacts") &&!stristr($text, "http://sms.fullonsms.com/action_main.php") )
  
{
    return "invalid login";          
  }

 
 if (trim($msg) == "" || strlen($msg) == 0)
   
 return "invalid message";

  $msg = urlencode(substr($msg, 0, 160));
  
$pharr = explode(",", $phone);
 
 $refurl = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
 
 curl_setopt($curl, CURLOPT_REFERER, $refurl);
 
 curl_setopt($curl, CURLOPT_URL, "http://sms.fullonsms.com/home.php");
 
 $text = curl_exec($curl);


  foreach ($pharr as $p)
 
 {
   
 if (strlen($p) != 10 || !is_numeric($p) || strpos($p, ".") != false)
 
   {
      $result[] = array('phone' => $p, 'msg' => urldecode($msg), 'result' => "invalid number");
      continue;
    }

    $p = urlencode($p);

    // Send SMS
 
   curl_setopt($curl, CURLOPT_URL, 'http://sms.fullonsms.com/home.php');
 
   curl_setopt($curl, CURLOPT_REFERER, "http://sms.fullonsms.com/home.php?show=contacts");
 
   curl_setopt($curl, CURLOPT_POST, 1);
 
   curl_setopt($curl, CURLOPT_POSTFIELDS,
      "ActionScript=%2Fhome.php&CancelScript=%2Fhome.php&HtmlTemplate=%2Fvar%2Fwww%2Fhtml%2Ffullonsms%2FStaticSpamWarning.html&MessageLength=140&MobileNos=$p&Message=$msg&Gender=0&FriendName=Your+Friend+Name&ETemplatesId=&TabValue=contacts");
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   
 $contents = curl_exec($curl);

  
  if(strpos($contents,"window.location.href" )  &&  strpos($contents, 'http://sms.fullonsms.com/MsgSent.php'))
 
   {
      curl_setopt($curl, CURLOPT_POST, 0);
   
   curl_setopt($curl, CURLOPT_REFERER,curl_getinfo($curl, CURLINFO_EFFECTIVE_URL));
  
    curl_setopt($curl, CURLOPT_URL, "http://sms.fullonsms.com/MsgSent.php");
   
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  
    $contents = curl_exec($curl);
    }

   
 //Check Message Status

    $pos = strpos($contents, 'SMS Sent successfully');
   
 $res = ($pos !== false) ? true : false;
    
$result[] = array('phone' => $p, 'msg' => urldecode($msg), 'result' => $res);

  }
 
 //echo $text;

 
 
  /*
curl_setopt($curl, CURLOPT_URL, "http://sms.fullonsms.com/logout.php?LogOut=1");

  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS,"1=1");

 curl_setopt($curl, CURLOPT_REFERER, "http://sms.fullonsms.com/home.php");
 
 $text = curl_exec($curl);

  curl_close($curl);
  return $result;
*/
echo "Done";
}
 
?>