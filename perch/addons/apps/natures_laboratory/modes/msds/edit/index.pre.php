<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;

	$NaturesLaboratoryMSDS = new Natures_Laboratory_MSDSs($API); 
	$NaturesLaboratoryMSDSTemplate = new Natures_Laboratory_MSDS_Templates($API); 
	$NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $msdsID = (int) $_GET['id'];  
    $msds = $NaturesLaboratoryMSDS->find($msdsID, true);
    $details = $msds->to_array();
    
    if($details['productType']=='3'){
		$Template->set('natures_laboratory/msds_tincture.html','nl');
	}
	if($details['productType']=='4'){
		$Template->set('natures_laboratory/msds_fluidextract.html','nl');
	}
	if($details['productType']=='5'){
		$Template->set('natures_laboratory/msds_capsule.html','nl');
	}
	if($details['productType']=='6'){
		$Template->set('natures_laboratory/msds_powder.html','nl');
	}
	
	$msdsTemplates = $NaturesLaboratoryMSDSTemplate->allTemplates();
    $stock = $NaturesLaboratoryGoodsStock->getStock();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('');	   
    	$data = $Form->receive($postvars);    
    	
    	// READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['natures_laboratory_msdsDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['natures_laboratory_msdsDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $NaturesLaboratoryMSDSTemplate, $msds);
        $data['natures_laboratory_msdsDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);  

        $new_msds = $msds->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_msds) {
            $message = $HTML->success_message('MSDS has been successfully updated. Return to %sMSDS%s', '<a href="'.$API->app_path().'/msds/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, MSDS could not be updated.');
        }
        
        $msds = $NaturesLaboratoryMSDS->find($msdsID, true);
		$details = $msds->to_array();
        
    }