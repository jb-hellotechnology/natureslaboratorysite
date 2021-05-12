 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Bank Holidays',
    'button'  => [
            'text' => $Lang->get('Bank Holiday'),
            'link' => $API->app_nav().'/staff/bank-holidays/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

		
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Staff',
	    'link'  => $API->app_nav().'/staff/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Hours',
	    'link'  => $API->app_nav().'/staff/hours/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Holidays',
	    'link'  => $API->app_nav().'/staff/holidays/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Bank Holidays',
	    'link'  => $API->app_nav().'/staff/bank-holidays/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Early Finishes',
	    'link'  => $API->app_nav().'/staff/early-finishes/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Skills Matrix',
	    'link'  => $API->app_nav().'/staff/skills-matrix/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		echo $Form->text_field("date","Date (format YYYY-MM-DD)",'');
		
		echo $Form->text_field("targetHit","Target Hit (15000 or 20000)",'');
		    
		echo $Form->submit_field('btnSubmit', 'Add Early Finish', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();