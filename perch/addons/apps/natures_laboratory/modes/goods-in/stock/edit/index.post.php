 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Stock',
    'button'  => [
            'text' => $Lang->get('Stock'),
            'link' => $API->app_nav().'/goods-in/stock/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

		
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Goods In',
	    'link'  => $API->app_nav().'/goods-in/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Stock',
	    'link'  => $API->app_nav().'/goods-in/stock/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Suppliers',
	    'link'  => $API->app_nav().'/goods-in/suppliers/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		echo $Form->text_field("stockCode","Stock Code",$details['stockCode']);
		echo $Form->text_field("description","Description",$details['description']);
		
		$categories[] = array('value'=>'1', 'label'=>'Unclassified');
		$categories[] = array('value'=>'2', 'label'=>'Tinctures');
		$categories[] = array('value'=>'4', 'label'=>'Fluid Extracts');
		$categories[] = array('value'=>'5', 'label'=>'Cut Herbs');
		$categories[] = array('value'=>'6', 'label'=>'Whole Herbs');
		$categories[] = array('value'=>'7', 'label'=>'Powders');
		$categories[] = array('value'=>'8', 'label'=>'Capsules');
		$categories[] = array('value'=>'9', 'label'=>'Chinese');
		$categories[] = array('value'=>'10', 'label'=>'BeeVital');
		$categories[] = array('value'=>'11', 'label'=>'Creams');
		$categories[] = array('value'=>'12', 'label'=>'Essential Oils');
		$categories[] = array('value'=>'13', 'label'=>'Fixed Oils');
		$categories[] = array('value'=>'14', 'label'=>'Packaging');
		$categories[] = array('value'=>'15', 'label'=>'Gums');
		$categories[] = array('value'=>'16', 'label'=>'Misc');
		$categories[] = array('value'=>'17', 'label'=>'Detox');
		$categories[] = array('value'=>'18', 'label'=>'Organics');
		$categories[] = array('value'=>'20', 'label'=>'Teas');
		$categories[] = array('value'=>'21', 'label'=>'Supplements');
		$categories[] = array('value'=>'22', 'label'=>"Sweet Cecily's");
		$categories[] = array('value'=>'40', 'label'=>'Bespoke Blends');
		$categories[] = array('value'=>'999', 'label'=>'Discontinued');
		echo $Form->select_field('category','Category',$categories,$details['category']);
		
		echo $Form->text_field("component1","C1",$details['component1']);
		echo $Form->text_field("component2","C2",$details['component2']);
		echo $Form->text_field("component3","C3",$details['component3']);
		echo $Form->text_field("component4","C4",$details['component4']);
		echo $Form->text_field("component5","C5",$details['component5']);
		echo $Form->text_field("component6","C6",$details['component6']);
		echo $Form->text_field("qty1","Q1",$details['qty1']);
		echo $Form->text_field("qty2","Q2",$details['qty2']);
		echo $Form->text_field("qty3","Q3",$details['qty3']);
		echo $Form->text_field("qty4","Q4",$details['qty4']);
		echo $Form->text_field("qty5","Q5",$details['qty5']);
		echo $Form->text_field("qty6","Q6",$details['qty6']);
		    
		echo $Form->submit_field('btnSubmit', 'Update Stock', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();