<?php
	
	if (!$CurrentUser->has_priv('factory_management.coa')) exit;
	
	$FactoryManagementCountries = new Factory_Management_COA_Countries($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $countries = array();
	$countries = $FactoryManagementCountries->all();