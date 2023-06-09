<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
	
	$NaturesLaboratoryProduction = new Natures_Laboratory_Productions($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    $Template->set('natures_laboratory/production_wpo.html','nl');
    
    $task = $NaturesLaboratoryProduction->find($_GET['id'], true);

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('status', 'unitsMade', 'packagingNotes', '250ml', '500ml', '1000ml', '5l', '25l', 'other', 'completedBy');	   
    	$data = $Form->receive($postvars);     
    	
    	if(!$data['250ml']){unset($data['250ml']);}
    	if(!$data['500ml']){unset($data['500ml']);}
    	if(!$data['1000ml']){unset($data['1000ml']);}
    	if(!$data['5l']){unset($data['5l']);}
    	if(!$data['25l']){unset($data['25l']);}
    	if(!$data['other']){unset($data['other']);}
    	
    	$data['completedDate'] = date('Y-m-d');

        $new_task = $task->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_task) {
            $message = $HTML->success_message('Production process successfully completed. Return to %sProduction%s', '<a href="'.$API->app_path().'/production/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, production process could not be completed.');
        }
        
    }