 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA',
    'button'  => [
            'text' => $Lang->get('COA'),
            'link' => $API->app_nav().'/coa/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
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
		
		echo $Form->date_field("dateEntered","Date Entered",'');
		
		$stockList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($stock as $Stock){
			$stockList[] = array('label'=>$Stock->stockCode()." | ".$Stock->description(), 'value'=>$Stock->stockCode());
		}
		echo $Form->select_field("productCode_new","Product Code",$stockList,'');
		
		$batchList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($batch as $Batch){
			$batchList[] = array('label'=>$Batch->ourBatch().' | '.$Batch->productDescription(), 'value'=>$Batch->ourBatch());
		}
		echo $Form->select_field("ourBatch","Our Batch",$batchList,'');

		$countryList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($country as $Country){
			$countryList[] = array('label'=>$Country->country(), 'value'=>$Country->country());
		}
		echo $Form->select_field("countryOfOrigin","Country Of Origin",$countryList,'');
		
		echo $Form->text_field("colour","Colour",'');
		echo $Form->text_field("taste","Taste",'');
		echo $Form->text_field("foreignMatterAmount","Foreign Matter Amount",'');
		echo $Form->text_field("lossOnDryingAmount","Loss On Drying Amount",'');
		echo $Form->text_field("totalAshAmount","Total Ash Amount",'');
		echo $Form->text_field("ashInSolubleAmount","Ash Insoluble Amount",'');
		echo $Form->text_field("assayContentAmount","Assay Content Amount",'');
		echo $Form->text_field("leadAmount","Lead Amount",'');
		echo $Form->text_field("arsenicAmount","Arsenic Amount",'');
		echo $Form->text_field("mercuryAmount","Mercury Amount",'');
		echo $Form->text_field("totalAerobicAmount","Total Aerobic Amount",'');
		echo $Form->text_field("totalCombinedYeastMouldAmount","Total Combined Yeast Mould Amount",'');
		echo $Form->text_field("enteroBacteriaAmount","Entero Bacteria Amount",'');
		echo $Form->text_field("escherichiaAmount","Escherichia Amount",'');
		echo $Form->text_field("salmonellaAmount","Salmonella Amount",'');
		echo $Form->text_field("staphylococcusAmount","staphylococcusAmount",'');
		echo $Form->text_field("mycotoxinsAmount","Mycotoxins Amount",'');
		echo $Form->text_field("pesticidesAmount","Pesticides Amount",'');
		echo $Form->text_field("allergensPresent","Allergens Present",'');
		echo $Form->textarea_field("box1","Content",$details['box1']);
		echo $Form->textarea_field("box2","Additional Metals Information",$details['box2']);
		echo $Form->textarea_field("box3","Additional Microbial Information",$details['box3']);
		echo $Form->textarea_field("box4","Additional Pesticides Information",$details['box4']);
		echo $Form->text_field("macroscopic","Macroscopic",'');
		echo $Form->text_field("microscopic","Microscopic",'');
		
		echo $Form->hidden("new","new");
		    
		echo $Form->submit_field('btnSubmit', 'Add COA', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();