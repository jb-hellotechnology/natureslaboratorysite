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
    $FactoryManagementCountries = new Factory_Management_Countries($API);
    $FactoryManagementGoodsIn = new Factory_Management_Goods_Ins($API);
    
    $countries = $FactoryManagementCountries->all();
	
	$po = $FactoryManagementSuppliersPO->purchaseOrder($_GET['id']);
	$posItems = $FactoryManagementSuppliersPOItems->poItems($_GET['id']);
	
	$SupplierData = $FactoryManagementSuppliers->supplierByRef($po['ACCOUNT_REF']);
	
	$goodsInData = $FactoryManagementGoodsIn->getGoodsIn($_GET['id'],$_GET['item']-1);

	if($_GET['item']){
		
		$Template->set('factory_management/goodsin.html','fm');
		
		$itemData = $FactoryManagementSuppliersPOItems->poItem($_GET['id'],$_GET['item']-1);
		
		// HANDLE BLOCKS FROM TEMPLATE
	    $Form->handle_empty_block_generation($Template);
	
	    // SET REQUIRED FIELDS
	    $Form->set_required_fields_from_template($Template, $details);
		
		if($Form->submitted()) {
    
	        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
	      	$postvars = array('po', 'poItem', 'staff', 'dateIn', 'qty', 'unit', 'suppliersBatch', 'ourBatch', 'bbe_day', 'bbe_month', 'bbe_year', 'noBBE', 'countryOfOrigin');     
	    	$data = $Form->receive($postvars);  
	    	
	    	$data['bbe'] = "$data[bbe_year]-$data[bbe_month]-$data[bbe_day]";
	    	
	    	unset($data['bbe_year']);
	    	unset($data['bbe_month']);
	    	unset($data['bbe_day']);
	
	        // READ IN DYNAMIC FIELDS FROM TEMPLATE
	        $previous_values = false;
	        if (isset($details['goodsinDynamicFields'])) {
	            $previous_values = PerchUtil::json_safe_decode($details['goodsinDynamicFields'], true);
	        }
	
	        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
	        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $FactoryManagementSuppliersPOData, $poExtraData);
	        $data['goodsinDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);
	        
	        if($goodsInData){

		        if($data['staff']==$_SESSION['userID']){
			        echo '2';
			        $updated_poitem = $FactoryManagementGoodsIn->updateGoodsIn($data,$goodsInData->goodsinID());
		
			        // SHOW RELEVANT MESSAGE
			        if ($updated_poitem) {
			            $message = $HTML->success_message('PO item has been successfully updated'); 
			        }else{
			            $message = $HTML->failure_message('Sorry, PO item could not be updated');
			        }
			    }else{
				    $message = $HTML->failure_message('Changes not saved');
			    }
			    
	        }else{
		        $updated_poitem = $FactoryManagementGoodsIn->create($data);
	
		        // SHOW RELEVANT MESSAGE
		        if ($updated_poitem) {
		            $message = $HTML->success_message('PO item has been successfully created'); 
		        }else{
		            $message = $HTML->failure_message('Sorry, PO item could not be created');
		        }
	        }
	        
	        $goodsInData = $FactoryManagementGoodsIn->getGoodsIn($_GET['id'],$_GET['item']-1);
	      
	    }
		
	}else{
		
		$Template->set('factory_management/po.html','fm');
		
		$poExtraData = $FactoryManagementSuppliersPOData->po($_GET['id']);
		$details = $poExtraData;
	
	    // HANDLE BLOCKS FROM TEMPLATE
	    $Form->handle_empty_block_generation($Template);
	
	    // SET REQUIRED FIELDS
	    $Form->set_required_fields_from_template($Template, $details);
		
		if($Form->submitted()) {
    
	        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
	      	$postvars = array();   
	        foreach($posItems as $POITEM) {
		    	$postvars[] = 'QA_'.$POITEM['ITEM_NUMBER'];
		    	$postvars[] = 'C_'.$POITEM['ITEM_NUMBER'];
		    	$postvars[] = 'COA_'.$POITEM['ITEM_NUMBER'];
		    	$postvars[] = 'Staff_QA_'.$POITEM['ITEM_NUMBER'];
		    	$postvars[] = 'Staff_2_'.$POITEM['ITEM_NUMBER'];
		    }   
	    	$data = $Form->receive($postvars);  
	    	
	    	$i = 0;
	        while($i<=count($posItems)){
		        echo $i;
		        if(!$data['QA_'.$i]){
			        unset($data['Staff_QA_'.$i]);
		        }
		        if(!$data['C_'.$i]){
			        unset($data['Staff_2_'.$i]);
		        }
		        $i++;
	        }
	    	
	    	$QAC = json_encode($data);
	    	$data['QAC'] = $QAC;  
	
	        // READ IN DYNAMIC FIELDS FROM TEMPLATE
	        $previous_values = false;
	        if (isset($details['poDynamicFields'])) {
	            $previous_values = PerchUtil::json_safe_decode($details['poDynamicFields'], true);
	        }
	
	        // GET DYNAMIC FIELDS AND CREATE JSON ARRAY FOR DB
	        $dynamic_fields = $Form->receive_from_template_fields($Template, $previous_values, $FactoryManagementSuppliersPOData, $poExtraData);
	        $data['poDynamicFields'] = PerchUtil::json_safe_encode($dynamic_fields);
	        
	        $data['POID'] = $_GET['id'];
	
	        $updated_po = $FactoryManagementSuppliersPOData->updatePOData($data);
	
	        // SHOW RELEVANT MESSAGE
	        if ($updated_po) {
	            $message = $HTML->success_message('PO has been successfully updated'); 
	        }else{
	            $message = $HTML->failure_message('Sorry, PO could not be updated');
	        }
	        
	        $poExtraData = $FactoryManagementSuppliersPOData->po($_GET['id']);
			$details = $poExtraData;
	      
	    }
	}