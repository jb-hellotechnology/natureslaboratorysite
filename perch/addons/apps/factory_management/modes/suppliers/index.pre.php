<?php
    
    if (!$CurrentUser->has_priv('factory_management.suppliers')) exit;
    
    $HTML = $API->get('HTML');
    $Paging = $API->get('Paging');
    $Lang   = $API->get('Lang');
    
    $FactoryManagementSuppliers = new Factory_Management_Suppliers($API); 
    $FactoryManagementSuppliersData = new Factory_Management_Suppliers_Data($API); 
    
    $Paging->set_per_page(25);
    
    if(isset($_GET['q'])){
		$suppliers = $FactoryManagementSuppliers->suppliers($_GET['q'],false); 
    }else{
		$suppliers = $FactoryManagementSuppliers->get_by('RECORD_DELETED', '0', 'NAME ASC', $Paging);
	}