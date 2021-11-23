<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;
	
	$NaturesLaboratoryCOA = new Natures_Laboratory_COA_Capsules($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');

    if($Form->submitted()) {
    
        $coaID = (int) $_GET['id'];  
		$COA = $NaturesLaboratoryCOA->find($coaID, true);
		
		$COA->delete();
		$deleted = true;
		$message = $HTML->success_message('COA has been successfully deleted. Return to %sCOAs%s', '<a href="'.$API->app_path().'/coa-capsules/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this COA?', '', ''); 
    }