<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;
	
	$NaturesLaboratoryCountries = new Natures_Laboratory_COA_Products_Countries($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $countries = array();
	$countries = $NaturesLaboratoryCountries->all();