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
	header('Content-Disposition: attachment; filename=shopify_stock_update.csv');
	
	$output = fopen( 'php://output', 'w' );
	
	ob_end_clean();
    
    fputcsv($output, array("Handle", "Title", "Option1 Name", "Option1 Value", "Variant SKU", "Variant Inventory Qty", "Variant Price"));
    
    
    /** CHEMICALS **/
    
    $export = $NaturesLaboratoryShopify->getParents(1,true,false);
    
    /** TINCTURES **/
    
    $export = $NaturesLaboratoryShopify->getParents(2,true,false);
    exportData($export,$output,'Tinctures','1000ml');
    
    /** BIODYNAMIC **/
    
    $export = $NaturesLaboratoryShopify->getParentsBiodynamic(2,true,false);
    exportData($export,$output,'Biodynamic','1000ml');
    
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

    $export = $NaturesLaboratoryShopify->getParentsRetailCapsules(false);
    exportData($export,$output,'Capsules','60');
    
    $export = $NaturesLaboratoryShopify->getCapsules();
    exportData($export,$output,'Capsules','1000g');
    
    /** PESSARIES **/
    
    $export = $NaturesLaboratoryShopify->getParentsPessaries(false);
    exportData($export,$output,'Pessaries','30');
    
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
    
    $export = $NaturesLaboratoryShopify->getParents(15,false,false);
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
			$individual = $NaturesLaboratoryShopify->getBySKU($SKU);
			$stock = $individual['QTY_IN_STOCK']-$individual['QTY_ALLOCATED'];
			$qty = floor($stock/6);
			
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
		    
		    //WHITBY TEA
		    if(strpos($row['DESCRIPTION'], 'Whitby') !== false){
		    	$name = str_replace(" 100g", "", $row['DESCRIPTION']);
		    	$name = str_replace(" 1000g", "", $name);
		    }
		    
			$sku = $row['STOCK_CODE'];
			$parentSku = $sku;
			
			if($row['STOCK_CAT']=='12'){
				$name = $name.' Essential Oil';
			}
			
			if($row['STOCK_CAT']=='8'){
				$size = '1000 '.$size;
			}
			
			if($row['STOCK_CAT']=='17' AND substr($row['STOCK_CODE'],0,4)=='PESS'){
				$size = $size.' Pessaries';
			}

			$price = number_format($row['SALES_PRICE'],2);
			
			$handle = str_replace(array("%",":","/","'"),"",$name);
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
			
			if($row['STOCK_CAT']=='2' OR $row['STOCK_CAT']=='80'){
				//TINCTURE
				$nameParts = explode(" ",$name);
				$partsCount = count($nameParts);
				$ratio = $nameParts[$partsCount-2];
				$ratioParts = explode(":",$ratio);
				$waterR = $ratioParts[1];
				$alcohol = substr($nameParts[$partsCount-1],0,-1);
				$water = 100 - $alcohol;
				$nameParts2 = explode(" / ",$name);
				$herb = $nameParts2[0];
				
				$body = "<p>Tincture made by a process of hydro-ethanolic percolation, with a ratio of 1 part $herb to $waterR parts liquid. Liquid comprises of $water% water and $alcohol% sugar beet derived ethanol. Available in 250ml, 500ml and 1000ml amber coloured PET bottles.</p>";
			}elseif($row['STOCK_CAT']=='4'){
				//FLUID 
				$nameParts = explode(" ",$name);
				$partsCount = count($nameParts);
				$ratio = $nameParts[$partsCount-2];
				$ratioParts = explode(":",$ratio);
				$waterR = $ratioParts[1];
				$alcohol = substr($nameParts[$partsCount-1],0,-1);
				$water = 100 - $alcohol;
				$nameParts2 = explode(" / ",$name);
				$herb = $nameParts2[0];
				
				$body = "<p>Fluid Extract made by a process of hydro-ethanolic percolation, with a ratio of 1 part $herb to 1 part liquid. Liquid comprises of $water% water and $alcohol% sugar beet derived ethanol. Available in 250ml, 500ml and 1000ml amber coloured PET bottles.</p>";
			}elseif($row['STOCK_CAT']=='5'){
				//CUT
				$nameParts = explode(" / ",$name);
				$herb = $nameParts[0];
				$body = "<p>Cut $herb, packaged in a protective foil bag. Available in 250g, 500g and 1000g quantities. Cut herbs are herbs which have been harvested, dried and then cut into smaller pieces, suitable for further processing. Cut herbs like this $herb can be used to produce tinctures or fluid extracts. They can also be used in herbal teas and infusions.</p>";
			}elseif($row['STOCK_CAT']=='6'){
				//WHOLE
				$nameParts = explode(" / ",$name);
				$herb = $nameParts[0];
				$body = "<p>Whole $herb, packaged in a protective foil bag. Available in 250g, 500g and 1000g quantities. Whole herbs are herbs which have been harvested, dried and packaged suitable for further processing. Whole herbs like this $herb can be used to produce tinctures or fluid extracts. They can also be used in herbal teas and infusions.</p>";
			}elseif($row['STOCK_CAT']=='7'){
				//POWDER
				$nameParts = explode(" / ",$name);
				$herb = $nameParts[0];
				$body = "<p>Powdered $herb, packaged in a protective foil bag. Available in 250g, 500g and 1000g quantities. Powdered herbs are herbs which have been harvested, dried, powdered and packaged suitable for further processing. Powdered herbs like this $herb can be used to produce powder blends, capsules or as ingredients in other products.</p>";
			}elseif($row['STOCK_CAT']=='8'){
				//CAPSULES
				$nameParts = explode(" / ",$name);
				$herb = $nameParts[0];
				$body = "<p>Powdered $herb contained in size ‘0’ Vegetable Cellulose Capsules. Sold in bags of 1000 Capsules or pots of 100 Capsules.</p>";
			}elseif($row['STOCK_CAT']=='12'){
				//ESSENTIAL OIL
				$body = "<p><strong>Directions for Use</strong></p><ul><li><em>Diffusion:</em> Use three to four drops in the diffuser of your choice.</li><li><em>Topical use:</em> Apply one to two drops to desired area. Dilute with a carrier oil to minimize any skin sensitivity.</li></ul><p><strong>Cautions</strong></p><p>Possible skin sensitivity. Keep out of reach of children. If you are pregnant, nursing, or under a doctor’s care, consult your physician. Avoid contact with eyes, inner ears, and sensitive areas.</p>";
			}
			
			if($row['SALES_PRICE']>0){
			
				$parentSKU = $sku;
				$parentQTY = $qty;
				$parentPrice = $price;
				
				if($row['STOCK_CAT']=='8'){
					if($qty==0){
						$skuParts = explode("V", $sku);
						$powderSKU = substr($skuParts[0],1);
						if(strlen($powderSKU)>3){
							$powderData = $NaturesLaboratoryShopify->getBySKU($powderSKU);
							$qty = floor(($powderData['QTY_IN_STOCK']-$powderData['QTY_ALLOCATED'])*1.5);
						}
					}
				}
				
				if(strpos($row['DESCRIPTION'], 'Hello ') !== false){
					$data = array($handle, $name, "", "", "$sku", "$qty", "$price");
					fputcsv($output, $data);
				}else{
					$data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");	
					fputcsv($output, $data);
				}
		
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
					
					if($row['STOCK_CAT']<>'15'){
						$data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
						fputcsv($output, $data);
					}
			    }
			    
			    if($row['STOCK_CAT']=='2' OR $row['STOCK_CAT']=='4'){
				    $size = '5l';
				    $sku = $parentSKU."/5000";
				    $qty = floor($parentQTY/5);
				    if($qty<0){
					    $qty = 0;
				    }
				    $price = number_format(($parentPrice*5)*0.975, 2, '.', '');
				    $data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
					fputcsv($output, $data);
					
					$size = '10l';
				    $sku = $parentSKU."/10000";
				    $qty = floor($parentQTY/10);
				    if($qty<0){
					    $qty = 0;
				    }
				    $price = number_format(($parentPrice*10)*0.95, 2, '.', '');
				    $data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
					fputcsv($output, $data);
					
					$size = '25l';
				    $sku = $parentSKU."/25000";
				    $qty = floor($parentQTY/25);
				    if($qty<0){
					    $qty = 0;
				    }
				    $price = number_format(($parentPrice*25)*0.90, 2, '.', '');
				    $data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
					fputcsv($output, $data);
			    }
			    
			    if($row['STOCK_CAT']=='5' OR $row['STOCK_CAT']=='6' OR $row['STOCK_CAT']=='7' OR $row['STOCK_CAT']=='17'){
				    if(strpos($row['DESCRIPTION'], 'Pessaries') === false AND strpos($row['DESCRIPTION'], 'Whitby') === false){
					    $size = '5kg';
					    $sku = $parentSKU."/5000";
					    $qty = floor($parentQTY/5);
					    if($qty<0){
						    $qty = 0;
					    }
					    $price = number_format(($parentPrice*5)*0.975, 2, '.', '');
					    $data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
						fputcsv($output, $data);
						
						$size = '10kg';
					    $sku = $parentSKU."/10000";
					    $qty = floor($parentQTY/10);
					    if($qty<0){
						    $qty = 0;
					    }
					    $price = number_format(($parentPrice*10)*0.95, 2, '.', '');
					    $data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
						fputcsv($output, $data);
						
						$size = '25kg';
					    $sku = $parentSKU."/25000";
					    $qty = floor($parentQTY/25);
					    if($qty<0){
						    $qty = 0;
					    }
					    $price = number_format(($parentPrice*25)*0.90, 2, '.', '');
					    $data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
						fputcsv($output, $data);
					}
			    }
			    
			    if($row['STOCK_CAT']=='8'){
				    if(strpos($row['DESCRIPTION'], 'Hello ') === false){
				    	$children = $NaturesLaboratoryShopify->getChildrenCapsules($row['STOCK_CODE']);
					    foreach($children as $row){
						    $parts = explode(" ", $row['DESCRIPTION']);
						    $size = '100 Capsules';
						    $weight = preg_replace("/[^0-9]/", "", $size);
						    $unit = preg_replace('/[0-9]+/', '', $size);
						    //$name = str_replace(" ".$quantity, "", $row['DESCRIPTION']);
							$sku = $row['STOCK_CODE'];
							
							$qty = $row['QTY_IN_STOCK']-$row['QTY_ALLOCATED'];
							$price = number_format($row['SALES_PRICE'],2);
							
							$data = array($handle, $name, "Size", "$size", "$sku", "$qty", "$price");
							fputcsv($output, $data);
					    }
				    }
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