<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;

	$NaturesLaboratoryMSDS = new Natures_Laboratory_MSDSs($API); 
	$NaturesLaboratoryMSDSTemplate = new Natures_Laboratory_MSDS_Templates($API); 
	$NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $msdsTemplates = $NaturesLaboratoryMSDSTemplate->allTemplates();
    $stock = $NaturesLaboratoryGoodsStock->getStock();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('productType','productCode');	   
    	$data = $Form->receive($postvars);   
    	
    	if(!$NaturesLaboratoryMSDS->msds_exists($data['productCode'])){
	    	$new_msds = $NaturesLaboratoryMSDS->create($data);	
    	}

        // SHOW RELEVANT MESSAGE
        if ($new_msds) {
            $message = $HTML->success_message('MSDS has been successfully created. Return to %sMSDS%s', '<a href="'.$API->app_path().'/msds/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('MSDS for this product code already exists.');
        }
        
    }