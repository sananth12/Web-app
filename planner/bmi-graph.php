<?php 
        session_start();
		if(isset($_SESSION['user']) && $_SESSION['user']!='' )
		{$username=$_SESSION['user'];}
		else
		{
			header("Location: login.php"); 
		}
		include "includes/connect.php";

        include_once('phpMyGraph4.0.php'); 
         
		header("Content-type: image/png"); 
		 
		

		$arrval =array(0,20,100);
		//$arrval = array(12,123,21,32,77,85,166,176,163,121);

		//$conid=mysql_connect("localhost","root","");
		//mysql_select_db("project",$conid);
        mysql_query("");
		$s=mysql_query("SELECT * FROM `".$_SESSION['user']."` WHERE date!='' ORDER BY date");
		
		 $data=array
			(

			);
		$raw=0;
		$counter=array();
		while($row=mysql_fetch_assoc($s))
		{
		   $d=$row['date'];
		   $parts = explode('-',$d);
		   $month = $parts[1]+0;
		   if($raw==0)
		   {
		      for($i=0;$i<$month;$i++)
			  $data['2013-'.$i.'-01']=20+($i/2);
		   
		   }
		    if($row['bmi']!=NULL)
			{
			   $data[$d]=$row['bmi'];
			 
			}
		} 
		 
		
        $cfg = array 
        ( 
            'title'=>$_SESSION['user']."'s Statistics of BMI Vs. Time ( in months )", 
            'background-color'=>'FFFFFF', 
            'graph-background-color'=>'FFFFFF', 
            'font-color'=>'#18c5ea',
		    
            'border-color'=>'#18c5ea', 
            'column-color'=>'00FF00', 
            'column-shadow-color'=>'009900', 
            'column-font-color-q1'=>'#16c5ea', 
            'column-font-color-q2'=>'#000', 
            'random-column-color'=>0, 
            'width'=>$month*75,
			'height'=>400,
			'font-size'=>18,
			'transparent-background'=>1,
        ); 
        
   
         
        $graph = new phpMyGraph(); 
         
       
       $graph->parseVerticalLineGraph($data,$cfg); 
	   // $graph->parseVerticalLineGraph($data,$cfg); 
?>
