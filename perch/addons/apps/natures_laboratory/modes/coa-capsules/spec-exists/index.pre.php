<?php
	$NaturesLaboratoryCOA = new Natures_Laboratory_COAs($API);
	$NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Specs($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
	$specExists = $NaturesLaboratoryCOASpec->byCode(strip_tags($_GET['productCode']));
	if($specExists){
		echo 'true';
	}else{
		echo 'false';
	}