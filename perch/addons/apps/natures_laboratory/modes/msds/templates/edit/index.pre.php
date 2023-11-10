<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;

	$NaturesLaboratoryMSDSTemplate = new Natures_Laboratory_MSDS_Templates($API);   
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $Template->set('natures_laboratory/msds_template.html','nl');
    
    $msdsID = (int) $_GET['id'];  
    $msds = $NaturesLaboratoryMSDSTemplate->find($msdsID, true);
    $details = $msds->to_array();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('productType');	   
    	$data = $Form->receive($postvars);    
    	
    	// READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['natures_laboratory_msds_templateDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['natures_laboratory_msds_templateDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $NaturesLaboratoryMSDSTemplate, $msds);
        $data['natures_laboratory_msds_templateDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);  

        $new_msds = $msds->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_msds) {
            $message = $HTML->success_message('MSDS Template has been successfully updated. Return to %sSpecs%s', '<a href="'.$API->app_path().'/msds/templates/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, MSDS Template could not be updated.');
        }
        
        $msds = $NaturesLaboratoryMSDSTemplate->find($msdsID, true);
		$details = $msds->to_array();
        
    }