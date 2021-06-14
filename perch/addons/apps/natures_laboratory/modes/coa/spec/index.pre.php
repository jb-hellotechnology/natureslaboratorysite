<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	$NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Specs($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $spec = array();
	$spec = $NaturesLaboratoryCOASpec->all();