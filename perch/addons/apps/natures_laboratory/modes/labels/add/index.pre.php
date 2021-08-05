<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
	
	$NaturesLaboratoryLabels = new Natures_Laboratory_Labels($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $Goods = array();
    $details = array();
    
    $products = $NaturesLaboratoryLabels->products();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('productCode','batch','bbe_year','bbe_month','bbe_day','size','quantity');	   
    	$data = $Form->receive($postvars);     
    	
    	$data['bbe'] = "$data[bbe_year]-$data[bbe_month]-$data[bbe_day]";
    	unset($data['bbe_year']);
    	unset($data['bbe_month']);
    	unset($data['bbe_day']);

        $new_label = $NaturesLaboratoryLabels->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_label) {
            $message = $HTML->success_message('Labels have been successfully created. Return to %sLabels%s', '<a href="'.$API->app_path().'/labels/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, labels could not be created.');
        }
        
    }