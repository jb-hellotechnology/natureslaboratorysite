<?php
	$NaturesLaboratoryCOA = new Natures_Laboratory_COA($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');

    if($Form->submitted()) {
    
        $coaID = (int) $_GET['id'];  
		$Goods = $NaturesLaboratoryCOA->find($coaID, true);
		
		$Goods->delete();
		$deleted = true;
		$message = $HTML->success_message('COA has been successfully deleted. Return to %sCOAs%s', '<a href="'.$API->app_path().'/coa/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this COA?', '', ''); 
    }