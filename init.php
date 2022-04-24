<?php 
	session_start();
	date_default_timezone_set('asia/kolkata');
	$date=date('d-m-Y');
	$time=date('h:i:s A');
	$datetime=$date.' '.$time;

	spl_autoload_register(function($class_name){

	    include "classes/$class_name.php";


	});

	$source = new source;

	
	
?>