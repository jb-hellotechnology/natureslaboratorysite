 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA Capsules',
    'button'  => [
            'text' => $Lang->get('COA'),
            'link' => $API->app_nav().'/coa-capsules/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa-capsules/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Spec',
	    'link'  => $API->app_nav().'/coa-capsules/spec/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Countries',
	    'link'  => $API->app_nav().'/coa-capsules/countries/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();

		$specList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($spec as $Spec){
			$specList[] = array('label'=>$Spec->productCode(), 'value'=>$Spec->productCode());
		}
		echo $Form->select_field("spec","Spec",$specList,$details['spec']);
		
		echo $Form->date_field("dateEntered","Date Entered",$details['dateEntered']);
		
		echo $Form->date_field("dateManufacture","Date of Manufacture",$details['dateManufacture']);
		
		echo $Form->date_field("bbe","BBE Date",$details['bbe']);
		
		echo $Form->text_field("ourBatch","Batch",$details['ourBatch']);

		$countryList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($country as $Country){
			$countryList[] = array('label'=>$Country->country(), 'value'=>$Country->country());
		}
		echo $Form->select_field("countryOfOrigin","Country Of Origin",$countryList,$details['countryOfOrigin']);
		
		echo $Form->text_field("colour","Colour",$details['colour']);
		
		echo $Form->text_field("taste","Taste",$details['taste']);
		
		echo $Form->text_field("odour","Odour",$details['odour']);
		
		echo $Form->fields_from_template($Template, $details, $Properties->static_fields);
		    
		echo $Form->submit_field('btnSubmit', 'Update COA', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();