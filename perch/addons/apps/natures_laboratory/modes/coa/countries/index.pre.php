<?php
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

	$NaturesLaboratoryCountries = new Natures_Laboratory_COA_Countries($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $countries = array();
	$countries = $NaturesLaboratoryCountries->all();