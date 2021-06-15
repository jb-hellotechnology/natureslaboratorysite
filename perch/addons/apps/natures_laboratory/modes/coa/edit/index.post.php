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
		
		echo $Form->date_field("dateEntered","Date Entered",$details['dateEntered']);
		
		$stockList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($stock as $Stock){
			$stockList[] = array('label'=>$Stock->stockCode()." | ".$Stock->description(), 'value'=>$Stock->stockCode());
		}
		echo $Form->select_field("productCode","Product Code",$stockList,$details['productCode']);
		
		$batchList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($batch as $Batch){
			$batchList[] = array('label'=>$Batch->ourBatch().' | '.$Batch->productDescription(), 'value'=>$Batch->ourBatch());
		}
		echo $Form->select_field("ourBatch","Our Batch",$batchList,$details['ourBatch']);

		echo $Form->text_field("countryOfOrigin","Country Of Origin",$details['countryOfOrigin']);
		echo $Form->text_field("colour","Colour",$details['colour']);
		echo $Form->text_field("taste","Taste",$details['taste']);
		echo $Form->text_field("foreignMatterAmount","Foreign Matter Amount",$details['foreignMatterAmount']);
		echo $Form->text_field("lossOnDryingAmount","Loss On Drying Amount",$details['lossOnDryingAmount']);
		echo $Form->text_field("totalAshAmount","Total Ash Amount",$details['totalAshAmount']);
		echo $Form->text_field("ashInSolubleAmount","Ash Insoluble Amount",$details['ashInSolubleAmount']);
		echo $Form->text_field("assayContentAmount","Assay Content Amount",$details['assayContentAmount']);
		echo $Form->text_field("leadAmount","Lead Amount",$details['leadAmount']);
		echo $Form->text_field("arsenicAmount","Arsenic Amount",$details['arsenicAmount']);
		echo $Form->text_field("mercuryAmount","Mercury Amount",$details['mercuryAmount']);
		echo $Form->text_field("totalAerobicAmount","Total Aerobic Amount",$details['totalAerobicAmount']);
		echo $Form->text_field("totalCombinedYeastMouldAMount","Total Combined Yeast Mould Amount",$details['totalCombinedYeastMouldAmount']);
		echo $Form->text_field("enteroBacteriaAmount","Entero Bacteria Amount",$details['enteroBacteriaAmount']);
		echo $Form->text_field("escherichiaAmount","Escherichia Amount",$details['escherichiaAmount']);
		echo $Form->text_field("salmonellaAmount","Salmonella Amount",$details['salmonellaAmount']);
		echo $Form->text_field("staphylococcusAmount","staphylococcusAmount",$details['staphylococcusAmount']);
		echo $Form->text_field("mycotoxinsAmount","Mycotoxins Amount",$details['mycotoxinsAmount']);
		echo $Form->text_field("pesticidesAmount","Pesticides Amount",$details['pesticidesAmount']);
		echo $Form->text_field("allergensPresent","Allergens Present",$details['allergensPresent']);
		echo $Form->text_field("box1","Box 1",$details['box1']);
		echo $Form->text_field("box2","Box 2",$details['box2']);
		echo $Form->text_field("box3","Box 3",$details['box3']);
		echo $Form->text_field("box4","Box 4",$details['box4']);
		echo $Form->text_field("macroscopic","Macroscopic",$details['macroscopic']);
		echo $Form->text_field("microscopic","Microscopic",$details['microscopic']);
		    
		echo $Form->submit_field('btnSubmit', 'Update COA', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();