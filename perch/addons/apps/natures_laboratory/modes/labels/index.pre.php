<?php
    
    $NaturesLaboratoryLabels = new Natures_Laboratory_Labels($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $labels = array();
    $labels = $NaturesLaboratoryLabels->getLabels();
    
    if($Form->submitted()) {
		//MAKE LABELS
		$postvars = array();
		foreach($labels as $Labels){
			array_push($postvars, 'batch_'.$Labels['batch']);
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
	    	$batchData = $NaturesLaboratoryLabels->getLabelData($parts[1]);
	    	
	    	// DATA FOR LABEL
	    	$productCode = $batchData['productCode'];
	    	$productData = $NaturesLaboratoryLabels->getProduct($productCode);
			
	    	$productName = $productData['productName'];
	    	$batch = $batchData['batch'];
	    	$bbe = $batchData['bbe'];
			$dates = explode("-",$batchData['bbe']);
			$bbe = "$dates[1]/$dates[0]";
			$size = $batchData['size'];
	    	
	    	$y = 1;
	
	    	while($y<=$batchData['quantity']){
		    	if($row>4){
			    	$row = 1;
			    	$pdf->AddPage();
			    }
			    if($column==2){
			    	$x = 114;
			    	$imgX = 78;
			    }else{
				    $x = 14;
				    $imgX = 180;
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
				$pdf->Cell(90,10,"$productData[productType] $productCode",0);
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY($x, $y2);
				$pdf->WriteHTML($productName);
				$pdf->SetFont('Arial','B',10);
				$pdf->SetXY($x, $y3);
				$pdf->Cell(90,10,"Batch: $batch  BBE: $bbe  $size",0);
				
				$codeContents = "https://natureslaboratory.co.uk/perch/addons/apps/natures_laboratory/products/go/?id=".$batch;
			    $fileName = 'qr_'.$batch.'.png';
			    QRcode::png($codeContents, $fileName);
			    $pdf->Image($fileName,$imgX,$imgY,-170);
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
    	
    	$pdf->Output();
    	
	}