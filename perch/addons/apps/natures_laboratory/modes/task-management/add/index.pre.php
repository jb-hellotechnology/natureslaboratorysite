<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.task')) exit;
    
    $NaturesLaboratoryTask = new Natures_Laboratory_Tasks($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $Template->set('natures_laboratory/task.html','nl');

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array();	   
    	$data = $Form->receive($postvars);   
    	
    	// READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['natures_laboratory_taskDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['natures_laboratory_taskDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $NaturesLaboratoryTask, $Task);
        $data['natures_laboratory_taskDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields); 

		$new_task = $NaturesLaboratoryTask->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_task) {
            $message = $HTML->success_message('Task has been successfully updated. Return to %sTasks%s', '<a href="'.$API->app_path().'/task-management/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Task could not be updated.');
        }
        
    }