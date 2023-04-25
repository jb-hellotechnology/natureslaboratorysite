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
    
    function exportData($export,$output,$name,$quantity){
	    
	    $NaturesLaboratoryShopify = new Natures_Laboratory_Shopifys($API); 
	    
	    fputcsv($output, array('','','',''));
	    fputcsv($output, array($name,'Size','SKU','Price'));
	    
	    foreach($export as $row){
		    $parts = explode(" ", $row['DESCRIPTION']);
		    $size = end($parts);
		    $name = str_replace(" ".$quantity, "", $row['DESCRIPTION']);
			$sku = $row['STOCK_CODE'];
			$parentStock = false;
			if($row['QTY_IN_STOCK']>0){
				$price = number_format($row['SALES_PRICE'],2);
				$parentStock = true;
			}else{
				$price = 'OUT OF STOCK';
			}
			
			$data = array($name,$size,$sku,$price);
	
			fputcsv($output, $data);
			
		    $children = $NaturesLaboratoryShopify->getChildren($row['STOCK_CODE']);
		    foreach($children as $row){
			    $parts = explode(" ", $row['DESCRIPTION']);
				$size = end($parts);
				
				if($row['QTY_IN_STOCK']>0 OR ($quantity=='1000g' AND $parentStock)){
					$price = number_format($row['SALES_PRICE'],2);
				}else{
					$price = 'OUT OF STOCK';
				}
				
				$data = array($name,$size,"$row[STOCK_CODE]",$price);
				fputcsv($output, $data);
		    }
		    
		    if($row['STOCK_CAT']=='2'){
		    	$organic = $NaturesLaboratoryShopify->getOrganic('1'.$sku);
		    }else{
			    $organic = $NaturesLaboratoryShopify->getOrganic($sku.'/ORG');
		    }
		    if($organic){
			    $parts = explode(" ", $organic['DESCRIPTION']);
			    $size = end($parts);
				$sku = $organic['STOCK_CODE'];
				$parentStock = false;
				if($row['QTY_IN_STOCK']>0){
					$price = number_format($organic['SALES_PRICE'],2);
					$parentStock = true;
				}else{
					$price = 'OUT OF STOCK';
				}
			    $data = array($name.' Organic',$size,$sku,$price);
				fputcsv($output, $data);
				
				$children = $NaturesLaboratoryShopify->getOrganicChildren($organic['STOCK_CODE']);
			    foreach($children as $child){
				    $parts = explode(" ", $child['DESCRIPTION']);
					$size = end($parts);
					
					if($row['QTY_IN_STOCK']>0 OR ($quantity=='1000g' AND $parentStock)){
						$price = number_format($child['SALES_PRICE'],2);
					}else{
						$price = 'OUT OF STOCK';
					}
					
					$data = array($name.' Organic',$size,"$child[STOCK_CODE]",$price);
					fputcsv($output, $data);
			    }
		    
		    }
	    }
    }
    
    header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=herbalapothecary.csv');
	
	$output = fopen( 'php://output', 'w' );
	
	ob_end_clean();
    
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
    
    fputcsv($output, array('','','',''));
    fputcsv($output, array('Packaging','Size','SKU','Price'));
    
    foreach($export as $row){
	    $name = $row['DESCRIPTION'];
		$size = '';
		
		if($row['QTY_IN_STOCK']>0){
			$price = number_format($row['SALES_PRICE'],2);
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
			$price = number_format($row['SALES_PRICE'],2);
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
			$price = number_format($row['SALES_PRICE'],2);
		}else{
			$price = 'OUT OF STOCK';
		}
		
		$data = array($name,$size,"$row[STOCK_CODE]",$price);

		fputcsv($output, $data);
    }
    
	exit();