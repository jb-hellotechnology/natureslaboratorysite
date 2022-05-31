<?php
	
	if (!$CurrentUser->has_priv('factory_management.coa')) exit;
	
	$FactoryManagementCountries = new Factory_Management_COA_Countries($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $countryID = (int) $_GET['id'];  
    $Country = $FactoryManagementCountries->find($countryID, true);
    $details = $Country->to_array();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('country');	   
    	$data = $Form->receive($postvars);      

        $new_country = $Country->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_country) {
            $message = $HTML->success_message('Country has been successfully updated. Return to %sCountries%s', '<a href="'.$API->app_path().'/coa/countries/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Country could not be updated.');
        }
        
    }