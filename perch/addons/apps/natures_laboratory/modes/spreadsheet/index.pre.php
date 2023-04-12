<?php

	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryShopify = new Natures_Laboratory_Shopifys($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=herbalapothecary.csv');
	
	$output = fopen( 'php://output', 'w' );
	
	ob_end_clean();
    
    /** CHEMICALS **/
    
    $export = $NaturesLaboratoryShopify->getParents(1);
    
    /** TINCTURES **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(2);
    
    fputcsv($output, array('Tinctures','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000ml", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000ml", "", $row['DESCRIPTION']);
	    if($size=='250ml'){
			$weight = 250;
		}elseif($size=='500ml'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));

		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250ml'){
				$weight = 250;
			}elseif($size=='500ml'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }
    }
    
    /** FLUID EXTRACTS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(4);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Fluid Extracts','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000ml", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000ml", "", $row['DESCRIPTION']);
	    if($size=='250ml'){
			$weight = 250;
		}elseif($size=='500ml'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));

		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250ml'){
				$weight = 250;
			}elseif($size=='500ml'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }
    }
    
    
    /** CUT HERBS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(5);

    fputcsv($output, array('','','',''));
    fputcsv($output, array('Cut Herbs','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000g", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000g", "", $row['DESCRIPTION']);
	    if($size=='250g'){
			$weight = 250;
		}elseif($size=='500g'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250g'){
				$weight = 250;
			}elseif($size=='500g'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }

    }
    
    /** WHOLE HERBS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(6);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Whole Herbs','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000g", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000g", "", $row['DESCRIPTION']);
	    if($size=='250g'){
			$weight = 250;
		}elseif($size=='500g'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250g'){
				$weight = 250;
			}elseif($size=='500g'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }

    }
    
    /** POWDERS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(7);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Powders','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000g", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000g", "", $row['DESCRIPTION']);
	    if($size=='250g'){
			$weight = 250;
		}elseif($size=='500g'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250g'){
				$weight = 250;
			}elseif($size=='500g'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }

    }
    
    /** POWDER BLENDS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(17);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Powder Blends','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000g", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000g", "", $row['DESCRIPTION']);
	    if($size=='250g'){
			$weight = 250;
		}elseif($size=='500g'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250g'){
				$weight = 250;
			}elseif($size=='500g'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }

    }
    
    /** ORGANIC **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(18);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Organic','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000g", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000g", "", $row['DESCRIPTION']);
	    if($size=='250g'){
			$weight = 250;
		}elseif($size=='500g'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250g'){
				$weight = 250;
			}elseif($size=='500g'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }

    }
    
    /** CAPSULES **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParentsCapsules();
    
	fputcsv($output, array('','','',''));
	fputcsv($output, array('Capsules','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000", "", $row['DESCRIPTION']);
	    if($size=='250'){
			$weight = 250;
		}elseif($size=='500'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,'1000',$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getCatalogueChildrenCapsules($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250g'){
				$weight = 250;
			}elseif($size=='500g'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }
	    
    }
    
    /** CREAMS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(11);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Creams','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000g", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000g", "", $row['DESCRIPTION']);
	    if($size=='250g'){
			$weight = 250;
		}elseif($size=='500g'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));

		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250g'){
				$weight = 250;
			}elseif($size=='500g'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }
    }
    
    /** FIXED OILS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(13);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Fixed Oils','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000ml", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000ml", "", $row['DESCRIPTION']);
	    if($size=='250ml'){
			$weight = 250;
		}elseif($size=='500ml'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));

		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250ml'){
				$weight = 250;
			}elseif($size=='500ml'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }
    }
    
    /** ESSSENTIAL OILS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(12);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Essential Oils','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000ml", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000ml", "", $row['DESCRIPTION']);
	    if($size=='250ml'){
			$weight = 250;
		}elseif($size=='500ml'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));

		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250ml'){
				$weight = 250;
			}elseif($size=='500ml'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }
    }
    
    /** WAXES AND GUMS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(15);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Waxes and Gums','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000g", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000g", "", $row['DESCRIPTION']);
	    if($size=='250g'){
			$weight = 250;
		}elseif($size=='500g'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));

		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250g'){
				$weight = 250;
			}elseif($size=='500g'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }
    }
    
    /** PACKAGING **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(14);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Packaging','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000g", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000g", "", $row['DESCRIPTION']);
	    if($size=='250g'){
			$weight = 250;
		}elseif($size=='500g'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));

		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250g'){
				$weight = 250;
			}elseif($size=='500g'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }
    }
    
    /** BEEVITAL **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(10);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('BeeVital','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000g", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000g", "", $row['DESCRIPTION']);
	    if($size=='250g'){
			$weight = 250;
		}elseif($size=='500g'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));

		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250g'){
				$weight = 250;
			}elseif($size=='500g'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }
    }
    
    /** SWEET CECILYS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(22);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Sweet Cecilys','Size','SKU','Price'));
    
    foreach($export as $row){
	    $handle = str_replace("-1000g", "", $row['WEB_CATEGORY_1']);
	    $parts = explode(" ", $row['DESCRIPTION']);
	    $size = end($parts);
	    $name = str_replace(" 1000g", "", $row['DESCRIPTION']);
	    if($size=='250g'){
			$weight = 250;
		}elseif($size=='500g'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));

		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
			$size = end($parts);
			if($size=='250g'){
				$weight = 250;
			}elseif($size=='500g'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }
    }
    
	exit();