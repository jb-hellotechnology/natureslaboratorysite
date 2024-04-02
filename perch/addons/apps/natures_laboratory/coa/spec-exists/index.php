<?php
	
/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
*/
	
    # include the API
    include('../../../../../core/inc/api.php');
    
    $API  = new PerchAPI(1.0, 'natures_laboratory');

    # include your class files
    include('../../Natures_Laboratory.class.php');
    include('../../Natures_Laboratorys.class.php');
    include('../../Natures_Laboratory.coa.class.php');
    include('../../Natures_Laboratory.coas.class.php');
    include('../../Natures_Laboratory.coa.spec.class.php');
    include('../../Natures_Laboratory.coa.specs.class.php');
    
    # Grab an instance of the Lang class for translations
    $Lang = $API->get('Lang');

    # Set the page title
    $Perch->page_title = 'Nature\'s Laboratory';


    # Do anything you want to do before output is started
    include('../../modes/coa/spec-exists/index.pre.php');
