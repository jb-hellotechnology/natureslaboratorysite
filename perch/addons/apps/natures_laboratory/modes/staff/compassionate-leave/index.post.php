 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    if($staffID){
    
	    echo $HTML->title_panel([
	    'heading' => $details['name'].' - Compassionate Leave',
	    'button'  => [
	            'text' => $Lang->get('Compassionate Leave'),
	            'link' => $API->app_nav().'/staff/compassionate-leave/add?id='.$_GET['id'],
	            'icon' => 'core/plus',
	        ],
	    ], $CurrentUser);
    
    }else{
	    
	    echo $HTML->title_panel([
	    'heading' => 'Holidays'
	    ], $CurrentUser);
	    
    }

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
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Volunteer Days',
	    'link'  => $API->app_nav().'/staff/volunteer-days/?id='.$staffID,
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    ?>

	<table class="d">
        <thead>
            <tr>
                <th>Start Time</th> 
                <th>End Time</th> 
                <th>Days Taken</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
	    <?php
		?>
        </tbody>
	</table>

<?php 

    echo $HTML->main_panel_end();