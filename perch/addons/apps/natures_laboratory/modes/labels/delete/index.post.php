 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Labels',
    'button'  => [
            'text' => $Lang->get('Labels'),
            'link' => $API->app_nav().'/labels/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}
	
	if(!$deleted){
		
		echo $Form->form_start();
		    
		echo $Form->submit_field('btnSubmit', 'Delete Labels', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();
    
	PerchUtil::output_debug();