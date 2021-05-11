 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    if($staffID){
    
	    echo $HTML->title_panel([
	    'heading' => $details['name'].' - Holidays',
	    'button'  => [
	            'text' => $Lang->get('Holidays'),
	            'link' => $API->app_nav().'/staff/holidays/add?id='.$_GET['id'],
	            'icon' => 'core/plus',
	        ],
	    ], $CurrentUser);
    
    }else{
	    
	    echo $HTML->title_panel([
	    'heading' => 'Holidays'
	    ], $CurrentUser);
	    
    }

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);
	
	if($staffID){
		
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
	    'active' => true,
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
		    'active' => false,
		    'title' => 'Volunteer Days',
		    'link'  => $API->app_nav().'/staff/volunteer-days/?id='.$staffID,
		]);
	
	}else{
		
		$Smartbar->add_item([
		    'active' => true,
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
		    'active' => false,
		    'title' => 'Early Finishes',
		    'link'  => $API->app_nav().'/staff/early-finishes/',
		]);
		
		$Smartbar->add_item([
		    'active' => false,
		    'title' => 'Skills Matrix',
		    'link'  => $API->app_nav().'/staff/skills-matrix/',
		]);
		
	}
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if($staffID){
    
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

	}else{

?>
	<h2>Holidays</h2>
	<p>Schedule here</p>
	
<?php		
		
	}

    echo $HTML->main_panel_end();