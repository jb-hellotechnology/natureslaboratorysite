<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;
    
    $NaturesLaboratoryMSDS = new Natures_Laboratory_MSDSs($API);
    $NaturesLaboratoryCOA = new Natures_Laboratory_COAs($API);
    $NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Specs($API);
    $NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $msdsTemplates = array();
    $msdsTemplates = $NaturesLaboratoryMSDS->getMSDSTemplates();