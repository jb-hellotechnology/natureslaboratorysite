<?php
	
/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
*/
	
    # include the API
    include('../../../../core/inc/api.php');
    
    $API  = new PerchAPI(1.0, 'factory_management');

    # include your class files
    foreach (glob("../classes/*.php") as $filename)
	{
	    include $filename;
	}
    
    # Grab an instance of the Lang class for translations
    $Lang = $API->get('Lang');

    # Set the page title
    $Perch->page_title = 'Supplier';

    
    # Display your page
    include('../modes/goods-in/getOrder.php');