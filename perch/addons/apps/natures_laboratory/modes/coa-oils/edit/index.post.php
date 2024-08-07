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
		
		echo $Form->text_field("taste","Odour",$details['odour']);
		
		echo $Form->text_field("appearance","Appearance",$details['appearance']);
		
		echo $Form->text_field("specificGravity","Specific Gravity",$details['specificGravity']);
		echo $Form->text_field("refractiveIndex","Refractive Index",$details['refractiveIndex']);
		echo $Form->text_field("opticalRotation","Optical Rotation",$details['opticalRotation']);
		
		echo $Form->text_field("fattyAcid","Free Fatty Acid (% as Oliec)",$details['fattyAcid']);
		echo $Form->text_field("peroxideValue","Peroxide Value (meq O2/kg)",$details['peroxideValue']);
		echo $Form->text_field("iodineValue","Iodine Value (Calc.)",$details['iodineValue']);
		echo $Form->text_field("saponificationValue","Saponification Value (mg KOH/g)",$details['saponificationValue']);
		    
		echo $Form->submit_field('btnSubmit', 'Update COA', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();