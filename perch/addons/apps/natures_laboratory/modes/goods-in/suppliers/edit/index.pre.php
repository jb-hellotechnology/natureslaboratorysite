<?php

	$NaturesLaboratoryGoodsSuppliers = new Natures_Laboratory_Goods_Suppliers($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');
    
    $supplierID = (int) $_GET['id'];  
    $Supplier = $NaturesLaboratoryGoodsSuppliers->find($supplierID, true);
    $details = $Supplier->to_array();

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('name');	   
    	$data = $Form->receive($postvars);      

        $new_supplier = $Supplier->update($data);

        // SHOW RELEVANT MESSAGE
        if ($new_supplier) {
            $message = $HTML->success_message('Supplier has been successfully updated. Return to %sSuppliers%s', '<a href="'.$API->app_path().'/goods-in/suppliers/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Supplier could not be updated.');
        }
        
    }