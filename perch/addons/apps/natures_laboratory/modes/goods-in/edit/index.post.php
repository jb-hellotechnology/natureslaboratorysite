 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Goods In',
    'button'  => [
            'text' => $Lang->get('Print Labels'),
            'link' => $API->app_nav().'/goods-in/edit/?print=1&id='.$_GET['id'],
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Goods In',
	    'link'  => $API->app_nav().'/goods-in/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Stock',
	    'link'  => $API->app_nav().'/goods-in/stock/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Suppliers',
	    'link'  => $API->app_nav().'/goods-in/suppliers/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();

		echo $Form->hidden('staff',$_SESSION['userID']);
		$stockList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($stock as $Stock){
			$stockList[] = array('label'=>$Stock->stockCode()." | ".$Stock->description(), 'value'=>$Stock->stockCode()." | ".$Stock->description());
		}
		echo $Form->select_field("productCode","Product Code",$stockList,$details['productCode']." | ".$details['productDescription']);
		
		echo $Form->date_field("dateIn","Date In",$details['dateIn']);
		
		$supplierList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($supplier as $Supplier){
			$supplierList[] = array('label'=>$Supplier->name(), 'value'=>$Supplier->natures_laboratory_goods_suppliersID());
		}
		echo $Form->select_field("supplier","Supplier",$supplierList,$details['supplier']);
		
		echo $Form->text_field("qty","Quantity",$details['qty']);
		echo $Form->text_field("suppliersBatch","Supplier's Batch",$details['suppliersBatch']);
		echo $Form->text_field("ourBatch","Our Batch",$details['ourBatch']);
		
		echo $Form->date_field("bbe","BBE",$details['bbe']);
		if($details['bbe']=='1970-01-01'){
			echo $Form->checkbox_field("noBBE","No BBE",'skip','skip');
		}else{
			echo $Form->checkbox_field("noBBE","No BBE",'skip','');
		}
		
		$qa[] = array('label'=>"No", 'value'=>'FALSE');
		$qa[] = array('label'=>"Yes", 'value'=>'TRUE');
		$qa[] = array('label'=>"Not Required", 'value'=>'NOT REQUIRED');
		echo $Form->select_field('qa','QA Check',$qa,$details['qa']);
		    
		echo $Form->submit_field('btnSubmit', 'Update Goods In', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();