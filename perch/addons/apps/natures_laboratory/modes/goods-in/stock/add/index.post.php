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
		
		echo $Form->text_field("stockCode","Stock Code",'');
		echo $Form->text_field("description","Description",'');
		echo $Form->text_field("component1","C1",'');
		echo $Form->text_field("component2","C2",'');
		echo $Form->text_field("component3","C3",'');
		echo $Form->text_field("component4","C4",'');
		echo $Form->text_field("component5","C5",'');
		echo $Form->text_field("component6","C6",'');
		echo $Form->text_field("qty1","Q1",'');
		echo $Form->text_field("qty2","Q2",'');
		echo $Form->text_field("qty3","Q3",'');
		echo $Form->text_field("qty4","Q4",'');
		echo $Form->text_field("qty5","Q5",'');
		echo $Form->text_field("qty6","Q6",'');
		    
		echo $Form->submit_field('btnSubmit', 'Add Stock', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();