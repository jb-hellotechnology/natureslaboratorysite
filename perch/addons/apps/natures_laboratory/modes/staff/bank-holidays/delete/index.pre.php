<?php
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API); 
	$NaturesLaboratoryStaffBankholidays = new Natures_Laboratory_Staff_Member_Bankholidays($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');

    if($Form->submitted()) {
    
        $BankholidayID = (int) $_GET['id'];  
		$Bankholiday = $NaturesLaboratoryStaffBankholidays->find($BankholidayID, true);
		
		$Bankholiday->delete();
		$deleted = true;
		$message = $HTML->success_message('Bank Holiday has been successfully deleted. Return to %sBank Holidays%s', '<a href="'.$API->app_path().'/staff/bank-holidays/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this bank holiday?', '', ''); 
    }