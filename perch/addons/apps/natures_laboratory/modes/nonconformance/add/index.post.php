 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Non Conformance > Add',
    'button'  => [
            'text' => $Lang->get('Non Conformance'),
            'link' => $API->app_nav().'/nonconformance/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Non Conformance',
	    'link'  => $API->app_nav().'/nonconformance/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Report',
	    'link'  => $API->app_nav().'/nonconformance/report/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		echo $Form->date_field("date","Date",'');
		
		echo $Form->text_field("title","Title",'');
		
		$type[] = array('label'=>"Internal Process", 'value'=>'internal process');
		$type[] = array('label'=>"Quality Issue", 'value'=>'quality issue');
		$type[] = array('label'=>"Customer Complaint", 'value'=>'customer complaint');
		$type[] = array('label'=>"Delivery Problem", 'value'=>'delivery problem');
		echo $Form->select_field('type','Type',$type,'');
		
		echo $Form->fields_from_template($Template, $details, $Properties->static_fields);
		    
		echo $Form->submit_field('btnSubmit', 'Add Non Conformance', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();