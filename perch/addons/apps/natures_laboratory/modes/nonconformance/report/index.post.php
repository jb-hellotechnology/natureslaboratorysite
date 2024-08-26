 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Non Conformance > Report',
    'button'  => [
            'text' => $Lang->get('Non Conformance'),
            'link' => $API->app_nav().'/nonconformance/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

		
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Non Conformance',
	    'link'  => $API->app_nav().'/nonconformance/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Overview',
	    'link'  => $API->app_nav().'/nonconformance/overview/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Report',
	    'link'  => $API->app_nav().'/nonconformance/report/',
	]);
	
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 

	echo $Form->form_start();
		
	echo $Form->date_field("startDate","Start",'');
	echo $Form->date_field("endDate","End",'');
	    
	echo $Form->submit_field('btnSubmit', 'Generate Report', $API->app_path());
	
	echo $Form->form_end();		

    echo $HTML->main_panel_end();