 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Orders',
    ], $CurrentUser);

	$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Pending',
	    'link'  => $API->app_nav().'/orders/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Dispatched',
	    'link'  => $API->app_nav().'/orders/dispatched/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}
	
	if(!$deleted){
		
		echo $Form->form_start();
		    
		echo $Form->submit_field('btnSubmit', 'Delete Order', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();
    
	PerchUtil::output_debug();