<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;

	$NaturesLaboratoryMSDS = new Natures_Laboratory_MSDSs($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    if($Form->submitted()) {
    
        $msdsID = (int) $_GET['id'];  
		$msds = $NaturesLaboratoryMSDS->find($msdsID, true);
		
		$msds->delete();
		$deleted = true;
		$message = $HTML->success_message('MSDS has been successfully deleted. Return to %sMSDS%s', '<a href="'.$API->app_path().'/msds/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this MSDS?', '', ''); 
    }