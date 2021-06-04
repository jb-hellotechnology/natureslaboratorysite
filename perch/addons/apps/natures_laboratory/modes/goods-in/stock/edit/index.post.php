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