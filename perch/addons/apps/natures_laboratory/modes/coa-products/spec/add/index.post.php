 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA Products',
    'button'  => [
            'text' => $Lang->get('Spec'),
            'link' => $API->app_nav().'/coa-products/spec/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa-products/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Spec',
	    'link'  => $API->app_nav().'/coa-products/spec/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Countries',
	    'link'  => $API->app_nav().'/coa-products/countries/',
	]);
	
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		$optionsList[] = array('label'=>'Please Select', 'value'=>0);
		$optionsList[] = array('label'=>'Tincture', 'value'=>'Tincture');
		$optionsList[] = array('label'=>'Fluid Extract', 'value'=>'Fluid Extract');
		$optionsList[] = array('label'=>'Glycerite', 'value'=>'Glycerite');
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
		echo $Form->select_field("plantPart","Plant Part",$plantList,'');
		
		echo $Form->text_field("strengthVolume","Strength/Volume",'');
		
		$alcoholList[] = array('label'=>'Please Select', 'value'=>0);
		$alcoholList[] = array('label'=>'25%', 'value'=>'25%');
		$alcoholList[] = array('label'=>'30%', 'value'=>'30%');
		$alcoholList[] = array('label'=>'35%', 'value'=>'35%');
		$alcoholList[] = array('label'=>'45%', 'value'=>'45%');
		$alcoholList[] = array('label'=>'50%', 'value'=>'50%');
		$alcoholList[] = array('label'=>'60%', 'value'=>'60%');
		$alcoholList[] = array('label'=>'70%', 'value'=>'70%');
		$alcoholList[] = array('label'=>'90%', 'value'=>'90%');
		echo $Form->select_field("alcoholContent","Alcohol Content",$alcoholList,'');
		
		$countryList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($country as $Country){
			$countryList[] = array('label'=>$Country->country(), 'value'=>$Country->country());
		}
		echo $Form->select_field("countryOfOrigin","Country Of Origin",$countryList,'');
		
		echo $Form->text_field("colour","Colour",'');
		echo $Form->text_field("odour","Odour",'');
		echo $Form->text_field("taste","Taste",'');
		echo $Form->text_field("pH","pH",'');
		
		echo $Form->fields_from_template($Template, $details, $Properties->static_fields);
		    
		echo $Form->submit_field('btnSubmit', 'Add Spec', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();