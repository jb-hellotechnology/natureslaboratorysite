 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $details['name'].' - Compassionate Leave',
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Profile',
	    'link'  => $API->app_nav().'/staff/edit/?id='.$staffID,
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Hours',
	    'link'  => $API->app_nav().'/staff/hours/?id='.$staffID,
	]);
	
	$Smartbar->add_item([
    'active' => false,
    'title' => 'Holidays',
    'link'  => $API->app_nav().'/staff/holidays/?id='.$staffID,
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Sick Days',
	    'link'  => $API->app_nav().'/staff/sick-days/?id='.$staffID,
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Compassionate Leave',
	    'link'  => $API->app_nav().'/staff/compassionate-leave/?id='.$staffID,
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}
	
	if(!$deleted){
		
		echo $Form->form_start();
		    
		echo $Form->submit_field('btnSubmit', 'Delete Compassionate Leave', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();