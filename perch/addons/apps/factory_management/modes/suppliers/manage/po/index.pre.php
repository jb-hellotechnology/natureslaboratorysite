<?php
    
    if (!$CurrentUser->has_priv('factory_management.suppliers')) exit;
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $Paging = $API->get('Paging');
    $Lang   = $API->get('Lang');
    
    $Paging->set_per_page(25);
    
    $FactoryManagementSuppliers = new Factory_Management_Suppliers($API);
    $FactoryManagementSuppliersPO = new Factory_Management_Suppliers_PO($API);
    $FactoryManagementSuppliersPOItems = new Factory_Management_Suppliers_PO_Items($API);
    $FactoryManagementSuppliersPOData = new Factory_Management_Suppliers_PO_Data($API);
    
    $SupplierData = $FactoryManagementSuppliers->supplier($_GET['id']);
	$pos = $FactoryManagementSuppliersPO->purchaseOrders($SupplierData['ACCOUNT_REF']);
	
	$pos = $FactoryManagementSuppliersPO->get_by('ACCOUNT_REF', $SupplierData['ACCOUNT_REF'], 'ORDER_DATE DESC', $Paging);
	
	if($_GET['po']){
	
		$po = $FactoryManagementSuppliersPO->purchaseOrder($_GET['po']);
		$posItems = $FactoryManagementSuppliersPOItems->poItems($_GET['po']);
	
		$Template->set('factory_management/po.html','fm');

		$poExtraData = $FactoryManagementSuppliersPOData->po($_GET['po']);
		$details = $poExtraData;
	
	    // HANDLE BLOCKS FROM TEMPLATE
	    $Form->handle_empty_block_generation($Template);
	
	    // SET REQUIRED FIELDS
	    $Form->set_required_fields_from_template($Template, $details);
	
	    if($Form->submitted()) {
	    
	        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
	        $postvars = array();	   
	    	$data = $Form->receive($postvars);      
	
	        // READ IN DYNAMIC FIELDS FROM TEMPLATE
	        $previous_values = false;
	        if (isset($details['poDynamicFields'])) {
	            $previous_values = PerchUtil::json_safe_decode($details['poDynamicFields'], true);
	        }
	
	        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
	        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $FactoryManagementSuppliersPOData, $poExtraData);
	        $data['poDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);
	        
	        $data['POID'] = $_GET['po'];
	
	        $updated_po = $FactoryManagementSuppliersPOData->updatePOData($data);
	
	        // SHOW RELEVANT MESSAGE
	        if ($updated_po) {
	            $message = $HTML->success_message('PO has been successfully updated'); 
	        }else{
	            $message = $HTML->failure_message('Sorry, PO could not be updated');
	        }
	        
	    }
	
	}