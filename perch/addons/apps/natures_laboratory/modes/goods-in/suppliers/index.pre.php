<?php

	if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;

	$NaturesLaboratoryGoodsSuppliers = new Natures_Laboratory_Goods_Suppliers($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $suppliers = array();
	$suppliers = $NaturesLaboratoryGoodsSuppliers->all();