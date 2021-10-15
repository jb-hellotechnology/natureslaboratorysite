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
	    'title' => 'Processes',
	    'link'  => $API->app_nav().'/production/',
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
		
		$vesselList[] = array('label'=>'Test 1', 'value'=>'test-1');
		$vesselList[] = array('label'=>'Test 2', 'value'=>'test-2');
		$vesselList[] = array('label'=>'Production 1', 'value'=>'production-2');
		echo $Form->select_field("vessel","Vessel",$vesselList,'');

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