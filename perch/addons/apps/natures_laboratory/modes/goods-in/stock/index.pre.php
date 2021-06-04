<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	$NaturesLaboratoryStock = new Natures_Laboratory_Goods_Stocks($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $stock = array();
	$stock = $NaturesLaboratoryStock->all();