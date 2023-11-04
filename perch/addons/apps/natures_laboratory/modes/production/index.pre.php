<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryProduction = new Natures_Laboratory_Productions($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $chemicals = array();
    $chemicals = $NaturesLaboratoryProduction->getShortfall(1);
    
    $tinctures = array();
    $tinctures = $NaturesLaboratoryProduction->getShortfall(2);
    
    $fluids = array();
    $fluids = $NaturesLaboratoryProduction->getShortfall(4);
    
    $beeVital = array();
    $beeVital = $NaturesLaboratoryProduction->getShortfall(10);
    
    $creams = array();
    $creams = $NaturesLaboratoryProduction->getShortfall(11);
    
    $essentialOils = array();
    $essentialOils = $NaturesLaboratoryProduction->getShortfall(12);
    
    $fixedOils = array();
    $fixedOils = $NaturesLaboratoryProduction->getShortfall(13);
    
    $capsules = array();
    $capsules = $NaturesLaboratoryProduction->getShortfall(8);
    
    $sweetCecilys = array();
    $sweetCecilys = $NaturesLaboratoryProduction->getShortfall(22);
    
    $contract = array();
    $contract = $NaturesLaboratoryProduction->getShortfall(40);