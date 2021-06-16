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
		echo $Form->text_field("plantPart","Plant Part",$details['plantPart']);
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
		echo $Form->text_field("microscopicCharacters","Microscopic Characters",$details['microscopicCharacters']);
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
		    
		echo $Form->submit_field('btnSubmit', 'Update Spec', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();