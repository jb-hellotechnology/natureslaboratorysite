<?php

	if (!$CurrentUser->has_priv('natures_laboratory.staff')) exit;

	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTime = new Natures_Laboratory_Staff_Member_Times($API);    
	$NaturesLaboratoryStaffBankholidays = new Natures_Laboratory_Staff_Member_Bankholidays($API);
	$NaturesLaboratoryStaffHolidays = new Natures_Laboratory_Staff_Member_Holidays($API);  
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $StaffMember = $NaturesLaboratoryStaff->find($_GET['id'], true);
	$details = $StaffMember->to_array();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('date_day', 'date_month', 'date_year', 'length');	   
    	$data = $Form->receive($postvars);      

		$data['staffID'] = $_GET['id'];
		$data['date'] = "$data[date_year]-$data[date_month]-$data[date_day]";
		
		unset($data['date_day']);
		unset($data['date_month']);
		unset($data['date_year']);
		
        $holiday = $NaturesLaboratoryStaffHolidays->create($data);

        $message = $HTML->success_message('Holiday has been successfully created. Return to %sHolidays%s', '<a href="'.$API->app_path().'/staff/holidays/?id="'.$_GET['id'].'>', '</a>'); 
        
    }