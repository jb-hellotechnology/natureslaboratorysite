<?php
	$NaturesLaboratoryGoodsSuppliers = new Natures_Laboratory_Goods_Suppliers($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');

    if($Form->submitted()) {
    
        $supplierID = (int) $_GET['id'];  
		$Supplier = $NaturesLaboratoryGoodsSuppliers->find($supplierID, true);
		
		$Supplier->delete();
		$deleted = true;
		$message = $HTML->success_message('Supplier has been successfully deleted. Return to %sSuppliers%s', '<a href="'.$API->app_path().'/goods-in/suppliers/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this Supplier?', '', ''); 
    }