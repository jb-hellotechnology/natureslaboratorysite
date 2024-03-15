<?php
	
    # include the API
    include('../../../../core/inc/api.php');
    
    $API  = new PerchAPI(1.0, 'natures_laboratory');

    # include your class files
    
    require('../fpdf/fpdf.php');
    include('../phpqrcode/qrlib.php');
    
    include('../Natures_Laboratory.class.php');
    include('../Natures_Laboratorys.class.php');
    include('../Natures_Laboratory.coa.products.class.php');
    include('../Natures_Laboratory.coas.products.class.php');
    include('../Natures_Laboratory.coa.products.spec.class.php');
    include('../Natures_Laboratory.coa.products.specs.class.php');
    
    # Grab an instance of the Lang class for translations
    $Lang = $API->get('Lang');

    # Set the page title
    $Perch->page_title = 'Nature\'s Laboratory';


    # Do anything you want to do before output is started
    include('../modes/coa-products/getspec.pre.php');
