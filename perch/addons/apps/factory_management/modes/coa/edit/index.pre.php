<?php
	
	if (!$CurrentUser->has_priv('Factory_Management.coa')) exit;
	
	$FactoryManagamentCOA = new Factory_Management_COAs($API);
	$FactoryManagamentGoodsIn = new Factory_Management_Goods_Ins($API);
	$FactoryManagamentGoodsStock = new Factory_Management_Goods_Stocks($API);
	$FactoryManagamentCOACountries = new Factory_Management_COA_Countries($API);
	
	$Paging = $API->get('Paging');
    $Lang   = $API->get('Lang');
    
    $Paging->set_per_page(25);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $batch = $FactoryManagamentGoodsIn->all();
    $stock = $FactoryManagamentGoodsStock->all();
    $country = $FactoryManagamentCOACountries->all();
    
    $Goods = array();
    $details = array();
    
    $coaID = (int) $_GET['id'];  
    $COA = $FactoryManagamentCOA->find($coaID, true);
    $details = $COA->to_array();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('dateEntered_day','dateEntered_month','dateEntered_year','productCode','ourBatch','countryOfOrigin','colour','odour','taste','foreignMatterAmount','lossOnDryingAmount','totalAshAmount','ashInSolubleAmount','assayContentAmount','leadAmount','arsenicAmount','mercuryAmount','totalAerobicAmount','totalCombinedYeastMouldAmount','enteroBacteriaAmount','escherichiaAmount','salmonellaAmount','staphylococcusAmount','mycotoxinsAmount','pesticidesAmount','allergensPresent','box1','box2','box3','box4','macroscopic','microscopic');	   
    	$data = $Form->receive($postvars);    
    	
    	$data['dateEntered'] = "$data[dateEntered_year]-$data[dateEntered_month]-$data[dateEntered_day]";
    	unset($data['dateEntered_year']);
    	unset($data['dateEntered_month']);
    	unset($data['dateEntered_day']);

        $new_coa = $COA->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_coa) {
            $message = $HTML->success_message('COA has been successfully updated. Return to %sCOAs%s', '<a href="'.$API->app_path().'/coa/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, COA could not be updated.');
        }
        
    }