<?php
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
	if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
	
	$NaturesLaboratoryNonconformances = new Natures_Laboratory_Nonconformances($API); 
	
	$nonconformanceID = (int) $_GET['id'];
	$Nonconformance = $NaturesLaboratoryNonconformances->find($nonconformanceID, true); 
	$details = $Nonconformance->to_array();
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $Template = $API->get ('Template');

    $Template->set('natures_laboratory/nonconformance.html','nl');

    // HANDLE BLOCKS FROM TEMPLATE
    $Form->handle_empty_block_generation($Template);
    
    // SET REQUIRED FIELDS
    $Form->set_required_fields_from_template($Template, $details);
	
    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('date_day', 'date_month', 'date_year', 'type', 'title');	   
    	$data = $Form->receive($postvars); 
    	
    	$data['date'] = "$data[date_year]-$data[date_month]-$data[date_day]";
    	unset($data['date_year']);
    	unset($data['date_month']);
    	unset($data['date_day']);  
    	
    	// READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['natures_laboratory_nonconformanceDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($nonconformance['natures_laboratory_nonconformanceDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $NaturesLaboratoryNonconformances, $Nonconformance);
        $data['natures_laboratory_nonconformanceDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);
        
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM  
        $new_nonconformance = $Nonconformance->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_nonconformance) {
            $message = $HTML->success_message('Non conformance record has been successfully created. Return to %sNon Conformance%s', '<a href="'.$API->app_path().'/nonconformance/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, non conformance record could not be created.');
        }
        
    }