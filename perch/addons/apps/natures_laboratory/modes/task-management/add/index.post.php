 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Add a Task',
    ], $CurrentUser);

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		echo $Form->fields_from_template($Template, $details, $Properties->static_fields);
		
		echo $Form->submit_field('btnSubmit', 'Add Task', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();