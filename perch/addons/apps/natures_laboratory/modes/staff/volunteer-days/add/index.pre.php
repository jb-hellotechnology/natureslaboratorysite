<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTime = new Natures_Laboratory_Staff_Member_Times($API);    
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
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('date');	   
        
    	$data = $Form->receive($postvars);      
		$data['staffID'] = $_GET['id'];
		
        $new_time = $NaturesLaboratoryStaffVolunteerday->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_time) {
            $message = $HTML->success_message('Volunteer Day has been successfully created. Return to %sVolunteer Day%s', '<a href="'.$API->app_path().'/staff/volunteer-days/?id='.$_GET['id'].'">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Volunteer Day could not be created.');
        }
        
    }