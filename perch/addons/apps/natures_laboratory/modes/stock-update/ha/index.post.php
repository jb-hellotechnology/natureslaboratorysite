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
	    echo "<p><strong>Select Categories to Update:</strong></p>";
		echo $Form->checkbox_field("chemicals","Chemicals, Creams, Essential Oils, Fixed Oils, Packaging, Waxes/Gums, Sweet Cecily's",'chemicals','');
		echo $Form->checkbox_field("tinctures","Tinctures",'tinctures','');
		echo $Form->checkbox_field("fluids","Fluid Extracts",'fluids','');
		echo $Form->checkbox_field("organics","Organics",'organics','');
		echo $Form->checkbox_field("cuts","Cuts, Wholes, Powders & Powder Blends",'cuts','');
		echo $Form->checkbox_field("capsules","Capsules",'capsules','');
		echo $Form->checkbox_field("beevital","BeeVital",'beevital','');
		echo $Form->submit_field('btnSubmit', "Sync Herbal Apothecary Website", $API->app_path());	
		echo $Form->form_end();
	
	}
    echo $HTML->main_panel_end();