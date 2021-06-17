<?php
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API); 
	$NaturesLaboratoryStaffEarlyFinish = new Natures_Laboratory_Staff_Member_Earlyfinishes($API); 
	$NaturesLaboratoryStaffBankholiday = new Natures_Laboratory_Staff_Member_Bankholidays($API);    
	$NaturesLaboratoryStaffCompassionate = new Natures_Laboratory_Staff_Member_Compassionatedays($API);  
	$NaturesLaboratoryStaffSickdays = new Natures_Laboratory_Staff_Member_Sickdays($API);    
	$NaturesLaboratoryStaffVolunteerdays = new Natures_Laboratory_Staff_Member_Volunteerdays($API);  
	$NaturesLaboratoryStaffHolidays = new Natures_Laboratory_Staff_Member_Holidays($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    $staffID = (int) $_GET['id'];  
    if($staffID){
	    $StaffMember = $NaturesLaboratoryStaff->find($staffID, true);
	    $details = $StaffMember->to_array();
		$holidays = array();
		$holidays = $NaturesLaboratoryStaffHolidays->byStaffID($_GET['id']);
	
		if($Form->submitted()) {
			//MAKE LABELS
			$postvars = array();
			foreach($holidays as $Holiday){
				array_push($postvars, 'date_'.$Holiday['date']);
			}   
	    	$data = $Form->receive($postvars); 
	    	$list = '';
	    	foreach($data as $date){
		    	$dateParts = explode("-",$date);
		    	$newDate = "$dateParts[2]/$dateParts[1]/$dateParts[0]";
		    	$list .= "<li>$newDate</li>";
	    	}
	    	
	    	$nameParts = explode(" ",$StaffMember->name());
	    	$name = $nameParts[0];
	    	
	    	$message = "Hi $name,<br><br>Your holiday request has been confirmed for the follow dates:<ul>$list</ul>Thanks<br>Jack<br><br>w: www.natureslaboratory.co.uk<br>e: jack@natureslaboratory.co.uk<br>t: (01947) 602346<br><br>Nature’s Laboratory Ltd<br><br>Unit 3B, Enterprise Way, Whitby, North Yorkshire, YO22 4HN<br><br>This email and any attachments to it may be confidential and are intended solely for the use of the individual to whom it is addressed. Any views or opinions expressed are solely those of the author and do not necessarily represent those of Nature’s Laboratory Limited. If you are notthe intended recipient of this email, you must neither take any action based upon its contents, nor copy or show it to anyone. Please contact the sender if you believe you have received this email in error.";
	    	
	    	$to = $StaffMember->email();
	    	$subject = 'Holiday Request Confirmation';
	    	
	    	// To send HTML mail, the Content-type header must be set
			$headers[] = 'MIME-Version: 1.0';
			$headers[] = 'Content-type: text/html; charset=iso-8859-1';
			
			// Additional headers
			$headers[] = 'From: jack@natureslaboratory.co.uk';
			$headers[] = 'Cc: jack@natureslaboratory.co.uk';
			
			// Mail it
			mail($to, $subject, $message, implode("\r\n", $headers));
			
			$message = $HTML->success_message('Holiday confirmation message sent'); 
	    	
    	}	
    }else{
	    $staff = array();
		$staff = $NaturesLaboratoryStaff->all();
    }