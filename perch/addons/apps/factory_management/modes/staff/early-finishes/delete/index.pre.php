<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.staff')) exit;
	
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API); 
	$NaturesLaboratoryStaffBankholidays = new Natures_Laboratory_Staff_Member_Bankholidays($API);  
	$NaturesLaboratoryStaffEarlyfinishes = new Natures_Laboratory_Staff_Member_Earlyfinishes($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');

    if($Form->submitted()) {
    
        $EarlyfinishID = (int) $_GET['id'];  
		$Earlyfinish = $NaturesLaboratoryStaffEarlyfinishes->find($EarlyfinishID, true);
		
		$Earlyfinish->delete();
		$deleted = true;
		$message = $HTML->success_message('Early Finish has been successfully deleted. Return to %sEarly Finishes%s', '<a href="'.$API->app_path().'/staff/early-finishes/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this Early Finish?', '', ''); 
    }