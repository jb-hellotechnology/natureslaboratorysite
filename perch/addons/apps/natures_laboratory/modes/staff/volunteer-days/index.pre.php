<?php
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API); 
	$NaturesLaboratoryStaffEarlyFinish = new Natures_Laboratory_Staff_Member_Earlyfinishes($API); 
	$NaturesLaboratoryStaffBankholiday = new Natures_Laboratory_Staff_Member_Bankholidays($API);
	$NaturesLaboratoryStaffSickday = new Natures_Laboratory_Staff_Member_Sickdays($API);  
	$NaturesLaboratoryStaffCompassionateday = new Natures_Laboratory_Staff_Member_Compassionatedays($API); 
	$NaturesLaboratoryStaffVolunteerday = new Natures_Laboratory_Staff_Member_Volunteerdays($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    $staffID = (int) $_GET['id'];  
    $StaffMember = $NaturesLaboratoryStaff->find($staffID, true);
    $details = $StaffMember->to_array();
    
    $volunteerdays = $NaturesLaboratoryStaffVolunteerday->getDays($staffID);