<?php

	if (!$CurrentUser->has_priv('factory_management.coa')) exit;

	$FactoryManagementCOASpec = new Factory_Management_COA_Specs($API); 
	$FactoryManagementCOACountries = new Factory_Management_COA_Countries($API);  

    $country = $FactoryManagementCOACountries->all();
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $Template->set('factory_management/spec.html','nl');

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('productCode','commonName','biologicalSource','plantPart','productDescription','countryOfOrigin','colour','odor','taste','description','macroscopicCharacters','microscopicCharacters','macroscopicCharactersLong','microscopicCharactersLong','foreignMatter','lossOnDrying','totalAsh','ashInsolubleInHCl','assayContent','leadPb','arsenicAs','mercuryHg','totalAerobicMicrobialCount','totalCombinedYeastMouldsCount','enterobacteriaCountIncludingPseudomonas','escherichiaColi','salmonella','staphylococcusAureus','mycotoxinsAflatoxinsOchratoxinA','pesticides','allergens');	   
    	$data = $Form->receive($postvars);     
    	
    	// READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['specDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['specDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $FactoryManagementCOASpec, $Spec);
        $data['specDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);  

        $new_time = $FactoryManagementCOASpec->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_time) {
            $message = $HTML->success_message('Spec has been successfully created. Return to %sSpecs%s', '<a href="'.$API->app_path().'/coa/spec/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Spec could not be created.');
        }
        
    }