<?php
	
/*
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
*/
	
    # include the API
    include('../../../../core/inc/api.php');
    
    $API  = new PerchAPI(1.0, 'natures_laboratory');

    # include your class files
    
    require('../fpdf/fpdf.php');
    include('../phpqrcode/qrlib.php');
    
    include('../Natures_Laboratory.class.php');
    include('../Natures_Laboratorys.class.php');
    include('../Natures_Laboratory.shopify.class.php');
    include('../Natures_Laboratory.shopifys.class.php');
    
    # Grab an instance of the Lang class for translations
    $Lang = $API->get('Lang');

    # Set the page title
    $Perch->page_title = 'Nature\'s Laboratory';
   
	$NaturesLaboratoryShopify = new Natures_Laboratory_Shopifys($API); 
	
	$HTML = $API->get('HTML');
    
    if (isset($_POST['btnSubmit'])) {
    
	    $currentDirectory = getcwd();
	    $uploadDirectory = "/uploads/";
	
	    $errors = []; // Store errors here
	
	    $fileExtensionsAllowed = ['csv']; // These will be the only file extensions allowed 
	
	    $fileName = 'stock.csv';
	    $fileSize = $_FILES['file']['size'];
	    $fileTmpName  = $_FILES['file']['tmp_name'];
	    $fileType = $_FILES['file']['type'];
	    $fileExtension = strtolower(end(explode('.',$fileName)));
	
	    $uploadPath = $currentDirectory . $uploadDirectory . basename($fileName); 

    

      if (! in_array($fileExtension,$fileExtensionsAllowed)) {
        $errors[] = "This file extension is not allowed. Please upload a JPEG or PNG file";
      }

      if ($fileSize > 10000000) {
        $errors[] = "File exceeds maximum size (10MB)";
      }

      if (empty($errors)) {
        $didUpload = move_uploaded_file($fileTmpName, $uploadPath);

        if ($didUpload) {
          //echo "The file " . basename($fileName) . " has been uploaded";
          $message = $HTML->success_message('Data has been successfully imported');
          //EMPTY TABLE
          $NaturesLaboratoryShopify->emptyStock();
          
          //IMPORT NEW DATA
          $NaturesLaboratoryShopify->importStock();
          
          
        } else {
          //echo "An error occurred. Please contact the administrator.";
          $message = $HTML->error_message('There was an error');
        }
      } else {
        foreach ($errors as $error) {
          $message = $HTML->error_message('There was an error');
        }
      }

    }
    
    
    # Set Subnav
    include('../modes/_subnav.php');


    # Do anything you want to do before output is started
    include('../modes/sage/index.pre.php');
    
    
    # Top layout
    include(PERCH_CORE . '/inc/top.php');

    
    # Display your page
    include('../modes/sage/index.post.php');
    
    
    # Bottom layout
    include(PERCH_CORE . '/inc/btm.php');
