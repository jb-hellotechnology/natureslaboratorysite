<?php
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTime = new Natures_Laboratory_Staff_Member_Times($API);    
	$NaturesLaboratoryStaffBankholidays = new Natures_Laboratory_Staff_Member_Bankholidays($API);  
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('date');	   
    	$data = $Form->receive($postvars);      

        $new_time = $NaturesLaboratoryStaffBankholidays->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_time) {
            $message = $HTML->success_message('Bank Holiday has been successfully created. Return to %sBank Holidays%s', '<a href="'.$API->app_path().'/staff/bank-holidays/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Bank Holiday could not be created.');
        }
        
    }