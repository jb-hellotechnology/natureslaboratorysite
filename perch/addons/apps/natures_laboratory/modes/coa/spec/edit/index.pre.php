<?php

	$NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Specs($API); 
	$NaturesLaboratoryCOACountries = new Natures_Laboratory_COA_Countries($API); 
	$NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API);   
    
    $stock = $NaturesLaboratoryGoodsStock->all();
    $country = $NaturesLaboratoryCOACountries->all();
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $specID = (int) $_GET['id'];  
    $Spec = $NaturesLaboratoryCOASpec->find($specID, true);
    $details = $Spec->to_array();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('productCode','commonName','biologicalSource','plantPart','productDescription','countryOfOrigin','colour','odor','taste','macroscopicCharacters','microscopicCharacters','description','foreignMatter','lossOnDrying','totalAsh','ashInsolubleInHCl','assayContent','leadPb','arsenicAs','mercuryHg','totalAerobicMicrobialCount','totalCombinedYeastMouldsCount','enterobacteriaCountIncludingPseudomonas','escherichiaColi','salmonella','staphylococcusAureus','mycotoxinsAflatoxinsOchratoxinA','pesticides','allergens');	   
    	$data = $Form->receive($postvars);      

        $new_spec = $Spec->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_spec) {
            $message = $HTML->success_message('Spec has been successfully updated. Return to %sSpecs%s', '<a href="'.$API->app_path().'/coa/spec/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Spec could not be updated.');
        }
        
    }