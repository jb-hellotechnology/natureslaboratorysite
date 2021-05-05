<?php
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $StaffMemberTime = array();
    $details = array();

    if($Form->submitted()) {
    
        $timeID = (int) $_GET['id'];  
		$StaffMemberTime = $NaturesLaboratoryStaffTimes->find($timeID, true);
		
		$StaffMemberTime->delete();
		$deleted = true;
		$message = $HTML->success_message('Staff hours have been successfully deleted. Return to %sStaff%s', '<a href="'.$API->app_path().'/staff/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this staff hours record?', '', ''); 
    }