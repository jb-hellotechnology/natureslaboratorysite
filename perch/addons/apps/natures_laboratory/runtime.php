<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include('Natures_Laboratory.class.php');
	include('Natures_Laboratorys.class.php');
	include('Natures_Laboratory.staffmember.class.php');
	include('Natures_Laboratory.staffmembers.class.php');
	include('Natures_Laboratory.staffmember.time.class.php');
	include('Natures_Laboratory.staffmember.times.class.php');
	
	function timemoto_log($name,$timeLoggedRounded,$attendanceStatus,$data){

		$Time = new Natures_Laboratory_Staff_Member_Times();
		
		$Time->timemoto_log($name,$timeLoggedRounded,$attendanceStatus,$data);
	   
	}