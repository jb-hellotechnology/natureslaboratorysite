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
		echo $Form->select_field("productCode","Product Code",$stockList,'');

		echo $Form->text_field("commonName","Common Name",'');
		echo $Form->text_field("biologicalSource","Biological Source",'');
		echo $Form->text_field("plantPart","Plant Part",'');
		echo $Form->text_field("productDescription","Product Description",'');
		
		$countryList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($country as $Country){
			$countryList[] = array('label'=>$Country->country(), 'value'=>$Country->country());
		}
		echo $Form->select_field("countryOfOrigin","Country Of Origin",$countryList,'');
		
		echo $Form->text_field("colour","Colour",'');
		echo $Form->text_field("odor","Odour",'');
		echo $Form->text_field("taste","Taste",'');
		echo $Form->text_field("macroscopicCharacters","Macroscopic Characters",'');
		echo $Form->textarea_field("macroscopicCharactersLong","Macroscopic Characters - Long Description",'');
		echo $Form->text_field("microscopicCharacters","Microscopic Characters",'');
		echo $Form->textarea_field("microscopicCharactersLong","Microscopic Characters - Long Description",'');
		echo $Form->textarea_field("description","Description",'');
		echo $Form->text_field("foreignMatter","Foreign Matter",'');
		echo $Form->text_field("lossOnDrying","Loss On Drying",'');
		echo $Form->text_field("totalAsh","Total Ash",'');
		echo $Form->text_field("ashInsolubleInHCl","Ash Insoluble In HCL",'');
		echo $Form->text_field("assayContent","Assay Content",'');
		echo $Form->text_field("leadPb","Lead",'≤ 5 ppm');
		echo $Form->text_field("arsenicAs","Arsenic",'≤ 2 ppm');
		echo $Form->text_field("mercuryHg","Mercury",'≤ 0.1 ppm');
		echo $Form->text_field("totalAerobicMicrobialCount","Total Aerobic Microbial Count",'≤ 100000 CFU/g');
		echo $Form->text_field("totalCombinedYeastMouldsCount","Total Microbial Yeast Moulds Count",'≤ 10000 CFU/g');
		echo $Form->text_field("enterobacteriaCountIncludingPseudomonas","Enterobacteria Count Including Pseudomonas",'≤ 1000 CFU/g');
		echo $Form->text_field("escherichiaColi","Escherichia Coli",'Absent in 1 g');
		echo $Form->text_field("salmonella","Salmonella",'Absent in 25 g');
		echo $Form->text_field("staphylococcusAureus","Staphylococcus Aureus",'Absent in 25 g');
		echo $Form->text_field("mycotoxinsAflatoxinsOchratoxinA","Mycotxins Aflatoxins Ochratoxin A",'Absent');
		echo $Form->text_field("pesticides","Pesticides",'Absent');
		echo $Form->text_field("allergens","Allergens",'No');
		
		echo $Form->fields_from_template($Template, $details, $Properties->static_fields);
		    
		echo $Form->submit_field('btnSubmit', 'Add Spec', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();