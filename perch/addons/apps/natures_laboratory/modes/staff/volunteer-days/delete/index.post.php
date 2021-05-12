 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $details['name'].' - Volunteer Days',
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
	    'active' => false,
	    'title' => 'Compassionate Leave',
	    'link'  => $API->app_nav().'/staff/compassionate-leave/?id='.$staffID,
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Volunteer Days',
	    'link'  => $API->app_nav().'/staff/volunteer-days/?id='.$staffID,
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}
	
	if(!$deleted){
		
		echo $Form->form_start();
		    
		echo $Form->submit_field('btnSubmit', 'Delete Volunteer Day', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();