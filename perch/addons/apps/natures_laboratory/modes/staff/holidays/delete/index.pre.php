<?php
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API); 
	$NaturesLaboratoryStaffBankholidays = new Natures_Laboratory_Staff_Member_Bankholidays($API);
	$NaturesLaboratoryStaffHolidays = new Natures_Laboratory_Staff_Member_Holidays($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $StaffMember = $NaturesLaboratoryStaff->find($_GET['staffID'], true);
	$details = $StaffMember->to_array();

    if($Form->submitted()) {
    
        $HolidayID = (int) $_GET['id'];  
		$Holiday = $NaturesLaboratoryStaffHolidays->find($HolidayID, true);
		
		$Holiday->delete();
		$deleted = true;
		$message = $HTML->success_message('Holiday has been successfully deleted. Return to %sHolidays%s', '<a href="'.$API->app_path().'/staff/holidays/?id='.$_GET['staffID'].'">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this holiday?', '', ''); 
    }