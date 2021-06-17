<?php

	if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
	
	$NaturesLaboratoryGoodsSuppliers = new Natures_Laboratory_Goods_Suppliers($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('name');	   
    	$data = $Form->receive($postvars);      

        $new_time = $NaturesLaboratoryGoodsSuppliers->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_time) {
            $message = $HTML->success_message('Supplier has been successfully created. Return to %sSuppliers%s', '<a href="'.$API->app_path().'/goods-in/suppliers/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Supplier could not be created.');
        }
        
    }