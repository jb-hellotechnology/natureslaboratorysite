<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
	
	$NaturesLaboratoryStock = new Natures_Laboratory_Goods_Stocks($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $stock = array();
	$stock = $NaturesLaboratoryStock->all();