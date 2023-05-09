<?php
	
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryShopify = new Natures_Laboratory_Shopifys($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=beevital_shopify_stock_update.csv');
	
	$output = fopen( 'php://output', 'w' );
	
	ob_end_clean();
    
    fputcsv($output, array("Handle", "Title", "Option1 Name", "Option1 Value", "Variant SKU", "Variant Inventory Qty", "Variant Price"));
    
    /** BEEVITAL **/
    
    $export = $NaturesLaboratoryShopify->getParents(10,true,false);
    
    foreach($export as $row){
	    $name = $row['DESCRIPTION'];
		$sku = $row['STOCK_CODE'];

		$price = number_format($row['SALES_PRICE'],2);
		
		$handle = str_replace(array("%",":","/","&"," -","beevital"),"",$name);
		$handle = strtolower(str_replace(" ","-",$handle));
		$handle = strtolower(str_replace("--","-",$handle));
		$qty = $row['QTY_IN_STOCK']-$row['QTY_ALLOCATED'];
		if($qty<1){$qty = 0;}
		
		$taxable = "TRUE";
		
		$trade = substr($row['STOCK_CODE'], -1);
		if($trade=='T'){
			
			$SKU = str_replace("T","",$row['STOCK_CODE']);
			$individual = $NaturesLaboratoryShopify->getBySKU($SKU);
			$stock = $individual['QTY_IN_STOCK']-$individual['QTY_ALLOCATED'];
			$qty = floor($stock/6);
			
			$data = array($handle, $name, "Title", "Default Title", "$row[STOCK_CODE]", "$qty", "$row[SALES_PRICE]");
			
		}else{
		
			$data = array($handle, $name, "Title", "Default Title", "$row[STOCK_CODE]", "$qty", "$row[SALES_PRICE]");
		
		}

		fputcsv($output, $data);
    }

       
	exit();