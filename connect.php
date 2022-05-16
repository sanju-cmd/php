<?php

    $ServerName="localhost";
    $UserName="username";
    $Password="password";
    $DBName="database";
    
    $conn=new mysqli($ServerName,$UserName,$Password,$DBName);
    //Check Connection
    if($conn->connect_error){
        die("Connection Failed: ".$conn->connect_error);
    }
     // Date Time area 
    date_default_timezone_set("asia/kolkata");
    $data=array(
        "date"=>date("M d,Y"),
        "time"=>date("h:i:s A"),
        "day"=>date("l"),
        "baseName"=>"Website Name",
        
        "baseLogo"=>"logo.png",
    
		"baseFavicon"=>"favicon.png",
        "baseLogoName"=>"logoname.png",
    );
	
    $date=$data['date'];
    $time=$data['time'];
	$dat=date("d-m-y");
    $otp=1234;//rand(1000,9999);
   
?>
