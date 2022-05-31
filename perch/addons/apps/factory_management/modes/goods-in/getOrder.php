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
    $FactoryManagementGoodsIn = new Factory_Management_Goods_Ins($API);
	
	$po = $FactoryManagementSuppliersPOData->po($_POST['ORDER_NUMBER']);
	$posItems = $FactoryManagementSuppliersPOItems->poItems($_POST['ORDER_NUMBER']);
	
	$array = array();

	$items = '';

	foreach($posItems as $item){
		$items .= $item['DESCRIPTION']."<br />";
	}
	
	$array['items'] = $items;
	
	$qty = '';

	foreach($posItems as $item){
		$GoodsIn = $FactoryManagementGoodsIn->getGoodsIn($_POST['ORDER_NUMBER'],$item['ITEM_NUMBER']);
		if($GoodsIn){
			$qty .= $GoodsIn->qty()."<br />";
		}else{
			$qty .= "<br />";
		}
	}
	
	$array['qty'] = $qty;
	
	$suppliers = '';

	foreach($posItems as $item){
		$GoodsIn = $FactoryManagementGoodsIn->getGoodsIn($_POST['ORDER_NUMBER'],$item['ITEM_NUMBER']);
		if($GoodsIn){
			$suppliers .= $GoodsIn->suppliersBatch()."<br />";
		}else{
			$suppliers .= "<br />";
		}
	}
	
	$array['suppliers'] = $suppliers;
	
	$ourbatch = '';

	foreach($posItems as $item){
		$GoodsIn = $FactoryManagementGoodsIn->getGoodsIn($_POST['ORDER_NUMBER'],$item['ITEM_NUMBER']);
		if($GoodsIn){
			$ourbatch .= $GoodsIn->ourBatch()."<br />";
		}else{
			$ourbatch .= "<br />";
		}
	}
	
	$array['ourbatch'] = $ourbatch;

	$bbe = '';

	foreach($posItems as $item){
		$GoodsIn = $FactoryManagementGoodsIn->getGoodsIn($_POST['ORDER_NUMBER'],$item['ITEM_NUMBER']);
		if($GoodsIn){
			if($GoodsIn->noBBE()){
				$bbe .= "Not Required<br />";
			}else{
				$bbe .= $GoodsIn->bbe()."<br />";
			}
		}else{
			$bbe .= "<br />";
		}
	}
	
	$array['bbe'] = $bbe;
	
	$country = '';

	foreach($posItems as $item){
		$GoodsIn = $FactoryManagementGoodsIn->getGoodsIn($_POST['ORDER_NUMBER'],$item['ITEM_NUMBER']);
		if($GoodsIn){
			$country .= $GoodsIn->countryOfOrigin()."<br />";
		}else{
			$country .= "<br />";
		}
	}
	
	$array['country'] = $country;

	$qa = '';
	$i = 0;
	$poData = json_decode($po['QAC'],true);
	
	foreach($posItems as $item){
		if($poData['QA_'.$i]==1){
			$qa .= 'Passed QA<br />';	
		}else{
			$qa .= "<br />";
		}
		$i++;
	}
	
	$array['qa'] = $qa;

	$coa = '';
	$i = 0;
	
	foreach($posItems as $item){
		if($poData['COA_'.$i]==1){
			$coa .= 'Not Required<br />';	
		}else{
			$coa .= "Pending<br />";
		}
		$i++;
	}
	
	$array['coa'] = $coa;

	$json = json_encode($array);
	echo $json;