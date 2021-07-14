<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.task')) exit;
    
    $NaturesLaboratoryTask = new Natures_Laboratory_Tasks($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $tasks = array();
    $tasks = $NaturesLaboratoryTask->all();