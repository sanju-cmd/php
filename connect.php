<?php

    $ServerName="localhost";
    $UserName="u196314886_ZeroPriceStore";
    $Password="ZeroPriceStore007";
    $DBName="u196314886_ZeroPriceStore";
    
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
        "baseName"=>"Zero Price Store",
        "baseShortName"=>"EmergenceInfotechServices",
        "basePrefixName"=>"EmergenceInfotechServices",
        "baseUrl"=>"www.EmergenceInfotechServices.com",
        "baseUsername"=>"@EmergenceInfotechServices.com",
        "baseUser"=>"EmergenceInfotechServices.com",
        "baseLogo"=>"logo.png",
    
		"baseFavicon"=>"favicon.png",
        "baseLogoName"=>"logoname.png",
    );
	
    $date=$data['date'];
    $time=$data['time'];
	$dat=date("d-m-y");
    $otp=1234;//rand(1000,9999);
   
?>