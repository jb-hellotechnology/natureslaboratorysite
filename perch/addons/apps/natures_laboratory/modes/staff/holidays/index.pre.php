<?php
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API); 
	$NaturesLaboratoryStaffEarlyFinish = new Natures_Laboratory_Staff_Member_Earlyfinishes($API); 
	$NaturesLaboratoryStaffBankholiday = new Natures_Laboratory_Staff_Member_Bankholidays($API); 
	$NaturesLaboratoryStaffHolidays = new Natures_Laboratory_Staff_Member_Holidays($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    $staffID = (int) $_GET['id'];  
    if($staffID){
	    $StaffMember = $NaturesLaboratoryStaff->find($staffID, true);
	    $details = $StaffMember->to_array();
		$holidays = array();
		$holidays = $NaturesLaboratoryStaffHolidays->byStaffID($_GET['id']);
		
    }else{
	    $staff = array();
		$staff = $NaturesLaboratoryStaff->all();
    }