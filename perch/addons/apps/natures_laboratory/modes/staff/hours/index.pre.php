<?php
/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
*/

	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API); 
	$NaturesLaboratoryStaffEarlyFinish = new Natures_Laboratory_Staff_Member_Earlyfinishes($API); 
	$NaturesLaboratoryStaffBankholiday = new Natures_Laboratory_Staff_Member_Bankholidays($API);
	$NaturesLaboratoryStaffCompassionate = new Natures_Laboratory_Staff_Member_Compassionatedays($API);  
	$NaturesLaboratoryStaffSickdays = new Natures_Laboratory_Staff_Member_Sickdays($API);    
	$NaturesLaboratoryStaffVolunteerdays = new Natures_Laboratory_Staff_Member_Volunteerdays($API);  
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    $staffID = (int) $_GET['id'];  
    if($staffID){
	    $StaffMember = $NaturesLaboratoryStaff->find($staffID, true);
	    $details = $StaffMember->to_array();
		
		$times = array();
		if($_GET['date']){
			$date = $_GET['date'];
		}else{
			$date = date('Y-m');
		}
	    $times = $NaturesLaboratoryStaffTimes->forMonth($date,$_GET['id']);
    }else{
	    $staff = array();
		$staff = $NaturesLaboratoryStaff->all();
    }