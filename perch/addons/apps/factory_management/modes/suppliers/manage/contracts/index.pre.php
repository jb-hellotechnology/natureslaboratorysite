<?php
    
    if (!$CurrentUser->has_priv('factory_management.suppliers')) exit;
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $FactoryManagementSuppliers = new Factory_Management_Suppliers($API);
    $FactoryManagementSuppliersPO = new Factory_Management_Suppliers_PO($API);
    $FactoryManagementSuppliersPOItems = new Factory_Management_Suppliers_PO_Items($API);
    $FactoryManagementSuppliersPOData = new Factory_Management_Suppliers_PO_Data($API);
    $FactoryManagementContracts = new Factory_Management_Suppliers_Contracts($API);
    
    $SupplierData = $FactoryManagementSuppliers->supplier($_GET['id']);
    
    $contracts = $FactoryManagementContracts->get_by('ACCOUNT_REF', $SupplierData['ACCOUNT_REF'], 'contractID DESC', $Paging);
    
    $Contract = array();
    
    $Template->set('factory_management/contract.html','fm');

    // HANDLE BLOCKS FROM TEMPLATE
    $Form->handle_empty_block_generation($Template);

    // SET REQUIRED FIELDS
    $Form->set_required_fields_from_template($Template, $details);

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('product','quantity','price','startDate_day','startDate_month','startDate_year','endDate_day','endDate_month','endDate_year','ACCOUNT_REF');	   
    	$data = $Form->receive($postvars);      
    	
    	$data['startDate'] = "$data[startDate_year]-$data[startDate_month]-$data[startDate_day]";
    	unset($data['startDate_year']);
    	unset($data['startDate_month']);
    	unset($data['startDate_day']);
    	
    	$data['endDate'] = "$data[endDate_year]-$data[endDate_month]-$data[endDate_day]";
    	unset($data['endDate_year']);
    	unset($data['endDate_month']);
    	unset($data['endDate_day']);

        // READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['contractDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['contractDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $FactoryManagementSuppliersContracts, $Contract);
        $data['contractDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);

		if($_GET['add']){

	        $new_contract = $FactoryManagementContracts->create($data);
	
	        // SHOW RELEVANT MESSAGE
	        if ($new_contract) {
	            $message = $HTML->success_message('Contract has been successfully created'); 
	        }else{
	            $message = $HTML->failure_message('Sorry, contract could not be created');
	        }
        
        }elseif($_GET['edit']){
	        
	        $data['contractID'] = $_GET['contract'];
	        
	        $new_contract = $FactoryManagementContracts->update($data);
	
	        // SHOW RELEVANT MESSAGE
	        if ($new_contract) {
	            $message = $HTML->success_message('Contract has been successfully updated'); 
	        }else{
	            $message = $HTML->failure_message('Sorry, contract could not be updated');
	        }
	        
        }elseif($_GET['delete']){
	        
	        $new_contract = $FactoryManagementContracts->deleteContract($_GET['contract']);
	
	        // SHOW RELEVANT MESSAGE
	        if ($new_contract) {
	            $message = $HTML->success_message('Contract has been successfully deleted'); 
	        }else{
	            $message = $HTML->failure_message('Sorry, contract could not be deleted');
	        }
	        
        }
    }
    
    if($_GET['contract']){
	    $contract = $FactoryManagementContracts->find($_GET['contract']);
    }
    