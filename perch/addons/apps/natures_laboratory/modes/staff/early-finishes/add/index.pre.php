<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.staff')) exit;
	
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTime = new Natures_Laboratory_Staff_Member_Times($API);    
	$NaturesLaboratoryStaffBankholidays = new Natures_Laboratory_Staff_Member_Bankholidays($API); 
	$NaturesLaboratoryStaffEarlyfinishes = new Natures_Laboratory_Staff_Member_Earlyfinishes($API);  
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('date_day', 'date_month', 'date_year', 'targetHit');	   
    	$data = $Form->receive($postvars);      
    	
    	$data['date'] = "$data[date_year]-$data[date_month]-$data[date_day]";
		
		unset($data['date_day']);
		unset($data['date_month']);
		unset($data['date_year']);

        $new_time = $NaturesLaboratoryStaffEarlyfinishes->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_time) {
            $message = $HTML->success_message('Early Finish has been successfully created. Return to %sEarly Finishes%s', '<a href="'.$API->app_path().'/staff/early-finishes/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Early Finish could not be created.');
        }
        
    }