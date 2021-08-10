<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;
	
	$NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Products_Specs($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');

    if($Form->submitted()) {
    
        $specID = (int) $_GET['id'];  
		$Spec = $NaturesLaboratoryCOASpec->find($specID, true);
		
		$Spec->delete();
		$deleted = true;
		$message = $HTML->success_message('Spec has been successfully deleted. Return to %sSpecs%s', '<a href="'.$API->app_path().'/coa-products/spec/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this Spec?', '', ''); 
    }