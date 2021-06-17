<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.staff')) exit;
	
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API); 
	$NaturesLaboratoryStaffBankholidays = new Natures_Laboratory_Staff_Member_Bankholidays($API);  
	$NaturesLaboratoryStaffEarlyfinishes = new Natures_Laboratory_Staff_Member_Earlyfinishes($API);   
	$NaturesLaboratoryStaffSickdays = new Natures_Laboratory_Staff_Member_Sickdays($API); 
	$NaturesLaboratoryStaffCompassionateday = new Natures_Laboratory_Staff_Member_Compassionatedays($API);  
	$NaturesLaboratoryStaffVolunteerday = new Natures_Laboratory_Staff_Member_Volunteerdays($API);  
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $staffID = $_GET['id'];
    $StaffMember = $NaturesLaboratoryStaff->find($staffID, true);
	$details = $StaffMember->to_array(); 

    if($Form->submitted()) {
    
        $VolunteerID = (int) $_GET['volunteerID'];  
		$Volunteer = $NaturesLaboratoryStaffVolunteerday->find($VolunteerID, true);
		
		$Volunteer->delete();
		$deleted = true;
		$message = $HTML->success_message('Volunteer Day has been successfully deleted. Return to %sVolunteer Days%s', '<a href="'.$API->app_path().'/staff/volunteer-days/?id='.$_GET['id'].'">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this Volunteer Day?', '', ''); 
    }