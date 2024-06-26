 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA Oils',
    'button'  => [
            'text' => $Lang->get('COA'),
            'link' => $API->app_nav().'/coa-oils/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa-oils/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Spec',
	    'link'  => $API->app_nav().'/coa-oils/spec/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Countries',
	    'link'  => $API->app_nav().'/coa-oils/countries/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		$specList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($spec as $Spec){
			$specList[] = array('label'=>$Spec->productCode().' | '.$Spec->commonName(), 'value'=>$Spec->productCode());
		}
		echo $Form->select_field("spec","Spec",$specList,'');
		
		echo $Form->date_field("dateEntered","Date Entered",'');
		
		echo $Form->date_field("dateManufacture","Date of Manufacture",'');
		
		echo $Form->date_field("bbe","BBE Date",'');
		
		echo $Form->text_field("ourBatch","Batch",'');

		$countryList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($country as $Country){
			$countryList[] = array('label'=>$Country->country(), 'value'=>$Country->country());
		}
		echo $Form->select_field("countryOfOrigin","Country Of Origin",$countryList,'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_countryOfOrigin'></span></small></div>";
		
		echo $Form->text_field("colour","Colour",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_colour'></span></small></div>";
		
		echo $Form->text_field("odour","Odour",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_odour'></span></small></div>";
		
		echo $Form->text_field("appearance","Appearance",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_appearance'></span></small></div>";
		
		echo $Form->text_field("specificGravity","Specific Gravity",'');
		echo $Form->text_field("refractiveIndex","Refractive Index",'');
		echo $Form->text_field("opticalRotation","Optical Rotation",'');
		
		echo $Form->text_field("fattyAcid","Free Fatty Acid (% as Oliec)",'');
		echo $Form->text_field("peroxideValue","Peroxide Value (meq O2/kg)",'');
		echo $Form->text_field("iodineValue","Iodine Value (Calc.)",'');
		echo $Form->text_field("saponificationValue","Saponification Value (mg KOH/g)",'');
		    
		echo $Form->submit_field('btnSubmit', 'Add COA', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();