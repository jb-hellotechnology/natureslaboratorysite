<?php

	$NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Specs($API); 
	$NaturesLaboratoryCOACountries = new Natures_Laboratory_COA_Countries($API); 
	$NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API);   
    
    $stock = $NaturesLaboratoryGoodsStock->all();
    $country = $NaturesLaboratoryCOACountries->all();
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('productCode','commonName','biologicalSource','plantPart','productDescription','countryOfOrigin','colour','odor','taste','description','macroscopicCharacters','microscopicCharacters','foreignMatter','lossOnDrying','totalAsh','ashInsolubleInHCl','assayContent','leadPb','arsenicAs','mercuryHg','totalAerobicMicrobialCount','totalCombinedYeastMouldsCount','enterobacteriaCountIncludingPseudomonas','escherichiaColi','salmonella','staphylococcusAureus','mycotoxinsAflatoxinsOchratoxinA','pesticides','allergens');	   
    	$data = $Form->receive($postvars);      

        $new_time = $NaturesLaboratoryCOASpec->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_time) {
            $message = $HTML->success_message('Spec has been successfully created. Return to %sSpecs%s', '<a href="'.$API->app_path().'/coa/spec/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Spec could not be created.');
        }
        
    }