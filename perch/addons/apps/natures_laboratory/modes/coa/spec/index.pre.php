<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;

	$NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Specs($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $spec = array();
	$spec = $NaturesLaboratoryCOASpec->all();