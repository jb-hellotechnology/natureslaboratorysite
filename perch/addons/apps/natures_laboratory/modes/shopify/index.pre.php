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
			
			$taxable = FALSE;
			
			$data = array($handle, $name, "", "Herbal Apothecary", "Health & Beauty > Health Care > Medicine & Drugs", "", "$row[WEB_CATEGORY_1],$row[WEB_CATEGORY_2],$row[WEB_CATEGORY_3]", "Published", "Size", "$size", "", "", "", "", "$row[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$row[SALES_PRICE]", "", "TRUE", "$taxable", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "$row[DESCRIPTION]", "FALSE", "$row[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "Variant Image", "g", "", "$row[LAST_PURCHASE_PRICE]", "", "", "active");
	
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
				
				$taxable = FALSE;
				
				$data = array($handle, $name, "", "Herbal Apothecary", "Health & Beauty > Health Care > Medicine & Drugs", "", "$row[WEB_CATEGORY_1],$row[WEB_CATEGORY_2],$row[WEB_CATEGORY_3]", "Published", "Size", "$size", "", "", "", "", "$row[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$row[SALES_PRICE]", "", "TRUE", "$taxable", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$row['STOCK_CODE']).".jpg", "$row[DESCRIPTION]", "FALSE", "$row[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "Variant Image", "g", "", "$row[LAST_PURCHASE_PRICE]", "", "", "active");
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
				
				$taxable = FALSE;
				
			    $data = array($handle, "$name", "", "Herbal Apothecary", "Health & Beauty > Health Care > Medicine & Drugs", "", "$organic[WEB_CATEGORY_1],$organic[WEB_CATEGORY_2],$organic[WEB_CATEGORY_3]", "Published", "Size", "$size", "", "", "", "", "$organic[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$organic[SALES_PRICE]", "", "TRUE", "$taxable", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$organic['STOCK_CODE']).".jpg", "$organic[DESCRIPTION]", "FALSE", "$organic[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "Variant Image", "g", "", "$organic[LAST_PURCHASE_PRICE]", "", "", "active");
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
					
					$taxable = FALSE;
					
				    $data = array($handle, "$name", "", "Herbal Apothecary", "Health & Beauty > Health Care > Medicine & Drugs", "", "$child[WEB_CATEGORY_1],$child[WEB_CATEGORY_2],$child[WEB_CATEGORY_3]", "Published", "Size", "$size", "", "", "", "", "$child[STOCK_CODE]", "$weight", "shopify", "$qty", "deny", "manual", "$child[SALES_PRICE]", "", "TRUE", "$taxable", "", "", "https://natureslaboratory.co.uk/product-image/".str_replace("/","_",$child['STOCK_CODE']).".jpg", "$child[DESCRIPTION]", "FALSE", "$child[DESCRIPTION]", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "Variant Image", "g", "", "$child[LAST_PURCHASE_PRICE]", "", "", "active");
					fputcsv($output, $data);
			    }
		    
		    }
	    }
    }
    
	exit();