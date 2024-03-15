<?php

	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;

	$NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Oils_Specs($API); 
	$NaturesLaboratoryCOACountries = new Natures_Laboratory_COA_Oils_Countries($API); 
	$NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API);   
    
    $stock = $NaturesLaboratoryGoodsStock->all();
    $country = $NaturesLaboratoryCOACountries->all();
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $Template->set('natures_laboratory/spec-oil.html','nl');

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('productType','productCode','commonName','biologicalSource','plantPart','cas','einecs','manufacturingMethod','countryOfOrigin','colour','odour','appearance','specificGravity','refractiveIndex','opticalRotation','fattyAcid','peroxideValue','iodineValue','saponificationValue');	   
    	$data = $Form->receive($postvars);     
    	
    	// READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['natures_laboratory_coa_oils_specDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['natures_laboratory_coa_oils_specDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $NaturesLaboratoryCOASpec, $Spec);
        $data['natures_laboratory_coa_oils_specDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);  

        $new_time = $NaturesLaboratoryCOASpec->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_time) {
            $message = $HTML->success_message('Spec has been successfully created. Return to %sSpecs%s', '<a href="'.$API->app_path().'/coa-oils/spec/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Spec could not be created.');
        }
        
    }