<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryProduction = new Natures_Laboratory_Productions($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $production = array();
    $production = $NaturesLaboratoryProduction->getProduction();
    
    $task = $NaturesLaboratoryProduction->find($_GET['id'], true);
    
    if($_GET['id']){
    
	    if($Form->submitted()) {
	    
	        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
	        $postvars = array('sku', 'date_day', 'date_month', 'date_year', 'datePressed_day', 'datePressed_month', 'datePressed_year', 'dateSageUpdated_day', 'dateSageUpdated_month', 'dateSageUpdated_year', 'sageUpdatedBy', 'barrel', 'status', 'specification', 'packaging', 'labelling', 'units');	   
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
	
	        $new_schedule = $task->update($data);
	        
	        $postvars = array('ingredients');	   
	    	$data = $Form->receive($postvars);
	    	$i = 1;
	    	while($i<=$data['ingredients']){
		    	$postvars = array('ingredient_'.$i,'batch_'.$i);	   
				$iData = $Form->receive($postvars);
				if($iData['ingredient_'.$i] AND $iData['batch_'.$i]){
					$NaturesLaboratoryProduction->saveIngredientBatch($_GET['id'],$iData['ingredient_'.$i],$iData['batch_'.$i]);
				}
		    	$i++;
	    	}
	
	        $message = $HTML->success_message('Production process successfully entered production. Go to %sIn Production%s to print WPO.', '<a href="'.$API->app_path().'/production/in-production/">', '</a>');
	        
	    }
    
    }else{
	    
		if($Form->submitted()) {
	    
	    	if($_POST['wpo']){
		    	//DOWNLOAD WPO
		    	
	    	}elseif($_POST['label']){
		    	//DOWNLOAD LABEL
		    	
	    	}
	        
	    }

	    
    }