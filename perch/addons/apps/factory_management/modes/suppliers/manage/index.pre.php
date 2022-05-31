<?php
    
    if (!$CurrentUser->has_priv('factory_management.suppliers')) exit;
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $Template->set('factory_management/supplier.html','fm');
    
    $FactoryManagementSuppliers = new Factory_Management_Suppliers($API); 
    $FactoryManagementSuppliersData = new Factory_Management_Suppliers_Data($API); 
    
	$SupplierData = $FactoryManagementSuppliers->supplier($_GET['id']);
	$SupplierExtraData = $FactoryManagementSuppliersData->supplier($SupplierData['ACCOUNT_REF']);
	$details = $SupplierExtraData;

    // HANDLE BLOCKS FROM TEMPLATE
    $Form->handle_empty_block_generation($Template);

    // SET REQUIRED FIELDS
    $Form->set_required_fields_from_template($Template, $details);

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('ACCOUNT_REF');	   
    	$data = $Form->receive($postvars);      

        // READ IN DYNAMIC FIELDS FROM TEMPLATE
        $previous_values = false;
        if (isset($details['supplierDynamicFields'])) {
            $previous_values = PerchUtil::json_safe_decode($details['supplierDynamicFields'], true);
        }

        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $FactoryManagementSuppliersData, $SupplierExtraData);
        $data['supplierDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);

        $updated_supplier = $FactoryManagementSuppliersData->updateSupplierData($data);

        // SHOW RELEVANT MESSAGE
        if ($updated_supplier) {
            $message = $HTML->success_message('Supplier has been successfully updated'); 
        }else{
            $message = $HTML->failure_message('Sorry, supplier could not be updated');
        }
        
    }