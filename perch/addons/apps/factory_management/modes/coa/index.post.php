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
    
    $Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);
	
	$Listing->add_col([
	    'title' => 'Date',
	    'value' => 'dateEntered',
	    'edit_link' => 'edit',
	]);
	
	$Listing->add_col([
	    'title' => 'Code',
	    'value' => 'productCode'
	]);
	
	$Listing->add_col([
	    'title' => 'Batch',
	    'value' => 'ourBatch'  
	]);
	
	echo $Listing->render($coa);

    echo $HTML->main_panel_end();