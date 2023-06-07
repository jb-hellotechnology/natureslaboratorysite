 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA',
    'button'  => [
            'text' => $Lang->get('Spec'),
            'link' => $API->app_nav().'/coa/spec/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Spec',
	    'link'  => $API->app_nav().'/coa/spec/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Countries',
	    'link'  => $API->app_nav().'/coa/countries/',
	]);
	
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		$stockList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($stock as $Stock){
			$stockList[] = array('label'=>$Stock->stockCode()." | ".$Stock->description(), 'value'=>$Stock->stockCode());
		}
		echo $Form->select_field("productCode","Product Code",$stockList,$details['productCode']);

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
		
		echo $Form->text_field("productDescription","Product Description",$details['productDescription']);
		
		$countryList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($country as $Country){
			$countryList[] = array('label'=>$Country->country(), 'value'=>$Country->country());
		}
		echo $Form->select_field("countryOfOrigin","Country Of Origin",$countryList,$details['countryOfOrigin']);

		echo $Form->text_field("colour","Colour",$details['colour']);
		echo $Form->text_field("odor","Odour",$details['odor']);
		echo $Form->text_field("taste","Taste",$details['taste']);
		echo $Form->text_field("macroscopicCharacters","Macroscopic Characters",$details['macroscopicCharacters']);
		echo $Form->textarea_field("macroscopicCharactersLong","Macroscopic Characters - Long Description",$details['macroscopicCharactersLong']);
		echo $Form->text_field("microscopicCharacters","Microscopic Characters",$details['microscopicCharacters']);
		echo $Form->textarea_field("microscopicCharactersLong","Microscopic Characters - Long Description",$details['microscopicCharactersLong']);
		echo $Form->textarea_field("description","Description",$details['description']);
		echo $Form->text_field("foreignMatter","Foreign Matter",$details['foreignMatter']);
		echo $Form->text_field("lossOnDrying","Loss On Drying",$details['lossOnDrying']);
		echo $Form->text_field("totalAsh","Total Ash",$details['totalAsh']);
		echo $Form->text_field("ashInsolubleInHCl","Ash Insoluble In HCL",$details['ashInsolubleInHCl']);
		echo $Form->text_field("assayContent","Assay Content",$details['assayContent']);
		echo $Form->text_field("leadPb","Lead",$details['leadPb']);
		echo $Form->text_field("arsenicAs","Arsenic",$details['arsenicAs']);
		echo $Form->text_field("mercuryHg","Mercury",$details['mercuryHg']);
		echo $Form->text_field("totalAerobicMicrobialCount","Total Aerobic Microbial Content",$details['totalAerobicMicrobialCount']);
		echo $Form->text_field("totalCombinedYeastMouldsCount","Total Microbial Yeast Moulds Count",$details['totalCombinedYeastMouldsCount']);
		echo $Form->text_field("enterobacteriaCountIncludingPseudomonas","Enterobacteria Count Including Pseudomonas",$details['enterobacteriaCountIncludingPseudomonas']);
		echo $Form->text_field("escherichiaColi","Escherichia Coli",$details['escherichiaColi']);
		echo $Form->text_field("salmonella","Salmonella",$details['salmonella']);
		echo $Form->text_field("staphylococcusAureus","Staphylococcus Aureus",$details['staphylococcusAureus']);
		echo $Form->text_field("mycotoxinsAflatoxinsOchratoxinA","Mycotxins Aflatoxins Ochratoxin A",$details['mycotoxinsAflatoxinsOchratoxinA']);
		echo $Form->text_field("pesticides","Pesticides",$details['pesticides']);
		echo $Form->text_field("allergens","Allergens",$details['allergens']);
		
		echo $Form->fields_from_template($Template, $details, $NaturesLaboratoryCOASpec->static_fields);
		
		echo $Form->submit_field('btnSubmit', 'Update Spec', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();