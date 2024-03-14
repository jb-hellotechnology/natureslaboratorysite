<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;

	$NaturesLaboratoryMSDS = new Natures_Laboratory_MSDSs($API); 
	$NaturesLaboratoryMSDSTemplate = new Natures_Laboratory_MSDS_Templates($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $products = $NaturesLaboratoryMSDS->getProducts();
    $cas = $NaturesLaboratoryMSDS->getCAS($_GET['id']);

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('STOCK_CODE','CAS');	   
    	$data = $Form->receive($postvars);      
    	
    	$data['casID'] = $_GET['id'];

        $new_cas = $NaturesLaboratoryMSDS->updateCAS($data);

        // SHOW RELEVANT MESSAGE
        if ($new_cas) {
            $message = $HTML->success_message('CAS has been successfully updated. Return to %sMSDS%s', '<a href="'.$API->app_path().'/msds/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, CAS could not be created.');
        }
        
    }