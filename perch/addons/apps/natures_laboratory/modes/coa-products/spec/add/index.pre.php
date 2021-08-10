<?php

	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;

	$NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Products_Specs($API); 
	$NaturesLaboratoryCOACountries = new Natures_Laboratory_COA_Products_Countries($API); 
	$NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API);   
    
    $stock = $NaturesLaboratoryGoodsStock->all();
    $country = $NaturesLaboratoryCOACountries->all();
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $Template->set('natures_laboratory/spec-product.html','nl');

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('productType','productCode','commonName','biologicalSource','plantPart','strengthVolume','alcoholContent','countryOfOrigin','colour','odour','taste','pH');	   
    	$data = $Form->receive($postvars);     
    	
    	if($data['alcoholContent']=='25%'){
	    	$data['specificGravity'] = "0.9685";
    	}elseif($data['alcoholContent']=='30%'){
	    	$data['specificGravity'] = "0.9622";
    	}elseif($data['alcoholContent']=='35%'){
	    	$data['specificGravity'] = "0.9491";
    	}elseif($data['alcoholContent']=='45%'){
	    	$data['specificGravity'] = "0.9395";
    	}elseif($data['alcoholContent']=='50%'){
	    	$data['specificGravity'] = "0.9301";
    	}elseif($data['alcoholContent']=='60%'){
	    	$data['specificGravity'] = "0.9091";
    	}elseif($data['alcoholContent']=='70%'){
	    	$data['specificGravity'] = "0.8855";
    	}elseif($data['alcoholContent']=='90%'){
	    	$data['specificGravity'] = "0.8291";
    	}
    	
    	// READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['natures_laboratory_coa_products_specDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['natures_laboratory_coa_products_specDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $NaturesLaboratoryCOASpec, $Spec);
        $data['natures_laboratory_coa_products_specDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);  

        $new_time = $NaturesLaboratoryCOASpec->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_time) {
            $message = $HTML->success_message('Spec has been successfully created. Return to %sSpecs%s', '<a href="'.$API->app_path().'/coa-products/spec/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Spec could not be created.');
        }
        
    }