 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA Products',
    'button'  => [
            'text' => $Lang->get('COA'),
            'link' => $API->app_nav().'/coa-products/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa-products/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
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
		
		echo $Form->date_field("dateEntered","Date Entered",'');
		
		$stockList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($stock as $Stock){
			$stockList[] = array('label'=>$Stock->stockCode()." | ".$Stock->description(), 'value'=>$Stock->stockCode());
		}
		echo $Form->select_field("productCodeProduct_new","Product Code",$stockList,'');
		
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
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_countryOfOrigin'></span></small></div>";
		
		echo $Form->text_field("colour","Colour",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_colour'></span></small></div>";
		
		echo $Form->text_field("taste","Taste",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_taste'></span></small></div>";
		
		echo $Form->text_field("odour","Odour",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_odour'></span></small></div>";
		
		echo $Form->text_field("foreignMatterAmount","Foreign Matter Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_foreignMatterAmount'></span></small></div>";
		
		echo $Form->text_field("lossOnDryingAmount","Loss On Drying Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_lossOnDryingAmount'></span></small></div>";
		
		echo $Form->text_field("totalAshAmount","Total Ash Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_totalAshAmount'></span></small></div>";
		
		echo $Form->text_field("ashInSolubleAmount","Ash Insoluble Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_ashInSolubleAmount'></span></small></div>";
		
		echo $Form->text_field("assayContentAmount","Assay Content Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_assayContentAmount'></span></small></div>";
		
		echo $Form->text_field("leadAmount","Lead Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_leadAmount'></span></small></div>";
		
		echo $Form->text_field("arsenicAmount","Arsenic Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_arsenicAmount'></span></small></div>";
		
		echo $Form->text_field("mercuryAmount","Mercury Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_mercuryAmount'></span></small></div>";
		
		echo $Form->text_field("totalAerobicAmount","Total Aerobic Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_totalAerobicAmount'></span></small></div>";
		
		echo $Form->text_field("totalCombinedYeastMouldAmount","Total Combined Yeast Mould Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_totalCombinedYeastMouldAmount'></span></small></div>";
		
		echo $Form->text_field("enteroBacteriaAmount","Entero Bacteria Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_enteroBacteriaAmount'></span></small></div>";
		
		echo $Form->text_field("escherichiaAmount","Escherichia Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_escherichiaAmount'></span></small></div>";
		
		echo $Form->text_field("salmonellaAmount","Salmonella Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_salmonellaAmount'></span></small></div>";
		
		echo $Form->text_field("staphylococcusAmount","staphylococcusAmount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_staphylococcusAmount'></span></small></div>";
		
		echo $Form->text_field("mycotoxinsAmount","Mycotoxins Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_mycotoxinsAmount'></span></small></div>";
		
		echo $Form->text_field("pesticidesAmount","Pesticides Amount",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_pesticidesAmount'></span></small></div>";
		
		echo $Form->text_field("allergensPresent","Allergens Present",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_allergensPresent'></span></small></div>";
		
		echo $Form->textarea_field("box1","Content",'');
		echo $Form->textarea_field("box2","Additional Metals Information",'');
		echo $Form->textarea_field("box3","Additional Microbial Information",'');
		echo $Form->textarea_field("box4","Additional Pesticides Information",'');
		echo $Form->text_field("macroscopic","Macroscopic",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_macroscopic'></span></small></div>";
		
		echo $Form->text_field("microscopic","Microscopic",'');
		echo "<div class='field-wrap spec'><small><strong>Spec:</strong> <span id='spec_microscopic'></span></small></div>";
		
		
		echo $Form->hidden("new","new");
		    
		echo $Form->submit_field('btnSubmit', 'Add COA', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();