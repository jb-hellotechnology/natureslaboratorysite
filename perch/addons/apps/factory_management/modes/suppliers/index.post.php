<?php	

echo $HTML->title_panel([
'heading' => 'Suppliers'
], $CurrentUser);

$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => true,
    'title' => 'Suppliers',
    'link'  => $API->app_nav().'/suppliers/',
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'Approved',
    'link'  => $API->app_nav().'/suppliers/approved/',
]);

$Smartbar->add_item([
    'active' => false,
    'type'   => 'search',
    'title'  => 'Search',
    'arg'    => 'q',
    'icon'   => 'core/search',
    'position' => 'end',
]);

echo $Smartbar->render();

echo $HTML->main_panel_start();

if($suppliers){

	$Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);
	
	$Listing->add_col([
	    'title' => 'Name',
	    'value' => 'NAME',
	    'edit_link' => 'manage',
	]);
	
	$Listing->add_col([
	    'title' => 'Reference',
	    'value' => 'ACCOUNT_REF'  
	]);
	
	$Listing->add_col([
	    'title' => 'Phone',
	    'value' => 'TELEPHONE'  
	]);
	
	$Listing->add_col([
	    'title' => 'Email',
	    'value' => 'E_MAIL'  
	]);
	
	echo $Listing->render($suppliers);

}else{
	echo $HTML->warning_message('Sorry, no results');	
}

echo $HTML->main_panel_end();

?>