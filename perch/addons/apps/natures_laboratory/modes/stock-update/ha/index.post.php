 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Stock Management',
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Import CSV',
	    'link'  => $API->app_nav().'/stock-update/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Sync BeeVital',
	    'link'  => $API->app_nav().'/stock-update/bv/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => "Sync Sweet Cecily's",
	    'link'  => $API->app_nav().'/stock-update/sc/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Sync Herbal Apothecary',
	    'link'  => $API->app_nav().'/stock-update/ha/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if($message){
	    echo $message;
	    echo "<br /><p><strong>Updated Stock:</strong></p><p>" . $output . "</p>";
	}else{
    
	    echo $Form->form_start();
		echo $Form->submit_field('btnSubmit', "Sync Herbal Apothecary Website", $API->app_path());	
		echo $Form->form_end();
	
	}
    echo $HTML->main_panel_end();