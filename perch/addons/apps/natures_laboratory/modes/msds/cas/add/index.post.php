 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'MSDS > Add CAS',
    'button'  => [
            'text' => $Lang->get('CAS'),
            'link' => $API->app_nav().'/msds/cas/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'MSDS',
	    'link'  => $API->app_nav().'/msds/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Templates',
	    'link'  => $API->app_nav().'/msds/templates/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'CAS',
	    'link'  => $API->app_nav().'/msds/cas/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		$productList[] = array();
		foreach($products as $Product){
			$productList[] = array('label'=>"$Product[STOCK_CODE] | $Product[DESCRIPTION]", 'value'=>$Product['STOCK_CODE']);
		}
		
		echo $Form->text_field("STOCK_CODE","STOCK CODE",$cas['STOCK_CODE']);
		
		echo $Form->text_field("CAS","CAS",'');
		
		echo $Form->submit_field('btnSubmit', 'Add CAS', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();