<?php 
        session_start();
		if(isset($_SESSION['user']) && $_SESSION['user']!='' ){$username=$_SESSION['user'];}
		else
		{
			header("Location: login.php"); 
		}

		
		//Include phpMyGraph class  
        include_once('phpMyGraph4.0.php'); 
         
		header("Content-type: image/png"); 
		 
		include "includes/connect.php";

		$arrval =array(0,20,100);
		//$arrval = array(12,123,21,32,77,85,166,176,163,121);

		//$conid=mysql_connect("localhost","root","");
		//mysql_select_db("project",$conid);

		$s=mysql_query("SELECT * FROM `".$username."` WHERE date!=''");
		
		$tot=array();
		$done=array();
		while($row=mysql_fetch_assoc($s))
		{
		   $d=$row['date'];
		   $parts = explode('-',$d);
		   $month = $parts[1];
		   $tot[$month]+=$row['total'];
		   $done[$month]+=$row['done'];
			
		} 
		 
		 
                //Create config array for graph 
        $cfg = array 
        ( 
            'title'=>$username."'s Statistics of Total tasks planned / completed  Vs. Time ( in months )", 
            'background-color'=>'FFFFFF', 
            'graph-background-color'=>'FFFFFF', 
            'font-color'=>'#18c5ea',
		    
            'border-color'=>'FFFFFF', 
            'column-color'=>'00FF00', 
            'column-shadow-color'=>'009900', 
            'column-font-color-q1'=>'#16c5ea', 
            'column-font-color-q2'=>'#000', 
            'random-column-color'=>0, 
            'width'=>900,
			'height'=>400,
			'font-size'=>18,
			'transparent-background'=>1,
        ); 
        //Create data array for graph 
        $data = array 
        ( 
            'Jan-Total'=>$tot['01']+0, 
			'Jan-Done' => $done['01']+0,
            'Feb-Total'=>$tot['02']+0,
		    'Feb-Done'=>$done['02']+0,		
            'Mar-Total'=>$tot['03']+0,
			'Mar-Done'=>$done['03']+0,	
            'Apr-Total'=>$tot['04']+0, 
			'Apr-done'=>$done['04']+0,
            'May-Total'=>$tot['05']+0, 
			'May-Done'=>$done['05']+0,
            'Jun-Total'=>$tot['06']+0,
			 'Jun-Done'=>$done['06']+0,	
            'Jul-Total'=>$tot['07']+0,
		    'Jul-Done' =>$done['07']+0, 		
            'Aug-Total'=>$tot['08']+0, 
            'Aug-Done'=>$done['08']+0,
			'Sep-Total'=>$tot['09']+0, 
            'Sep-Done'=>$done['09']+0,
			'Oct-Total'=>$tot['10']+0, 
            'Oct-Done'=>$done['10']+0,
			'Nov-Total'=>$tot['11']+0, 
            'Nov-Done'=>$done['11']+0,
			'Dec-Total'=>$tot['12']+0,
				'Dec-Done'=>$done['12']+0
        ); 
         
        //Create new graph  
        $graph = new phpMyGraph(); 
         
        //Parse vertical line graph 
        $graph->parseVerticalColumnGraph($data,$cfg); 
?>