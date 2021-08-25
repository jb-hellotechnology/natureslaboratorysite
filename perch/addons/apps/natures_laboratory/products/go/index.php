<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
    # include the API
    include('../../../../../core/inc/api.php');
    
    $API  = new PerchAPI(1.0, 'natures_laboratory');

    # include your class files
    include('../../Natures_Laboratory.class.php');
    include('../../Natures_Laboratorys.class.php');
    include('../../Natures_Laboratory.coa.products.class.php');
    include('../../Natures_Laboratory.coas.products.class.php');

	$NaturesLaboratoryCOA = new Natures_Laboratory_COA_Products($API);

	$batchCode = $_GET['id'];
	$COA = $NaturesLaboratoryCOA->byBatch($batchCode);
	if($COA){
		header("location:https://natureslaboratory.co.uk/herbal-apothecary/get-coa/?batch=".$batchCode);
	}else{
		echo 'NO COA';
	}
?>