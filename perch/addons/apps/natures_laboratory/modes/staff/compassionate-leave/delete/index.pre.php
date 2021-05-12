<?php
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API); 
	$NaturesLaboratoryStaffBankholidays = new Natures_Laboratory_Staff_Member_Bankholidays($API);  
	$NaturesLaboratoryStaffEarlyfinishes = new Natures_Laboratory_Staff_Member_Earlyfinishes($API);   
	$NaturesLaboratoryStaffSickdays = new Natures_Laboratory_Staff_Member_Sickdays($API); 
	$NaturesLaboratoryStaffCompassionateday = new Natures_Laboratory_Staff_Member_Compassionatedays($API);  
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $staffID = $_GET['id'];
    $StaffMember = $NaturesLaboratoryStaff->find($staffID, true);
	$details = $StaffMember->to_array(); 

    if($Form->submitted()) {
    
        $CompassionateID = (int) $_GET['compassionateID'];  
		$Compassionate = $NaturesLaboratoryStaffCompassionateday->find($CompassionateID, true);
		
		$Compassionate->delete();
		$deleted = true;
		$message = $HTML->success_message('Compassionate Leave has been successfully deleted. Return to %sCompassionate Leave%s', '<a href="'.$API->app_path().'/staff/compassionate-leave/?id='.$_GET['id'].'">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this Compassionate Leave?', '', ''); 
    }