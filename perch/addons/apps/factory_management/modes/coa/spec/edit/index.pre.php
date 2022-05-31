<?php
	
	if (!$CurrentUser->has_priv('factory_management.coa')) exit;

	$FactoryManagementCOASpec = new Factory_Management_COA_Specs($API); 
	$FactoryManagementCOACountries = new Factory_Management_COA_Countries($API);   

    $country = $FactoryManagementCOACountries->all();
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $Template->set('Factory_Management/spec.html','nl');
    
    $specID = (int) $_GET['id'];  
    $Spec = $FactoryManagementCOASpec->find($specID, true);
    $details = $Spec->to_array();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('productCode','commonName','biologicalSource','plantPart','productDescription','countryOfOrigin','colour','odor','taste','macroscopicCharacters','microscopicCharacters','macroscopicCharactersLong','microscopicCharactersLong','description','foreignMatter','lossOnDrying','totalAsh','ashInsolubleInHCl','assayContent','leadPb','arsenicAs','mercuryHg','totalAerobicMicrobialCount','totalCombinedYeastMouldsCount','enterobacteriaCountIncludingPseudomonas','escherichiaColi','salmonella','staphylococcusAureus','mycotoxinsAflatoxinsOchratoxinA','pesticides','allergens');	   
    	$data = $Form->receive($postvars);    
    	
    	// READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['specDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['specDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $FactoryManagementCOASpec, $Spec);
        $data['specDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);  

        $new_spec = $Spec->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_spec) {
            $message = $HTML->success_message('Spec has been successfully updated. Return to %sSpecs%s', '<a href="'.$API->app_path().'/coa/spec/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Spec could not be updated.');
        }
        
        $Spec = $FactoryManagementCOASpec->find($specID, true);
		$details = $Spec->to_array();
        
    }