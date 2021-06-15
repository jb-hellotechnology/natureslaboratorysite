<?php
	
    # include the API
    include('../../../../core/inc/api.php');
    
    $API  = new PerchAPI(1.0, 'natures_laboratory');

    # include your class files
    
    require('../fpdf/fpdf.php');
    include('../phpqrcode/qrlib.php');
    
    include('../Natures_Laboratory.class.php');
    include('../Natures_Laboratorys.class.php');
    include('../Natures_Laboratory.coa.class.php');
    include('../Natures_Laboratory.coas.class.php');
    include('../Natures_Laboratory.coa.spec.class.php');
    include('../Natures_Laboratory.coa.specs.class.php');
    
    # Grab an instance of the Lang class for translations
    $Lang = $API->get('Lang');

    # Set the page title
    $Perch->page_title = 'Nature\'s Laboratory';


    # Do anything you want to do before output is started
    include('../modes/coa/getspec.pre.php');
