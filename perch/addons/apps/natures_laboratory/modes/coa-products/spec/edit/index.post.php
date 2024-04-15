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
		echo $Form->select_field("productType","Product Type",$optionsList,$details['productType']);

		echo $Form->text_field("productCode","Product Code",$details['productCode']);
		echo $Form->text_field("commonName","Common Name",$details['commonName']);
		echo $Form->text_field("biologicalSource","Biological Source",$details['biologicalSource']);
		
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
		echo $Form->select_field("plantPart","Plant Part",$plantList,$details['plantPart']);
		
		echo $Form->text_field("strengthVolume","Strength/Volume",$details['strengthVolume']);
		echo $Form->text_field("alcoholContent","Alcohol Content",$details['alcoholContent']);
		
		$countryList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($country as $Country){
			$countryList[] = array('label'=>$Country->country(), 'value'=>$Country->country());
		}
		echo $Form->select_field("countryOfOrigin","Country Of Origin",$countryList,$details['countryOfOrigin']);
		
		echo $Form->text_field("colour","Colour",$details['colour']);
		echo $Form->text_field("odour","Odour",$details['odour']);
		echo $Form->text_field("taste","Taste",$details['taste']);
		echo $Form->text_field("pH","pH",$details['pH']);
		echo $Form->text_field("specificGravity","Specific Gravity",$details['specificGravity']);
		
		echo $Form->fields_from_template($Template, $details, $NaturesLaboratoryCOASpec->static_fields);
				
		echo $Form->submit_field('btnSubmit', 'Update Spec', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();