<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
    # include the API
    include('../../../../../core/inc/api.php');
    
    require('../../fpdf/fpdf.php');
    
    $API  = new PerchAPI(1.0, 'natures_laboratory');

    # include your class files
    include('../../Natures_Laboratory.class.php');
    include('../../Natures_Laboratorys.class.php');
    include('../../Natures_Laboratory.coa.oils.class.php');
    include('../../Natures_Laboratory.coas.oils.class.php');
    include('../../Natures_Laboratory.coa.oils.spec.class.php');
    include('../../Natures_Laboratory.coa.oils.specs.class.php');
    include('../../Natures_Laboratory.coa.oils.county.class.php');
    include('../../Natures_Laboratory.coa.oils.countries.class.php');
    include('../../Natures_Laboratory.goodsin.class.php');
    include('../../Natures_Laboratory.goodsins.class.php');
    include('../../Natures_Laboratory.goodsin.stock.class.php');
    include('../../Natures_Laboratory.goodsin.stocks.class.php');
    
    # Grab an instance of the Lang class for translations
    $Lang = $API->get('Lang');

    # Set the page title
    $Perch->page_title = 'Nature\'s Laboratory';


    # Do anything you want to do before output is started
    include('../../modes/coa-oils/get-spec/index.pre.php');
