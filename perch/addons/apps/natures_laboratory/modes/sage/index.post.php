 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Sage Import',
    ], $CurrentUser);

    echo $HTML->main_panel_start();
    
    echo $Form->form_start();
    echo $Form->file_field('file','File','');
    echo $Form->submit_field('btnSubmit', 'Process', $API->app_path());	
	echo $Form->form_end();
    
    
    echo $HTML->main_panel_end();