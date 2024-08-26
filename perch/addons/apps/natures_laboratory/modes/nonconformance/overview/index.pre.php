<?php

	if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;

	$NaturesLaboratoryNonconformances = new Natures_Laboratory_Nonconformances($API);  
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');