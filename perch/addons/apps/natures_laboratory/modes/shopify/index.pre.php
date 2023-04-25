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
    
    fputcsv($output, array("Handle", "Title", "Body (HTML)", "Vendor", "Product Category", "Type", "Tags", "Published", "Option1 Name", "Option1 Value", "Option2 Name", "Option2 Value", "Option3 Name", "Option3 Value", "Variant SKU", "Variant Grams", "Variant Inventory Tracker", "Variant Inventory Qty", "Variant Inventory Policy", "Variant Fulfillment Service", "Variant Price", "Variant Compare At Price", "Variant Requires Shipping", "Variant Taxable", "Variant Barcode", "Image Src", "Image Position", "Image Alt Text", "Gift Card", "SEO Title", "SEO Description", "Google Shopping / Google Product Category", "Google Shopping / Gender", "Google Shopping / Age Group", "Google Shopping / MPN", "Google Shopping / AdWords Grouping", "Google Shopping / AdWords Labels", "Google Shopping / Condition", "Google Shopping / Custom Product", "Google Shopping / Custom Label 0", "Google Shopping / Custom Label 1", "Google Shopping / Custom Label 2", "Google Shopping / Custom Label 3", "Google Shopping / Custom Label 4", "Variant Image", "Variant Weight Unit", "Variant Tax Code", "Cost per item", "Price / International", "Compare At Price / International", "Status"));
    
    
    /** CHEMICALS **/
    
    $export = $NaturesLaboratoryShopify->getParents(1,true,false);
    
    /** TINCTURES **/
    
    $export = $NaturesLaboratoryShopify->getParents(2,true,false);
    exportData($export,$output,'Tinctures','1000ml');
    
    /** FLUID EXTRACTS **/
    
    $export = $NaturesLaboratoryShopify->getParents(4,true,false);
    exportData($export,$output,'Fluid Extracts','1000ml');
    
    /** CUT HERBS **/
    
    $export = $NaturesLaboratoryShopify->getParents(5,true,false);
	exportData($export,$output,'Cut Herbs','1000g');
    
    /** WHOLE HERBS **/
    
    $export = $NaturesLaboratoryShopify->getParents(6,true,false);
    exportData($export,$output,'Whole Herbs','1000g');
    
    /** POWDERS **/
    
    $export = $NaturesLaboratoryShopify->getParents(7,true,false);
    exportData($export,$output,'Powders','1000g');
    
    /** POWDER BLENDS **/
    
    $export = $NaturesLaboratoryShopify->getParents(17,true,false);
    exportData($export,$output,'Powder Blends','1000g');
    
    /** CAPSULES **/
    
    $export = $NaturesLaboratoryShopify->getParentsCapsules(false);
    exportData($export,$output,'Capsules','1000');
    
    /** CREAMS **/
    
    $export = $NaturesLaboratoryShopify->getParents(11,true,false);
    exportData($export,$output,'Creams','1000ml');
    
    /** FIXED OILS **/
    
    $export = $NaturesLaboratoryShopify->getParents(13,true,false);
    exportData($export,$output,'Fixed Oils','1000ml');
    
    /** ESSSENTIAL OILS **/
    
    $export = $NaturesLaboratoryShopify->getParents(12,true,false);
    exportData($export,$output,'Essential Oils','1000ml');
    
    /** WAXES AND GUMS **/
    
    $export = $NaturesLaboratoryShopify->getParents(15,true,false);
    exportData($export,$output,'Waxes and Gums','1000g');
    
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
		if($qty<=1){$qty = 0;}
		
		$taxable = FALSE;
		
		$data = array($handle, $name, "", "Herbal Apothecary", "Health & Beauty > Health Care > Medicine & Drugs", "", "$row[WEB_CATEGORY_1],$row[WEB_CATEGORY_2],$row[WEB_CATEGORY_3]", "Published", "Size", "$size", "", "", "", "", "$row[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$row[SALES_PRICE]", "", "TRUE", "$taxable", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "", "$row[DESCRIPTION]", "FALSE", "$row[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "g", "", "$row[LAST_PURCHASE_PRICE]", "", "", "active");

		fputcsv($output, $data);
    }
    
    /** BEEVITAL **/
    
    $export = $NaturesLaboratoryShopify->getParents(10,true,false);
    
    foreach($export as $row){
	    $name = $row['DESCRIPTION'];
		$sku = $row['STOCK_CODE'];

		$price = number_format($row['SALES_PRICE'],2);
		
		$handle = str_replace(array("%",":","/","&"," -"),"",$name);
		$handle = strtolower(str_replace(" ","-",$handle));
		$handle = strtolower(str_replace("--","-",$handle));
		$qty = $row['QTY_IN_STOCK']-$row['QTY_ALLOCATED'];
		if($qty<=1){$qty = 0;}
		
		$taxable = FALSE;
		
		$data = array($handle, $name, "", "BeeVital", "Health & Beauty > Health Care > Medicine & Drugs", "", "$row[WEB_CATEGORY_1],$row[WEB_CATEGORY_2],$row[WEB_CATEGORY_3]", "Published", "Size", "$size", "", "", "", "", "$row[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$row[SALES_PRICE]", "", "TRUE", "$taxable", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "", "$row[DESCRIPTION]", "FALSE", "$row[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "g", "", "$row[LAST_PURCHASE_PRICE]", "", "", "active");

		fputcsv($output, $data);
    }
    
    /** SWEET CECILYS **/
    
    $export = $NaturesLaboratoryShopify->getParents(22,true,false);
    
    foreach($export as $row){
	    $name = $row['DESCRIPTION'];
		$sku = $row['STOCK_CODE'];

		$price = number_format($row['SALES_PRICE'],2);
		
		$handle = str_replace(array("%",":","/","&"," -"),"",$name);
		$handle = strtolower(str_replace(" ","-",$handle));
		$handle = strtolower(str_replace("--","-",$handle));
		$qty = $row['QTY_IN_STOCK']-$row['QTY_ALLOCATED'];
		if($qty<=1){$qty = 0;}
		
		$taxable = FALSE;
		
		$data = array($handle, $name, "", "Sweet Cecily's", "Health & Beauty > Health Care > Medicine & Drugs", "", "$row[WEB_CATEGORY_1],$row[WEB_CATEGORY_2],$row[WEB_CATEGORY_3]", "Published", "Size", "$size", "", "", "", "", "$row[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$row[SALES_PRICE]", "", "TRUE", "$taxable", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "", "$row[DESCRIPTION]", "FALSE", "$row[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "g", "", "$row[LAST_PURCHASE_PRICE]", "", "", "active");

		fputcsv($output, $data);
    }
    
    function exportData($export,$output,$name,$quantity){
	    
	    $NaturesLaboratoryShopify = new Natures_Laboratory_Shopifys($API); 
	      
	    foreach($export as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
		    $size = end($parts);
		    $weight = preg_replace("/[^0-9]/", "", $size);
		    $unit = preg_replace('/[0-9]+/', '', $size);
		    $name = str_replace(" ".$quantity, "", $row['DESCRIPTION']);
			$sku = $row['STOCK_CODE'];
			$parentSku = $sku;

			$price = number_format($row['SALES_PRICE'],2);
			
			$handle = str_replace(array("%",":","/"),"",$name);
			$handle = strtolower(str_replace(" ","-",$handle));
			$handle = strtolower(str_replace("--","-",$handle));
			$qty = $row['QTY_IN_STOCK']-$row['QTY_ALLOCATED'];
			if($qty<=1){$qty = 0;}
			
			$taxable = FALSE;
			
			$data = array($handle, $name, "", "Herbal Apothecary", "Health & Beauty > Health Care > Medicine & Drugs", "", "$row[WEB_CATEGORY_1],$row[WEB_CATEGORY_2],$row[WEB_CATEGORY_3]", "Published", "Size", "$size", "", "", "", "", "$row[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$row[SALES_PRICE]", "", "TRUE", "$taxable", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "", "$row[DESCRIPTION]", "FALSE", "$row[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "g", "", "$row[LAST_PURCHASE_PRICE]", "", "", "active");
	
			fputcsv($output, $data);
			
		    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
		    foreach($children as $row){
			    $parts = explode(" ", $row['DESCRIPTION']);
			    $size = end($parts);
			    $weight = preg_replace("/[^0-9]/", "", $size);
			    $unit = preg_replace('/[0-9]+/', '', $size);
			    //$name = str_replace(" ".$quantity, "", $row['DESCRIPTION']);
				$sku = $row['STOCK_CODE'];
				
				$price = number_format($row['SALES_PRICE'],2);
				
				$qty = $row['QTY_IN_STOCK']-$row['QTY_ALLOCATED'];
				if($qty<=1){$qty = 0;}
				
				$taxable = FALSE;
				
				$data = array($handle, $name, "", "Herbal Apothecary", "Health & Beauty > Health Care > Medicine & Drugs", "", "$row[WEB_CATEGORY_1],$row[WEB_CATEGORY_2],$row[WEB_CATEGORY_3]", "Published", "Size", "$size", "", "", "", "", "$row[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$row[SALES_PRICE]", "", "TRUE", "$taxable", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "", "$row[DESCRIPTION]", "FALSE", "$row[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "g", "", "$row[LAST_PURCHASE_PRICE]", "", "", "active");
				fputcsv($output, $data);
		    }
		    
		    if($row['STOCK_CAT']=='2'){
		    	$organic = $NaturesLaboratoryShopify->getOrganic('1'.$parentSku);
		    }else{
			    $organic = $NaturesLaboratoryShopify->getOrganic($parentSku.'/ORG');
		    }
		    if($organic){
			    $parts = explode(" ", $organic['DESCRIPTION']);
			    $size = end($parts);
			    $weight = preg_replace("/[^0-9]/", "", $size);
			    $unit = preg_replace('/[0-9]+/', '', $size);
			    $name = str_replace(" ".$quantity, "", $organic['DESCRIPTION']);
				$sku = $organic['STOCK_CODE'];
				
				$price = number_format($organic['SALES_PRICE'],2);
				
				$handle = str_replace(array("%",":","/"),"",$name);
				$handle = strtolower(str_replace(" ","-",$handle));
				$handle = strtolower(str_replace("--","-",$handle));
				$qty = $organic['QTY_IN_STOCK']-$organic['QTY_ALLOCATED'];
				if($qty<=1){$qty = 0;}
				
				$taxable = FALSE;
				
			    $data = array($handle, "$name", "", "Herbal Apothecary", "Health & Beauty > Health Care > Medicine & Drugs", "", "$organic[WEB_CATEGORY_1],$organic[WEB_CATEGORY_2],$organic[WEB_CATEGORY_3]", "Published", "Size", "$size", "", "", "", "", "$organic[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$organic[SALES_PRICE]", "", "TRUE", "$taxable", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$organic['STOCK_CODE']).".jpg", "", "$organic[DESCRIPTION]", "FALSE", "$organic[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$organic['STOCK_CODE']).".jpg", "g", "", "$organic[LAST_PURCHASE_PRICE]", "", "", "active");
				fputcsv($output, $data);
				
				$children = $NaturesLaboratoryShopify->getOrganicChildren($organic['STOCK_CODE']);
			    foreach($children as $child){
				    $parts = explode(" ", $child['DESCRIPTION']);
				    $size = end($parts);
				    $weight = preg_replace("/[^0-9]/", "", $size);
				    $unit = preg_replace('/[0-9]+/', '', $size);
				    //$name = str_replace(" ".$quantity, "", $child['DESCRIPTION']);
					$sku = $child['STOCK_CODE'];
					
					$price = number_format($child['SALES_PRICE'],2);

					$qty = $child['QTY_IN_STOCK']-$child['QTY_ALLOCATED'];
					if($qty<=1){$qty = 0;}
					
					$taxable = FALSE;
					
				    $data = array($handle, "$name", "", "Herbal Apothecary", "Health & Beauty > Health Care > Medicine & Drugs", "", "$child[WEB_CATEGORY_1],$child[WEB_CATEGORY_2],$child[WEB_CATEGORY_3]", "Published", "Size", "$size", "", "", "", "", "$child[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$child[SALES_PRICE]", "", "TRUE", "$taxable", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$child['STOCK_CODE']).".jpg", "", "$child[DESCRIPTION]", "FALSE", "$child[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$child['STOCK_CODE']).".jpg", "g", "", "$child[LAST_PURCHASE_PRICE]", "", "", "active");
					fputcsv($output, $data);
			    }
		    
		    }
	    }
    }
    
	exit();