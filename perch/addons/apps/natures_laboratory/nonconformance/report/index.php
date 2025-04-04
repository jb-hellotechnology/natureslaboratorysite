<?php
	
/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
*/
	
    # include the API
    include('../../../../../core/inc/api.php');
    
    require('../../fpdf/fpdf.php');
    
    $API  = new PerchAPI(1.0, 'natures_laboratory');

    # include your class files
    include('../../Natures_Laboratory.class.php');
    include('../../Natures_Laboratorys.class.php');
    include('../../Natures_Laboratory.nonconformance.class.php');
    include('../../Natures_Laboratory.nonconformances.class.php');
    
    # Grab an instance of the Lang class for translations
    $Lang = $API->get('Lang');

    # Set the page title
    $Perch->page_title = 'Nature\'s Laboratory';
    
    
    # Set Subnav
    include('../../modes/_subnav.php');


    # Do anything you want to do before output is started
    include('../../modes/nonconformance/report/index.pre.php');
    
    
    # Top layout
    include(PERCH_CORE . '/inc/top.php');

    
    # Display your page
    include('../../modes/nonconformance/report/index.post.php');
    
    
    # Bottom layout
    include(PERCH_CORE . '/inc/btm.php');
