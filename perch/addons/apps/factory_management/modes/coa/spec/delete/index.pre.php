<?php
	
	if (!$CurrentUser->has_priv('factory_management.coa')) exit;
	
	$FactoryManagementCOASpec = new Factory_Management_COA_specs($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');

    if($Form->submitted()) {
    
        $specID = (int) $_GET['id'];  
		$Spec = $FactoryManagementCOASpec->find($specID, true);
		
		$Spec->delete();
		$deleted = true;
		$message = $HTML->success_message('Spec has been successfully deleted. Return to %sSpecs%s', '<a href="'.$API->app_path().'/coa/spec/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this Spec?', '', ''); 
    }