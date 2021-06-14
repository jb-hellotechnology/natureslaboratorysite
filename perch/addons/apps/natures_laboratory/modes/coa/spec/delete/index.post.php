 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA',
    'button'  => [
            'text' => $Lang->get('Spec'),
            'link' => $API->app_nav().'/coa/spec/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Spec',
	    'link'  => $API->app_nav().'/coa/spec/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Countries',
	    'link'  => $API->app_nav().'/coa/countries/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}
	
	if(!$deleted){
		
		echo $Form->form_start();
		    
		echo $Form->submit_field('btnSubmit', 'Delete Spec', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();