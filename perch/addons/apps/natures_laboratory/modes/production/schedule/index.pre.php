<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
	
	$NaturesLaboratoryProduction = new Natures_Laboratory_Productions($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    $Template->set('natures_laboratory/production_wpo.html','nl');

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('sku','units','specification','packaging','labelling','status');	   
    	$data = $Form->receive($postvars);     

        $new_production = $NaturesLaboratoryProduction->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_production) {
            $message = $HTML->success_message('Production process successfully scheduled. Return to %sProduction%s', '<a href="'.$API->app_path().'/production/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, production process could not be created.');
        }
        
    }