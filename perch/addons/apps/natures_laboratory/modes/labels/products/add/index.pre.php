<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryLabels = new Natures_Laboratory_Labels($API); 
    $NaturesLaboratoryLabelsProducts = new Natures_Laboratory_Labels_Products($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $products = array();
    $products = $NaturesLaboratoryLabelsProducts->all();
    
    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('productCode','productName','productType','notes','productRange','restriction');	   
    	$data = $Form->receive($postvars);     

        $new_product = $NaturesLaboratoryLabelsProducts->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_product) {
            $message = $HTML->success_message('Product has been successfully created. Return to %sProducts%s', '<a href="'.$API->app_path().'/labels/products/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, product could not be created.');
        }
        
    }