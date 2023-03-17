<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
	
	$NaturesLaboratoryLabels = new Natures_Laboratory_Labels($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $Labels = array();

    if($Form->submitted()) {
    
        $labelsID = (int) $_GET['id'];  
		$Labels = $NaturesLaboratoryLabels->find($labelsID, true);
		
		$Labels->delete();
		$deleted = true;
		
		array_map('unlink', glob("../pngs/$labelsID/*.*"));
		rmdir('../pngs/'.$labelsID);
		
		$message = $HTML->success_message('Labels have been successfully deleted. Return to %sLabels%s', '<a href="'.$API->app_path().'/labels/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this record?', '', ''); 
    }