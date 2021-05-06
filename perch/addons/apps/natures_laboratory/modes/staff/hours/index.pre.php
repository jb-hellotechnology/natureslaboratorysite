<?php
	$NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API); 
	$NaturesLaboratoryStaffTimes = new Natures_Laboratory_Staff_Member_Times($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    $staffID = (int) $_GET['id'];  
    if($staffID){
	    $StaffMember = $NaturesLaboratoryStaff->find($staffID, true);
	    $details = $StaffMember->to_array();
		
		$times = array();
		if($_GET['date']){
			$date = $_GET['date'];
		}else{
			$date = date('Y-m');
		}
	    $times = $NaturesLaboratoryStaffTimes->forMonth($date,$_GET['id']);
    }else{
	    $staff = array();
		$staff = $NaturesLaboratoryStaff->all();
    }