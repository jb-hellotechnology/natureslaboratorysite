<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryLabels = new Natures_Laboratory_Labels($API); 
    $NaturesLaboratoryLabelsProducts = new Natures_Laboratory_Labels_Products($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $products = array();
    $products = $NaturesLaboratoryLabelsProducts->all();