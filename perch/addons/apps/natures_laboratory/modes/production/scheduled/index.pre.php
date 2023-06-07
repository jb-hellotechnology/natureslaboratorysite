<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryProduction = new Natures_Laboratory_Productions($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $scheduled = array();
    $scheduled = $NaturesLaboratoryProduction->getScheduled();
    
    $schedule = $NaturesLaboratoryProduction->find($_GET['id'], true);
    
    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('sku','date_day','date_month','date_year','datePressed_day','datePressed_month','datePressed_year','dateSageUpdated_day','dateSageUpdated_month','dateSageUpdated_year','sageUpdatedBy','barrel','status');	   
    	$data = $Form->receive($postvars);     

		$data['date'] = "$data[date_year]-$data[date_month]-$data[date_day]";
    	unset($data['date_year']);
    	unset($data['date_month']);
    	unset($data['date_day']);
    	
    	$data['datePressed'] = "$data[datePressed_year]-$data[datePressed_month]-$data[datePressed_day]";
    	unset($data['datePressed_year']);
    	unset($data['datePressed_month']);
    	unset($data['datePressed_day']);
    	
    	$data['dateSageUpdated'] = "$data[dateSageUpdated_year]-$data[dateSageUpdated_month]-$data[dateSageUpdated_day]";
    	unset($data['dateSageUpdated_year']);
    	unset($data['dateSageUpdated_month']);
    	unset($data['dateSageUpdated_day']);

        $new_schedule = $schedule->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_schedule) {
            $message = $HTML->success_message('Production process successfully entered production. Go to %sIn Production%s to print WPO.', '<a href="'.$API->app_path().'/production/in-production/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, production process could not be created.');
        }
        
    }