<?php
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API); 
	$NaturesLaboratoryStaffBankholidays = new Natures_Laboratory_Staff_Member_Bankholidays($API);  
	$NaturesLaboratoryStaffEarlyfinishes = new Natures_Laboratory_Staff_Member_Earlyfinishes($API);   
	$NaturesLaboratoryStaffSickdays = new Natures_Laboratory_Staff_Member_Sickdays($API);  
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $staffID = $_GET['id'];
    $StaffMember = $NaturesLaboratoryStaff->find($staffID, true);
	$details = $StaffMember->to_array(); 

    if($Form->submitted()) {
    
        $SickdayID = (int) $_GET['sickdayID'];  
		$Sickday = $NaturesLaboratoryStaffSickdays->find($SickdayID, true);
		
		$Sickday->delete();
		$deleted = true;
		$message = $HTML->success_message('Sick Day has been successfully deleted. Return to %sSick Days%s', '<a href="'.$API->app_path().'/staff/sick-days/?id='.$_GET['id'].'">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this Sick Day?', '', ''); 
    }