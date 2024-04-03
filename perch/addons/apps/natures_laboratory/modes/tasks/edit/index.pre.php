<?php
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
	if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
	
	$NaturesLaboratoryTasks = new Natures_Laboratory_Tasks($API); 
	
	$taskID = (int) $_GET['id'];
	$Task = $NaturesLaboratoryTasks->find($taskID, true); 
	$details = $Task->to_array();
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $Template = $API->get ('Template');

    $Template->set('natures_laboratory/tasks.html','nl');

    // HANDLE BLOCKS FROM TEMPLATE
    $Form->handle_empty_block_generation($Template);
    
    // SET REQUIRED FIELDS
    $Form->set_required_fields_from_template($Template, $details);
	
    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('date_day', 'date_month', 'date_year', 'title', 'dueBy_day', 'dueBy_month', 'dueBy_year', 'createdBy', 'assignedTo', 'status');	   
    	$data = $Form->receive($postvars); 
    	
    	$data['date'] = "$data[date_year]-$data[date_month]-$data[date_day]";
    	unset($data['date_year']);
    	unset($data['date_month']);
    	unset($data['date_day']); 
    	
    	$data['dueBy'] = "$data[dueBy_year]-$data[dueBy_month]-$data[dueBy_day]";
    	unset($data['dueBy_year']);
    	unset($data['dueBy_month']);
    	unset($data['dueBy_day']);  
    	
    	// READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['natures_laboratory_tasksDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($task['natures_laboratory_taskDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $NaturesLaboratoryTasks, $Task);
        $data['natures_laboratory_taskDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);
        
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM  
        $new_task = $Task->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_task) {
            $message = $HTML->success_message('Task has been successfully updated. Return to %sTasks%s', '<a href="'.$API->app_path().'/tasks/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, task could not be updated.');
        }
        
    }