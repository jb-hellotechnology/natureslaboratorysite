<?php
	
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryShopify = new Natures_Laboratory_Shopifys($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $lastImport = $NaturesLaboratoryShopify->lastImport();
    
/*
    if($Form->submitted()){
	    // Import Stock
	    $NaturesLaboratoryShopify->importStock();
	    $message = $HTML->success_message('CSV successfully imported'); 
	}
*/