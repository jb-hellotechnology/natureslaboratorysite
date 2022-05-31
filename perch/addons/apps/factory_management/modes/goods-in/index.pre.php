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
	
	$pos = $FactoryManagementSuppliersPO->get_by('RECORD_DELETED', '0', 'ORDER_DATE DESC', $Paging);