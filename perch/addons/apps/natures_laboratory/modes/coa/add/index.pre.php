<?php
	$NaturesLaboratoryCOA = new Natures_Laboratory_COAs($API);
	$NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API);
	$NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API);
	$NaturesLaboratoryCOACountries = new Natures_Laboratory_COA_Countries($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $batch = $NaturesLaboratoryGoodsIn->all();
    $stock = $NaturesLaboratoryGoodsStock->all();
    $country = $NaturesLaboratoryCOACountries->all();
    
    $Goods = array();
    $details = array();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
       $postvars = array('dateEntered_day','dateEntered_month','dateEntered_year','productCode_new','ourBatch','countryOfOrigin','colour','odour','taste','foreignMatterAmount','lossOnDryingAmount','totalAshAmount','ashInSolubleAmount','assayContentAmount','leadAmount','arsenicAmount','mercuryAmount','totalAerobicAmount','totalCombinedYeastMouldAmount','enteroBacteriaAmount','escherichiaAmount','salmonellaAmount','staphylococcusAmount','mycotoxinsAmount','pesticidesAmount','allergensPresent','box1','box2','box3','box4','macroscopic','microscopic');	   
    	$data = $Form->receive($postvars);   
    	
    	$data['productCode'] = $data['productCode_new'];
    	unset($data['productCode_new']);
    	
    	$data['dateEntered'] = "$data[dateEntered_year]-$data[dateEntered_month]-$data[dateEntered_day]";
    	unset($data['dateEntered_year']);
    	unset($data['dateEntered_month']);
    	unset($data['dateEntered_day']);

		$new_coa = $NaturesLaboratoryCOA->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_coa) {
            $message = $HTML->success_message('COA has been successfully updated. Return to %sCOA%s', '<a href="'.$API->app_path().'/coa/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, COA could not be updated.');
        }
        
    }