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
    
    if($Form->submitted()){
	    // Import Stock
	    $NaturesLaboratoryShopify->syncbv();
	    $message = $HTML->success_message('Stock levels successfully synchronised'); 
	}