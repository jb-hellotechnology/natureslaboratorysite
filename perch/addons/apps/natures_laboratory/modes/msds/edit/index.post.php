 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Edit MSDS - SKU: '.$details['productCode']
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'MSDS',
	    'link'  => $API->app_nav().'/msds/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Templates',
	    'link'  => $API->app_nav().'/msds/templates/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'CAS',
	    'link'  => $API->app_nav().'/msds/cas/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		echo $Form->fields_from_template($Template, $details, $NaturesLaboratoryMSDS->static_fields);
		
		echo $Form->form_start();
		
		$templateList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($msdsTemplates as $Template){
			$templateList[] = array('label'=>$Template['productType'], 'value'=>$Template['natures_laboratory_msds_templateID']);
		}
		
		echo $Form->select_field("productType","MSDS Template",$templateList,$details['productType']);
		
		$productList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($stock as $Stock){
			$productList[] = array('label'=>$Stock['STOCK_CODE'], 'value'=>$Stock['STOCK_CODE']);
		}
		
		echo $Form->select_field("productCode","Product Code",$productList,$details['productCode']);
		
		echo $Form->submit_field('btnSubmit', 'Update Template', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();