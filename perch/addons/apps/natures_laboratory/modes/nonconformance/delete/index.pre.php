<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
	
	$NaturesLaboratoryNonconformances = new Natures_Laboratory_Nonconformances($API);  
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $nonconformance = array();
    $details = array();

    if($Form->submitted()) {
    
        $nonconformanceID = (int) $_GET['id'];  
		$NaturesLaboratoryNonconformances = $NaturesLaboratoryNonconformances->find($nonconformanceID, true);
		
		$NaturesLaboratoryNonconformances->delete();
		
		$deleted = true;
		$message = $HTML->success_message('Non conformance has been successfully deleted. Return to %sNon Conformance%s', '<a href="'.$API->app_path().'/nonconformance/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this record?', '', ''); 
    }