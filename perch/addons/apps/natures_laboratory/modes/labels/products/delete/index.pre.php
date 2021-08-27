<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryLabels = new Natures_Laboratory_Labels($API); 
    $NaturesLaboratoryLabelsProducts = new Natures_Laboratory_Labels_Products($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $products = array();
    $products = $NaturesLaboratoryLabelsProducts->all();
    
    if($Form->submitted()) {
    
        $productID = (int) $_GET['id'];  
		$Products = $NaturesLaboratoryLabelsProducts->find($productID, true);
		
		$Products->delete();
		$deleted = true;
		$message = $HTML->success_message('Product has been successfully deleted. Return to %sProducts%s', '<a href="'.$API->app_path().'/labels/products/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this product?', '', ''); 
    }