<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API); 
	$NaturesLaboratoryStaffEarlyFinish = new Natures_Laboratory_Staff_Member_Earlyfinishes($API); 
	$NaturesLaboratoryStaffBankholidays = new Natures_Laboratory_Staff_Member_Bankholidays($API); 
	$NaturesLaboratoryStaffEarlyfinishes = new Natures_Laboratory_Staff_Member_Earlyfinishes($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $earlyfinishes = array();
	$earlyfinishes = $NaturesLaboratoryStaffEarlyfinishes->all();