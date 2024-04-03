 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Tasks > Add',
    'button'  => [
            'text' => $Lang->get('Task'),
            'link' => $API->app_nav().'/tasks/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Tasks',
	    'link'  => $API->app_nav().'/tasks/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		echo $Form->date_field("date","Date",'');
		
		echo $Form->text_field("title","Title",'');
		
		echo $Form->date_field("dueBy","Due By",'');
		
		$createdBy[] = array('label'=>"Shankar", 'value'=>'Shankar');
		$createdBy[] = array('label'=>"James", 'value'=>'James');
		$createdBy[] = array('label'=>"Lucy", 'value'=>'Lucy');
		$createdBy[] = array('label'=>"Tom", 'value'=>'Tom');
		echo $Form->select_field('createdBy','Created By',$createdBy,'');
		
		$assignedTo[] = array('label'=>"Jack", 'value'=>'Jack');
		echo $Form->select_field('assignedTo','Assigned To',$assignedTo,'');
		
		echo $Form->fields_from_template($Template, $details, $Properties->static_fields);
		    
		echo $Form->submit_field('btnSubmit', 'Add Task', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();