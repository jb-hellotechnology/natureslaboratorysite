<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryOrders = new Natures_Laboratory_Orders($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $orders = array();
    $orders = $NaturesLaboratoryOrders->getOrders('pending');