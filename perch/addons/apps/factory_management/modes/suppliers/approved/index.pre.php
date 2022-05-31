<?php
    
    if (!$CurrentUser->has_priv('factory_management.suppliers')) exit;
    
    $HTML = $API->get('HTML');
    $Paging = $API->get('Paging');
    $Lang   = $API->get('Lang');
    
    $FactoryManagementSuppliers = new Factory_Management_Suppliers($API); 
    $FactoryManagementSuppliersData = new Factory_Management_Suppliers_Data($API); 
    
    $Paging->set_per_page(25);
    
    $suppliers = $FactoryManagementSuppliers->suppliers($_GET['q'],true);