 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Products',
    'button'  => [
            'text' => $Lang->get('Product'),
            'link' => $API->app_nav().'/labels/products/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Labels',
	    'link'  => $API->app_nav().'/labels/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Products',
	    'link'  => $API->app_nav().'/labels/products/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
   
    if (isset($message)){ 
	    
	    echo $message;
	    
	}
	
	if(!$deleted){
		
		echo $Form->form_start();
		    
		echo $Form->submit_field('btnSubmit', 'Delete Product', $API->app_path());
		
		echo $Form->form_end();
	
	} 
    echo $HTML->main_panel_end();