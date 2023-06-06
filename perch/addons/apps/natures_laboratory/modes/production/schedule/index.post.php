 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Production',
    'button'  => [
            'text' => $Lang->get('Production'),
            'link' => $API->app_nav().'/production/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Shortfall',
	    'link'  => $API->app_nav().'/production/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Scheduled',
	    'link'  => $API->app_nav().'/production/scheduled/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'In Production',
	    'link'  => $API->app_nav().'/production/in-production/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Completed',
	    'link'  => $API->app_nav().'/production/completed/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		$productCodeList[] = array('label'=>'Item', 'value'=>'Value');
		
		echo $Form->select_field("productCode","Product Code",$productCodeList,'');
		
		echo $Form->text_field("description","Description",'');
		
		echo $Form->text_field("specification","Specification",'');
		
		echo $Form->text_field("packagingRequirements","Packaging Requirements",'');
		
		echo $Form->text_field("labellingRequirements","Labelling Requirements",'');
		
		echo $Form->text_field("quantityRequired","Quantity Required",'');
		
		echo $Form->text_field("quantityRequired","Quantity Required",'');
		
		echo $Form->fields_from_template($Template, '', $NaturesLaboratoryProduction->static_fields);
		
		echo $Form->date_field("dateIn","Date Went Into Production",'');
		
		echo $Form->date_field("dateDueToPress","Date Due To Press",'');
		
		echo $Form->date_field("datePressed","Date Pressed",'');

		echo $Form->text_field("description","Description",'');
		echo $Form->text_field("batch","Batch Number",'');
		echo $Form->text_field("water","Water Volume",'');
		echo $Form->text_field("alcohol","Alcohol Volume",'');
		echo $Form->text_field("herb","Herb Weight",'');
		
		$productionList[] = array('label'=>'Test', 'value'=>'test');
		$productionList[] = array('label'=>'Fluid Extract', 'value'=>'fluid-extract');
		$productionList[] = array('label'=>'Tincture 1:2', 'value'=>'tincture-1-2');
		$productionList[] = array('label'=>'Tincture 1:3', 'value'=>'tincture-1-3');
		echo $Form->select_field("programme","Programme",$productionList,'');
		
		echo $Form->text_field("startTime","Start Time",date('Y-m-d H:i:s'));
		echo $Form->text_field("flow","Flow",'0s');
		
		$statusList[] = array('label'=>'On', 'value'=>'on');
		$statusList[] = array('label'=>'Paused', 'value'=>'paused');
		$statusList[] = array('label'=>'Completed', 'value'=>'completed');
		echo $Form->select_field("status","Status",$statusList,'');
		    
		echo $Form->submit_field('btnSubmit', 'Create Process', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();