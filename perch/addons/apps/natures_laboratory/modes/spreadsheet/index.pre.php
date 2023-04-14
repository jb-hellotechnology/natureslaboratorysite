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
    
    $export = $NaturesLaboratoryShopify->getParents(1,true,false);
    
    /** TINCTURES **/
    
    $export = $NaturesLaboratoryShopify->getParents(2,true,false);
    
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
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'OUT OF STOCK';
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",$price);

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
			
			if($row['QTY_IN_STOCK']>0){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'OUT OF STOCK';
			}
			
			$data = array($name,$size,"$row[STOCK_CODE]",chr(163).number_format($row['SALES_PRICE'],2));
			fputcsv($output, $data);
	    }
    }
    
    /** FLUID EXTRACTS **/
    
    $export = $NaturesLaboratoryShopify->getParents(4,true,false);
    
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
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'OUT OF STOCK';
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",$price);

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
			
			if($row['QTY_IN_STOCK']>0){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'OUT OF STOCK';
			}

			$data = array($name,$size,"$row[STOCK_CODE]",$price);
			fputcsv($output, $data);
	    }
    }
    
    
    /** CUT HERBS **/
    
    $export = $NaturesLaboratoryShopify->getParents(5,true,false);

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
		
		$parentStock = false;
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
			$parentStock = true;
		}else{
			$price = 'POA';
		}
		
		$data = array($name,$size,$row['STOCK_CODE'],$price);
		
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
			
			if($parentStock){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'POA';
			}
			
			$data = array($name,$size,$row['STOCK_CODE'],$price);
			fputcsv($output, $data);
	    }

    }
    
    /** WHOLE HERBS **/
    
    $export = $NaturesLaboratoryShopify->getParents(6,true,false);
    
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
		
		$parentStock = false;
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
			$parentStock = true;
		}else{
			$price = 'POA';
		}
		
		$data = array($name,$size,$row['STOCK_CODE'],$price);
		
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
			
			if($parentStock){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'POA';
			}
			
			$data = array($name,$size,$row['STOCK_CODE'],$price);
			fputcsv($output, $data);
	    }

    }
    
    /** POWDERS **/
    
    $export = $NaturesLaboratoryShopify->getParents(7,true,false);
    
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
		
		$parentStock = false;
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
			$parentStock = true;
		}else{
			$price = 'POA';
		}
		
		$data = array($name,$size,$row['STOCK_CODE'],$price);
		
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
			
			if($parentStock){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'POA';
			}
			
			$data = array($name,$size,$row['STOCK_CODE'],$price);
			fputcsv($output, $data);
	    }

    }
    
    /** POWDER BLENDS **/
    
    $export = $NaturesLaboratoryShopify->getParents(17,true,false);
    
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
		
		$parentStock = false;
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
			$parentStock = true;
		}else{
			$price = 'OUT OF STOCK';
		}
		
		$data = array($name,$size,$row['STOCK_CODE'],$price);
		
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
			
			if($parentStock){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'OUT OF STOCK';
			}
			
			$data = array($name,$size,$row['STOCK_CODE'],$price);
			fputcsv($output, $data);
	    }

    }
    
    /** ORGANIC **/
    
    $export = $NaturesLaboratoryShopify->getParents(18,true,false);
    
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
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'POA';
		}
		
		$data = array($name,$size,$row['STOCK_CODE'],$price);
		
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
			
			if($row['QTY_IN_STOCK']>0){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'POA';
			}
			
			$data = array($name,$size,$row['STOCK_CODE'],$price);
			fputcsv($output, $data);
	    }

    }
    
    /** CAPSULES **/
    
    $export = $NaturesLaboratoryShopify->getParentsCapsules(false);
    
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
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'POA';
		}
		
		$data = array($name,'1000',$row['STOCK_CODE'],$price);
		
		fputcsv($output, $data);
		
	    $children = $NaturesLaboratoryShopify->getChildrenCapsules($row['STOCK_CODE']);
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
			
			if($row['QTY_IN_STOCK']>0){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'POA';
			}
			
			$data = array($name,$size,$row['STOCK_CODE'],$price);
			fputcsv($output, $data);
	    }
	    
    }
    
    /** CREAMS **/
    
    $export = $NaturesLaboratoryShopify->getParents(11,true,false);
    
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
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'OUT OF STOCK';
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",$price);

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
			
			if($row['QTY_IN_STOCK']>0){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'OUT OF STOCK';
			}
			
			$data = array($name,$size,"$row[STOCK_CODE]",$price);
			fputcsv($output, $data);
	    }
    }
    
    /** FIXED OILS **/
    
    $export = $NaturesLaboratoryShopify->getParents(13,true,false);
    
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
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'OUT OF STOCK';
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",$price);

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
			
			if($row['QTY_IN_STOCK']>0){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'OUT OF STOCK';
			}
			
			$data = array($name,$size,"$row[STOCK_CODE]",$price);
			fputcsv($output, $data);
	    }
    }
    
    /** ESSSENTIAL OILS **/
    
    $export = $NaturesLaboratoryShopify->getParents(12,true,false);
    
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
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'OUT OF STOCK';
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",$price);

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
			
			if($row['QTY_IN_STOCK']>0){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'OUT OF STOCK';
			}
			
			$data = array($name,$size,"$row[STOCK_CODE]",$price);
			fputcsv($output, $data);
	    }
    }
    
    /** WAXES AND GUMS **/
    
    $export = $NaturesLaboratoryShopify->getParents(15,true,false);
    
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
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'OUT OF STOCK';
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",$price);

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
			
			if($row['QTY_IN_STOCK']>0){
				$price = chr(163).number_format($row['SALES_PRICE'],2);
			}else{
				$price = 'OUT OF STOCK';
			}
			
			$data = array($name,$size,"$row[STOCK_CODE]",$price);
			fputcsv($output, $data);
	    }
    }
    
    /** PACKAGING **/
    
    $export = $NaturesLaboratoryShopify->getParents(14,false,false);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Packaging','Size','SKU','Price'));
    
    foreach($export as $row){
	    $name = $row['DESCRIPTION'];
		$size = '';
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'OUT OF STOCK';
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",$price);

		fputcsv($output, $data);
    }
    
    /** BEEVITAL **/
    
    $export = $NaturesLaboratoryShopify->getParents(10,true,false);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('BeeVital','Size','SKU','Price'));
    
    foreach($export as $row){
	    $name = $row['DESCRIPTION'];
		$size = '';
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'OUT OF STOCK';
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",$price);

		fputcsv($output, $data);
    }
    
    /** SWEET CECILYS **/
    
    $export = $NaturesLaboratoryShopify->getParents(22,true,false);
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Sweet Cecilys','Size','SKU','Price'));
    
    foreach($export as $row){
	    $name = $row['DESCRIPTION'];
		$size = '';
		
		if($row['QTY_IN_STOCK']>0){
			$price = chr(163).number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'OUT OF STOCK';
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",$price);

		fputcsv($output, $data);
    }
    
	exit();