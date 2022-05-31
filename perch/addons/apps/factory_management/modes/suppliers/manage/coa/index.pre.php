<?php
    
    if (!$CurrentUser->has_priv('factory_management.suppliers')) exit;
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $FactoryManagementSuppliers = new Factory_Management_Suppliers($API);
    
    $SupplierData = $FactoryManagementSuppliers->supplier($_GET['id']);
	