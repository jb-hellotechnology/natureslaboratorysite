 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Goods In > Suppliers > Add',
    'button'  => [
            'text' => $Lang->get('Supplier'),
            'link' => $API->app_nav().'/goods-in/suppliers/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

		
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Goods In',
	    'link'  => $API->app_nav().'/goods-in/',
	]);
	
/*
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Stock',
	    'link'  => $API->app_nav().'/goods-in/stock/',
	]);
*/
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Suppliers',
	    'link'  => $API->app_nav().'/goods-in/suppliers/',
	]);
	
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		echo $Form->text_field("name","Name",'');
		    
		echo $Form->submit_field('btnSubmit', 'Add Supplier', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();