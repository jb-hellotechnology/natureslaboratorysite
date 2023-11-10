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
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		echo $Form->fields_from_template($Template, $details, $NaturesLaboratoryMSDS->static_fields);
		
		echo $Form->submit_field('btnSubmit', 'Update Template', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();