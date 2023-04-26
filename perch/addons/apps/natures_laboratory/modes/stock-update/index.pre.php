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
    
    fputcsv($output, array("Handle", "Title", "Option1 Name", "Option1 Value", "Variant SKU", "Variant Inventory Qty", "Variant Price"));
    
    
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
		if($qty<1){$qty = 0;}
		
		$taxable = "TRUE";
		
		$data = array($handle, $name, "Title", "Default Title", "$row[STOCK_CODE]", "$qty", "$row[SALES_PRICE]");

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
		if($qty<1){$qty = 0;}
		
		$taxable = "TRUE";
		
		$trade = substr($row['STOCK_CODE'], -1);
		if($trade=='T'){
			
			$SKU = str_replace("T","",$row['STOCK_CODE']);
			
			$data = array($handle, $name, "Title", "Default Title", "$row[STOCK_CODE]", "$qty", "$row[SALES_PRICE]");
			
		}else{
		
			$data = array($handle, $name, "Title", "Default Title", "$row[STOCK_CODE]", "$qty", "$row[SALES_PRICE]");
		
		}

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
		if($qty<1){$qty = 0;}
		
		$taxable = "TRUE";
		
		$tags = str_replace("’","","$row[WEB_CATEGORY_1],$row[WEB_CATEGORY_2],$row[WEB_CATEGORY_3]");
		
		$data = array($handle, $name, "Title", "Default Title", "$row[STOCK_CODE]", "$qty", "$row[SALES_PRICE]");

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
			
			if($row['STOCK_CAT']=='12'){
				$name = $name.' Essential Oil';
			}
			
			if($row['STOCK_CAT']=='8'){
				$size = '1000 '.$size;
			}

			$price = number_format($row['SALES_PRICE'],2);
			
			$handle = str_replace(array("%",":","/"),"",$name);
			$handle = strtolower(str_replace(" ","-",$handle));
			$handle = strtolower(str_replace("--","-",$handle));
			$qty = $row['QTY_IN_STOCK']-$row['QTY_ALLOCATED'];
			if($qty<1){$qty = 0;}
			$parentQty = $qty;
			
			if($row['TAX_CODE']=='T1'){
				$taxable = "TRUE";	
			}else{
				$taxable = "";
			}
			
			if($row['SALES_PRICE']>0){
			
				$data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
		
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
					
					if($row['STOCK_CAT']==5 OR $row['STOCK_CAT']==6 OR $row['STOCK_CAT']==7 OR $row['STOCK_CAT']==17){
						if($size=='500g'){
							$qty = $parentQty*2;
						}elseif($size=='250g'){
							$qty = $parentQty*4;
						}
					}else{
						$qty = $row['QTY_IN_STOCK']-$row['QTY_ALLOCATED'];
						if($qty<1){$qty = 0;}	
					}
					
					$data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
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
					if($qty<1){$qty = 0;}
					
 				    $data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
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
						if($qty<1){$qty = 0;}
						
					    $data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
						fputcsv($output, $data);
				    }
			    
			    }
			}
	    }
    }
    
	exit();