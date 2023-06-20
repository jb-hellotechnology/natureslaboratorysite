 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Production',
    'button'  => [
            'text' => $Lang->get('Production'),
            'link' => $API->app_nav().'/production/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Shortfall',
	    'link'  => $API->app_nav().'/production/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Scheduled',
	    'link'  => $API->app_nav().'/production/scheduled/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'In Production',
	    'link'  => $API->app_nav().'/production/in-production/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Completed',
	    'link'  => $API->app_nav().'/production/completed/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		$process = $NaturesLaboratoryProduction->getProcess($_GET['id']);
		$product = $NaturesLaboratoryProduction->getProduct($process['sku']);
		
		echo '<h2>P'.str_pad($process['natures_laboratory_productionID'], 6, '0', STR_PAD_LEFT).' | '.$process['sku'].' - '.$product['DESCRIPTION'].'</h2>';
		
		echo "<br /><p>How Much Did You Make? (".$process['units']." Units Expected)</p>";
		
		echo $Form->text_field("unitsMade","Units Made",'');
		
		echo "<br /><p>Packaging</p>";
		
		echo $Form->text_field("packagingNotes","Packaging Notes",'');
		
		if($product['STOCK_CAT']=='2' OR $product['STOCK_CAT']=='4'){
		
			echo "<br /><p>Bottling</p>";
			
			echo $Form->text_field("250ml","250ml Bottles",'');
			echo $Form->text_field("500ml","500ml Bottles",'');
			echo $Form->text_field("1000ml","1000ml Bottles",'');
			echo $Form->text_field("5l","5l Kegs",'');
			echo $Form->text_field("25l","25l Kegs",'');
			echo $Form->text_field("other","Other Quantity",'');
			
		}
		
		echo "<br /><p>BBE</p>";
		
		echo $Form->date_field("bbe","BBE Date",'');
		
		echo "<br /><p>Completed By</p>";
		
		$names[] = array('label'=>'Please Select', 'value'=>'');
		$names[] = array('label'=>'Andy', 'value'=>'Andy');
		$names[] = array('label'=>'Sean', 'value'=>'Sean');
		$names[] = array('label'=>'Tom', 'value'=>'Tom');
		echo $Form->select_field("completedBy","",$names,'');
		
		echo $Form->hidden("status",'completed');
		    
		echo $Form->submit_field('btnSubmit', 'Complete', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();