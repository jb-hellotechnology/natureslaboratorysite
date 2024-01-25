<?php
	
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryShopify = new Natures_Laboratory_Shopifys($API); 
    
    $Settings = $API->get('Settings');
	$token = $Settings->get('natures_laboratory_ha_shopify')->settingValue();
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    if($Form->submitted()){
	    // Import Stock
        $postvars = array('chemicals','tinctures','cuts','capsules','beevital');	   
    	$data = $Form->receive($postvars);
	    $output = $NaturesLaboratoryShopify->syncha($token,$data);
	    $message = $HTML->success_message('Stock levels successfully synchronised'); 
	}