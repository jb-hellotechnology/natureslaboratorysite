<?php
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    $staffID = (int) $_GET['id'];  
    $StaffMember = $NaturesLaboratoryStaff->find($staffID, true);
    $details = $StaffMember->to_array();
	
	$times = array();
    $times = $NaturesLaboratoryStaffTimes->forMonth(date('Y-m'),$_GET['id']);