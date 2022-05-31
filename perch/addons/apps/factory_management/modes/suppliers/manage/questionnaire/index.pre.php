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
    $FactoryManagementQuestionnaires = new Supplier_Questionnaires($API);
    
    $SupplierData = $FactoryManagementSuppliers->supplier($_GET['id']);
    
    if($_GET['questionnaire']){
	    $questionnaire = $FactoryManagementQuestionnaires->getQuestionnaire($_GET['questionnaire']);
	}else{
	    $questionnaires = $FactoryManagementQuestionnaires->getQuestionnaires($SupplierData['ACCOUNT_REF']);
	}
