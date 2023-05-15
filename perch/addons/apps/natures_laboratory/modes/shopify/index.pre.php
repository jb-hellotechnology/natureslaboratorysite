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
	header('Content-Disposition: attachment; filename=herbalapothecary.csv');
	
	$output = fopen( 'php://output', 'w' );
	
	ob_end_clean();
    
    fputcsv($output, array("Handle", "Title", "Body (HTML)", "Vendor", "Product Category", "Type", "Tags", "Published", "Option1 Name", "Option1 Value", "Option2 Name", "Option2 Value", "Option3 Name", "Option3 Value", "Variant SKU", "Variant Grams", "Variant Inventory Tracker", "Variant Inventory Qty", "Variant Inventory Policy", "Variant Fulfillment Service", "Variant Price", "Variant Compare At Price", "Variant Requires Shipping", "Variant Taxable", "Variant Barcode", "Image Src", "Image Position", "Image Alt Text", "Gift Card", "SEO Title", "SEO Description", "Google Shopping / Google Product Category", "Google Shopping / Gender", "Google Shopping / Age Group", "Google Shopping / MPN", "Google Shopping / AdWords Grouping", "Google Shopping / AdWords Labels", "Google Shopping / Condition", "Google Shopping / Custom Product", "Google Shopping / Custom Label 0", "Google Shopping / Custom Label 1", "Google Shopping / Custom Label 2", "Google Shopping / Custom Label 3", "Google Shopping / Custom Label 4", "Variant Image", "Variant Weight Unit", "Variant Tax Code", "Cost per item", "Included / United Kingdom", "Included / European Union", "Price / European Union", "Compare At Price / European Union", "Included International", "Price / International", "Compare At Price / International", "Status"));
    
    /** PACKAGING **/
    
    $export = $NaturesLaboratoryShopify->getParents(14,false,false);
    
    foreach($export as $row){
	    $name = $row['DESCRIPTION'];
		$sku = $row['STOCK_CODE'];

		$price = number_format($row['SALES_PRICE'],2);
		
		$handle = str_replace(array("%",":","/","&"," -"),"",$name);
		$handle = strtolower(str_replace(" ","-",$handle));
		$handle = strtolower(str_replace("--","-",$handle));
		$qty = $row['QTY_IN_STOCK']-$row['QTY_ALLOCATED'];
		if($qty<1){$qty = 0;}
		
		$taxable = "TRUE";
		
		$data = array($handle, $name, "", "Herbal Apothecary", "Health & Beauty > Health Care > Medicine & Drugs", "", "$row[WEB_CATEGORY_1],$row[WEB_CATEGORY_2],$row[WEB_CATEGORY_3]", "TRUE", "Title", "Default Title", "", "", "", "", "$row[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$row[SALES_PRICE]", "", "TRUE", "$taxable", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "", "$row[DESCRIPTION]", "FALSE", "$row[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "g", "", "$row[LAST_PURCHASE_PRICE]", "TRUE", "", "", "", "", "", "", "active");

		fputcsv($output, $data);
    }
    
    
	exit();