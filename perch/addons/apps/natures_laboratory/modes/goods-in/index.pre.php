<?php
    
    $NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API); 
    $NaturesLaboratoryGoodsSuppliers = new Natures_Laboratory_Goods_Suppliers($API); 
    $NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $goodsIn = array();
    $goodsIn = $NaturesLaboratoryGoodsIn->getGoodsIn();
    
    if($Form->submitted()) {
		//MAKE LABELS
		$postvars = array();
		foreach($goodsIn as $Goods){
			array_push($postvars, 'batch_'.$Goods['ourBatch']);
		}   
    	$data = $Form->receive($postvars);   
    	
    	$label = 1;
		
		class PDF extends FPDF
		{
			// Page header
			function Header()
			{
			    $this->Image('../label.jpg',6,14,99.1,67.8);
			    $this->Image('../label.jpg',105.1,14,99.1,67.8);
			    $this->Image('../label.jpg',6,81.8,99.1,67.8);
			    $this->Image('../label.jpg',105.1,81.8,99.1,67.8);
			    $this->Image('../label.jpg',6,149.6,99.1,67.8);
			    $this->Image('../label.jpg',105.1,149.6,99.1,67.8);
			    $this->Image('../label.jpg',6,217.4,99.1,67.8);
			    $this->Image('../label.jpg',105.1,217.4,99.1,67.8);
			}
		}
		
		$pdf = new PDF();
		$pdf->AddPage();
		
		$row = 1;
	    $column = 1;
    	  
    	foreach($data as $key => $value){
	    	$parts = explode('_',$key);
	    	$batchData = $NaturesLaboratoryGoodsIn->getBatchData($parts[1]);
	    	
	    	// DATA FOR LABEL
	    	$productCode = $batchData['productCode'];
	    	$productData = $NaturesLaboratoryGoodsStock->getByCode($productCode);

	    	if($productData['category']==1){
		    	$categoryName = 'Unclassified';
	    	}elseif($productData['category']==2){
		    	$categoryName = 'Tinctures';
	    	}elseif($productData['category']==4){
		    	$categoryName = 'Fluid Extracts';
	    	}elseif($productData['category']==5){
		    	$categoryName = 'Cut Herbs';
	    	}elseif($productData['category']==6){
		    	$categoryName = 'Whole Herbs';
	    	}elseif($productData['category']==7){
		    	$categoryName = 'Powders';
	    	}elseif($productData['category']==8){
		    	$categoryName = 'Capsules';
	    	}elseif($productData['category']==9){
		    	$categoryName = 'Chinese';
	    	}elseif($productData['category']==10){
		    	$categoryName = 'BeeVital';
	    	}elseif($productData['category']==11){
		    	$categoryName = 'Creams';
	    	}elseif($productData['category']==12){
		    	$categoryName = 'Essential Oils';
	    	}elseif($productData['category']==13){
		    	$categoryName = 'Fixed Oils';
	    	}elseif($productData['category']==14){
		    	$categoryName = 'Packaging';
	    	}elseif($productData['category']==15){
		    	$categoryName = 'Gums';
	    	}elseif($productData['category']==16){
		    	$categoryName = 'Misc';
	    	}elseif($productData['category']==17){
		    	$categoryName = 'Detox';
	    	}elseif($productData['category']==18){
		    	$categoryName = 'Organics';
	    	}elseif($productData['category']==20){
		    	$categoryName = 'Teas';
	    	}elseif($productData['category']==21){
		    	$categoryName = 'Supplements';
	    	}elseif($productData['category']==22){
		    	$categoryName = "Sweet Cecily's";
	    	}elseif($productData['category']==40){
		    	$categoryName = 'Bespoke Blends';
	    	}elseif($productData['category']==999){
		    	$categoryName = 'Discontinued';
	    	}
	    	
	    	$productName = $batchData['productDescription'];
	    	$batch = $batchData['ourBatch'];
	    	$bbe = $batchData['bbe'];
	    	if($batchData['bags']>0){
	    		$quantity = $batchData['qty']/$batchData['bags'];
	    	}else{
		    	$quantity = $batchData['qty'];
	    	}
	    	$quantity = number_format($quantity,2);
	    	$unit = $batchData['unit'];
	    	
	    	$bbeParts = explode("-",$bbe);
		    $bbe = "$bbeParts[1]/$bbeParts[0]";
		    if($bbe == '01/1970'){
			    $bbe = 'N/A';
		    }
	    	
	    	
	    	$y = 1;
	
	    	while($y<=($batchData['bags']+1)){
		    	if($row>4){
			    	$row = 1;
			    	$pdf->AddPage();
			    }
			    if($column==2){
			    	$x = 114;
			    	$imgX = 90;
			    }else{
				    $x = 14;
				    $imgX = 190;
			    }
			    
			    $first = array(44,55,70);
			    $second = 70;
			    $third = 140;
			    $fourth = 210;
			    
			    if($row==1){
				    $imgY = 18;
				    $y1 = 40;
				    $y2 = 50;
				    $y3 = 55;
				    $y4 = 60;
			    }
			    
			    if($row==2){
				    $imgY = 86;
				    $y1 = 108;
				    $y2 = 118;
				    $y3 = 123;
				    $y4 = 128;
			    }
			    
			    if($row==3){
				    $imgY = 154;
				    $y1 = 176;
				    $y2 = 186;
				    $y3 = 191;
				    $y4 = 196;
			    }
			    
			    if($row==4){
				    $imgY = 221;
				    $y1 = 243;
				    $y2 = 253;
				    $y3 = 258;
				    $y4 = 263;
			    }
			    
			    $pdf->SetXY($x, $y1);
				$pdf->SetFont('Arial','B',14);
				$pdf->Cell(90,10,"$categoryName $productCode",0);
				$pdf->SetFont('Arial','B',8);
				$pdf->SetXY($x, $y2);
				$pdf->Cell(90,10,"$productName",0);
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY($x, $y3);
				$pdf->Cell(90,10,"Batch: $batch  BBE: $bbe  $quantity $unit",0);
				
				if($y == 1){
					$pdf->SetFont('Arial','B',12);
					$pdf->SetXY($x, $y4);
					$pdf->Cell(90,10,"SAMPLE",0);	
				}
				
				$codeContents = "https://natureslaboratory.co.uk/perch/addons/apps/natures_laboratory/goods-in/go/?id=".$batch;
			    $fileName = 'qr_'.$batch.'.png';
			    QRcode::png($codeContents, $fileName);
			    $pdf->Image($fileName,$imgX,$imgY,-180);
				unlink($fileName);
				
				$y++;
				
				$label++;
				if($column==1){
					$column = 2;
				}else{
					$column = 1;
					$row++;
				}
					
			}
				
    	}
    	
    	$pdf->Output('F','small-labels.pdf');
    	
    	$pdf = new FPDF();
		$pdf->AddPage();
		
		$row = 1;
	    $column = 1;
    	  
    	foreach($data as $key => $value){
	    	$parts = explode('_',$key);
	    	$batchData = $NaturesLaboratoryGoodsIn->getBatchData($parts[1]);
	    	
	    	// DATA FOR LABEL
	    	$productCode = $batchData['productCode'];
	    	$productData = $NaturesLaboratoryGoodsStock->getByCode($productCode);

	    	$batch = $batchData['ourBatch'];
	    	$bbe = $batchData['bbe'];
	    	if($batchData['bags']>0){
	    		$quantity = $batchData['qty']/$batchData['bags'];
	    	}else{
		    	$quantity = $batchData['qty'];
	    	}
	    	$quantity = number_format($quantity,2);
	    	$unit = $batchData['unit'];
	    	
	    	$bbeParts = explode("-",$bbe);
		    $bbe = "$bbeParts[1]/$bbeParts[0]";
		    if($bbe == '01/1970'){
			    $bbe = 'N/A';
		    }
	    	
	    	
	    	$y = 1;
	
	    	while($y<=$batchData['bags']){
		    	if($row>4){
			    	$row = 1;
			    	$pdf->AddPage();
			    }
			    if($column==2){
			    	$x = 114;
			    }else{
				    $x = 14;
			    }
			    
			    $first = array(44,55,70);
			    $second = 70;
			    $third = 140;
			    $fourth = 210;
			    
			    if($row==1){
				    $y1 = 30;
				    $y2 = 40;
				    $y3 = 50;
				    $y4 = 58;
			    }
			    
			    if($row==2){
				    $y1 = 108;
				    $y2 = 118;
				    $y3 = 128;
				    $y4 = 136;
			    }
			    
			    if($row==3){
				    $y1 = 171;
				    $y2 = 181;
				    $y3 = 191;
				    $y4 = 199;
			    }
			    
			    if($row==4){
				    $y1 = 233;
				    $y2 = 243;
				    $y3 = 253;
				    $y4 = 261;
			    }
			    
			    $pdf->SetXY($x, $y1);
				$pdf->SetFont('Arial','B',32);
				$pdf->Cell(90,10,"$productCode",0);
				$pdf->SetFont('Arial','B',28);
				$pdf->SetXY($x, $y2);
				$pdf->Cell(90,10,"BATCH: $batch",0);
				$pdf->SetFont('Arial','B',28);
				$pdf->SetXY($x, $y3);
				$pdf->Cell(90,10,"BBE: $bbe",0);
				$pdf->SetFont('Arial','B',20);
				$pdf->SetXY($x, $y4);
				$pdf->Cell(90,10,"WEIGHT: $quantity $unit",0);
				
				$y++;
				
				$label++;
				if($column==1){
					$column = 2;
				}else{
					$column = 1;
					$row++;
				}
					
			}
				
    	}
    	
  	
    	$pdf->Output('F','big-labels.pdf');

    	$files = array('small-labels.pdf','big-labels.pdf');
		$zipname = 'file.zip';
		$zip = new ZipArchive;
		$zip->open($zipname, ZipArchive::CREATE);
		foreach ($files as $file) {
		  $zip->addFile($file);
		}
		$zip->close();
		
		header('Content-Type: application/zip');
		header('Content-disposition: attachment; filename='.$zipname);
		header('Content-Length: ' . filesize($zipname));
		ob_end_clean();
		readfile($zipname);
    	
	}