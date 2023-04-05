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
    
    $export = array();
    
    class PDF extends FPDF
	{
		// Page header
		function Header()
		{
			$this->SetFillColor(235,243,243);
			$this->Rect(0,0,154,216,'F');
		    // Logo
		    //$this->Image('logo.png',10,6,30);
		    $this->SetFont('Helvetica','',7);
		    // Move to the right
		    $this->Cell(53);
		    // Title
		    $this->Cell(0,0,'Herbal Apothecary',0,0,'L');
		    // Line break
		    $this->Ln(6);
		}
		
		// Page footer
		function Footer()
		{
		    // Position at 1.5 cm from bottom
		    $this->SetY(-15);
		    // Arial italic 8
		    $this->SetFont('Helvetica','I',7);
		    // Page number
		    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
		}
		
		function LoadData($string)
		{
		    // Read file lines
		    $lines = explode(";",$string);
		    $data = array();
		    foreach($lines as $line)
		        $data[] = explode(',',trim($line));
		    return $data;
		}
		
		// Fancy Table
		function FancyTable($header, $data)
		{
		    // Colors, line width and bold font
		    $this->SetFillColor(1,139,134);
		    $this->SetTextColor(255);
		    $this->SetDrawColor(72,72,72);
		    $this->SetLineWidth(.3);
		    $this->SetFont('','B', 8);
		    // Header
		    $w = array(42, 42, 44);
		    for($i=0;$i<count($header);$i++)
		        $this->Cell($w[$i],5,$header[$i],1,0,'L',true);
		    $this->Ln();
		    // Color and font restoration
		    $this->SetFillColor(255,255,255);
		    $this->SetTextColor(20,20,20);
		    $this->SetFont('');
		    // Data
		    $fill = true;
		    foreach($data as $row)
		    {
		        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
		        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
		        $this->Cell($w[2],6,$row[2],'LR',0,'R',$fill);
		        $this->Ln();
		        $this->SetFillColor(255,255,255);
		    }
		    // Closing line
		    $this->Cell(array_sum($w),0,'','T');
		}
	}
	
	// Instanciation of inherited class
	$pdf = new PDF('P', 'mm', array(154,216));
	$pdf->setMargins('13','13','13');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFillColor(235,243,243);
    $pdf->Rect(0,0,154,216,'F');
	$pdf->SetFont('Helvetica','',7);
	for($i=1;$i<=40;$i++){
	    
	}
	
	$pdf->SetFont('HELVETICA','B',30);
	$pdf->SetTextColor(1,139,134);
	$pdf->Cell(0,120,'Herbal Apothecary',0,1);
	$pdf->SetFont('HELVETICA','',16);
	$pdf->Cell(0,0,'Draft Catalogue - '.date('d/m/Y'),0,1);
    $pdf->AddPage();
    
     /** CHEMICALS **/
    
    $export = $NaturesLaboratoryShopify->getParents(1);
    
    /** TINCTURES **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(2);
    
	$pdf->SetFont('HELVETICA','B',30);
	$pdf->SetTextColor(1,139,134);
	$pdf->Cell(0,160,'TINCTURES',0,1);
    $pdf->AddPage();
    
    $pdf->SetFillColor(235,243,243);
    $pdf->Rect(0,0,154,216,'F');
    
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
		
		$data = array();
		$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		$pdf->SetTextColor(1,139,134);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(0,10,$name,0,1);
		$header = array('Size','SKU','Price');
		
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
			$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
	    }
	    $pdf->FancyTable($header,$data);
	    $pdf->Ln(4);
    }
    
    /** FLUID EXTRACTS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(4);
    
	$pdf->SetFont('HELVETICA','B',30);
	$pdf->SetTextColor(1,139,134);
	$pdf->Cell(0,160,'FLUID EXTRACTS',0,1);
    $pdf->AddPage();
    
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
		
		$data = array();
		$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		$pdf->SetTextColor(1,139,134);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(0,10,$name,0,1);
		$header = array('Size','SKU','Price');
		
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
			$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
	    }
	    $pdf->FancyTable($header,$data);
	    $pdf->Ln(10);
    }
    
    /** CUT HERBS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(5);
    
	$pdf->SetFont('HELVETICA','B',30);
	$pdf->SetTextColor(1,139,134);
	$pdf->Cell(0,160,'CUT HERBS',0,1);
    $pdf->AddPage();
    
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
		
		$data = array();
		$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		$pdf->SetTextColor(1,139,134);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(0,10,$name,0,1);
		$header = array('Size','SKU','Price');
		
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
			$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
	    }
	    $pdf->FancyTable($header,$data);
	    $pdf->Ln(10);
    }
    
    /** WHOLE HERBS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(6);
    
	$pdf->SetFont('HELVETICA','B',30);
	$pdf->SetTextColor(1,139,134);
	$pdf->Cell(0,160,'WHOLE HERBS',0,1);
    $pdf->AddPage();
    
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
		
		$data = array();
		$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		$pdf->SetTextColor(1,139,134);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(0,10,$name,0,1);
		$header = array('Size','SKU','Price');
		
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
			$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
	    }
	    $pdf->FancyTable($header,$data);
	    $pdf->Ln(10);
    }
    
    /** POWDERS **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParents(7);
    
	$pdf->SetFont('HELVETICA','B',30);
	$pdf->SetTextColor(1,139,134);
	$pdf->Cell(0,160,'POWDERS',0,1);
    $pdf->AddPage();
    
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
		
		$data = array();
		$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		$pdf->SetTextColor(1,139,134);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(0,10,$name,0,1);
		$header = array('Size','SKU','Price');
		
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
			$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
	    }
	    $pdf->FancyTable($header,$data);
	    $pdf->Ln(10);
    }
    
    /** CAPSULES **/
    
    $export = $NaturesLaboratoryShopify->getCatalogueParentsCapsules();
    
	$pdf->SetFont('HELVETICA','B',30);
	$pdf->SetTextColor(1,139,134);
	$pdf->Cell(0,160,'CAPSULES',0,1);
    $pdf->AddPage();
    
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
		
		$data = array();
		$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
		
		$pdf->SetTextColor(1,139,134);
		$pdf->SetFont('Helvetica','B',10);
		$pdf->Cell(0,10,$name,0,1);
		$header = array('Size','SKU','Price');
		
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
			$data[] = array($size,$row['STOCK_CODE'],chr(163).number_format($row['SALES_PRICE'],2));
	    }
	    $pdf->FancyTable($header,$data);
	    $pdf->Ln(10);
    }

    $pdf->Output();