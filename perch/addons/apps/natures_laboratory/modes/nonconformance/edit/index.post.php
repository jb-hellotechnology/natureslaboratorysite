 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Non Conformance > Edit',
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
	    'title' => 'Overview',
	    'link'  => $API->app_nav().'/nonconformance/overview/',
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
		
		echo "<h2>#";
		echo str_pad($details['natures_laboratory_nonconformanceID'], 4, '0', STR_PAD_LEFT);
		echo "</h2>";
		
		echo $Form->form_start();
		
		echo $Form->date_field("date","Date",$details['date']);
		
		echo $Form->text_field("title","Title",$details['title']);
		
		$type[] = array('label'=>"Customer", 'value'=>'Customer');
		$type[] = array('label'=>"Supplier", 'value'=>'Supplier');
		$type[] = array('label'=>"Internal", 'value'=>'Internal');
		$type[] = array('label'=>"Deviation", 'value'=>'Deviation');
		echo $Form->select_field('type','Type',$type,$details['type']);
		
		echo $Form->fields_from_template($Template, $details, $NaturesLaboratoryNonconformances->static_fields);
		    
		echo $Form->submit_field('btnSubmit', 'Update Non Conformance', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();