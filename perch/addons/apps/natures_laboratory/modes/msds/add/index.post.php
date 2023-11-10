 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Add MSDS'
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
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		$templateList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($msdsTemplates as $Template){
			$templateList[] = array('label'=>$Template['productType'], 'value'=>$Template['natures_laboratory_msds_templateID']);
		}
		
		echo $Form->select_field("productType","MSDS Template",$templateList,'');
		
		$productList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($stock as $Stock){
			$productList[] = array('label'=>$Stock['STOCK_CODE'], 'value'=>$Stock['STOCK_CODE']);
		}
		
		echo $Form->select_field("productCode","Product Code",$productList,'');
		
		echo $Form->submit_field('btnSubmit', 'Create MSDS', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();