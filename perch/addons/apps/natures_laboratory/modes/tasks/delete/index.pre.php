<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
	
	$NaturesLaboratoryTasks = new Natures_Laboratory_Tasks($API);  
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $task = array();
    $details = array();

    if($Form->submitted()) {
    
        $taskID = (int) $_GET['id'];  
		$NaturesLaboratoryTask = $NaturesLaboratoryTasks->find($taskID, true);
		
		$NaturesLaboratoryTask->delete();
		
		$deleted = true;
		$message = $HTML->success_message('Task has been successfully deleted. Return to %sTasks%s', '<a href="'.$API->app_path().'/tasks/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this task?', '', ''); 
    }