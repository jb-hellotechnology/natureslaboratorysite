 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA Oils',
    'button'  => [
            'text' => $Lang->get('Spec'),
            'link' => $API->app_nav().'/coa-oils/spec/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa-oils/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
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
		
		$optionsList[] = array('label'=>'Please Select', 'value'=>0);
		$optionsList[] = array('label'=>'Essential Oil', 'value'=>'Essential Oil');
		$optionsList[] = array('label'=>'Fixed Oil', 'value'=>'Fixed Oil');
		echo $Form->select_field("productType","Product Type",$optionsList,'');

		echo $Form->text_field("productCode","Product Code",'');
		echo $Form->text_field("commonName","Common Name",'');
		echo $Form->text_field("biologicalSource","Biological Source",'');
		
		$plantList[] = array('label'=>'Please Select', 'value'=>0);
		$plantList[] = array('label'=>'Leaf', 'value'=>'Leaf');
		$plantList[] = array('label'=>'Root', 'value'=>'Root');
		$plantList[] = array('label'=>'Whole Herb', 'value'=>'Whole Herb');
		$plantList[] = array('label'=>'Flower', 'value'=>'Flower');
		$plantList[] = array('label'=>'Fruit', 'value'=>'Fruit');
		$plantList[] = array('label'=>'Bark', 'value'=>'Bark');
		$plantList[] = array('label'=>'Seed', 'value'=>'Seed');
		$plantList[] = array('label'=>'Aerial Herb', 'value'=>'Aerial Herb');
		$plantList[] = array('label'=>'Thallus', 'value'=>'Thallus');
		$plantList[] = array('label'=>'Resin', 'value'=>'Resin');
		$plantList[] = array('label'=>'Berries', 'value'=>'Berries');
		$plantList[] = array('label'=>'Tops & Berries', 'value'=>'Tops & Berries');
		$plantList[] = array('label'=>'Moss', 'value'=>'Moss');
		$plantList[] = array('label'=>'Bamboo Shoot', 'value'=>'Bamboo Shoot');
		$plantList[] = array('label'=>'Fungi', 'value'=>'Fungi');
		$plantList[] = array('label'=>'Shells of the Fruit', 'value'=>'Shells of the Fruit');
		echo $Form->select_field("plantPart","Plant Part",$plantList,'');
		
		echo $Form->text_field("cas","CAS Number",'');
		echo $Form->text_field("einecs","EINECS Number",'');
		echo $Form->text_field("manufacturingMethod","Manufacturing Method",'');
		
		$countryList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($country as $Country){
			$countryList[] = array('label'=>$Country->country(), 'value'=>$Country->country());
		}
		echo $Form->select_field("countryOfOrigin","Country Of Origin",$countryList,'');
		
		echo $Form->text_field("colour","Colour",'');
		echo $Form->text_field("odour","Odour",'');
		echo $Form->text_field("appearance", "Appearance",'');

		echo $Form->text_field("specificGravity","Specific Gravity",'');
		echo $Form->text_field("refractiveIndex","Refractive Index",'');
		echo $Form->text_field("opticalRotation","Optical Rotation",'');
		
		echo $Form->text_field("fattyAcid","Free Fatty Acid (% as Oliec)",'');
		echo $Form->text_field("peroxideValue","Peroxide Value (meq O2/kg)",'');
		echo $Form->text_field("iodineValue","Iodine Value (Calc.)",'');
		echo $Form->text_field("saponificationValue","Saponification Value (mg KOH/g)",'');
		
		echo $Form->fields_from_template($Template, $details, $Properties->static_fields);
		    
		echo $Form->submit_field('btnSubmit', 'Add Spec', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();