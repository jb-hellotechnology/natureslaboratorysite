<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;

	$NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Capsules_Specs($API); 
	$NaturesLaboratoryCOACountries = new Natures_Laboratory_COA_Capsules_Countries($API); 
	$NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API);   
    
    $stock = $NaturesLaboratoryGoodsStock->all();
    $country = $NaturesLaboratoryCOACountries->all();
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $Template->set('natures_laboratory/spec-product.html','nl');
    
    $specID = (int) $_GET['id'];  
    $Spec = $NaturesLaboratoryCOASpec->find($specID, true);
    $details = $Spec->to_array();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('productType','productCode','commonName','biologicalSource','plantPart','strengthVolume','alcoholContent','countryOfOrigin','colour','odour','taste','pH','specificGravity');	   
    	$data = $Form->receive($postvars);    
    	
    	// READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['natures_laboratory_coa_products_specDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['natures_laboratory_coa_products_specDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $NaturesLaboratoryCOASpec, $Spec);
        $data['natures_laboratory_coa_products_specDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);  

        $new_spec = $Spec->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_spec) {
            $message = $HTML->success_message('Spec has been successfully updated. Return to %sSpecs%s', '<a href="'.$API->app_path().'/coa-products/spec/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Spec could not be updated.');
        }
        
        $Spec = $NaturesLaboratoryCOASpec->find($specID, true);
		$details = $Spec->to_array();
        
    }