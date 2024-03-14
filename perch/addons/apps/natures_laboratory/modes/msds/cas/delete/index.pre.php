<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;

	$NaturesLaboratoryMSDS = new Natures_Laboratory_MSDSs($API); 
	$NaturesLaboratoryMSDSTemplate = new Natures_Laboratory_MSDS_Templates($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    if($Form->submitted()) {
    
		$NaturesLaboratoryMSDS->deleteCAS($_GET['id'], true);
		$deleted = true;
		$message = $HTML->success_message('CAS has been successfully deleted. Return to %sMSDS%s', '<a href="'.$API->app_path().'/msds/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this CAS?', '', ''); 
    }