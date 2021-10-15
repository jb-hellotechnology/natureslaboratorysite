<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
	
	$NaturesLaboratoryProduction = new Natures_Laboratory_Productions($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $productionID = (int) $_GET['id'];  
    $process = $NaturesLaboratoryProduction->find($productionID, true);
    $details = $process->to_array();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('description', 'batch', 'water', 'alcohol', 'herb', 'programme', 'startTime', 'flow', 'status', 'vessel');	   
    	$data = $Form->receive($postvars);     

        $new_production = $process->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_production) {
            $message = $HTML->success_message('Production process successfully updated. Return to %sProduction%s', '<a href="'.$API->app_path().'/production/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, production process could not be updated.');
        }
        
	}