<?php
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);  
*/  
    if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
    
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
    	
    	$totalLabels = 0;
    	
    	$labelList = array();
	    	  
    	foreach($data as $key => $value){

	    	$parts = explode('_',$key);
	    	$batchData = $NaturesLaboratoryGoodsIn->getBatchData($parts[1]);
	    	$totalLabels = $totalLabels+$batchData['bags']+1;
	    	
	    	$dir = new DirectoryIterator('pngs/'.$batchData['natures_laboratory_goods_inID']);
			foreach ($dir as $fileinfo) {
			    if (!$fileinfo->isDot()) {
			        array_push($labelList,'pngs/'.$batchData['natures_laboratory_goods_inID'].'/'.$fileinfo->getFilename());
			    }
			}
	    	
		}
		
		$tL = $totalLabels;
		$currentLabel = 0;
		$pageLabel = 1;
		
		$pdf = new FPDF();
		$pdf->AddPage();

		while($currentLabel<$totalLabels){
			$labelBg = $labelList[$currentLabel];
			if($pageLabel==1){
				$pdf->Image($labelBg,5,14,99.1,67.8);
			}elseif($pageLabel==2){
				$pdf->Image($labelBg,105.1,14,99.1,67.8);
			}elseif($pageLabel==3){
				$pdf->Image($labelBg,5,81.8,99.1,67.8);
			}elseif($pageLabel==4){
				$pdf->Image($labelBg,105.1,81.8,99.1,67.8);
			}elseif($pageLabel==5){
				$pdf->Image($labelBg,5,149.6,99.1,67.8);
			}elseif($pageLabel==6){
				$pdf->Image($labelBg,105.1,149.6,99.1,67.8);
			}elseif($pageLabel==7){
				$pdf->Image($labelBg,5,217.4,99.1,67.8);
			}elseif($pageLabel==8){
				$pdf->Image($labelBg,105.1,217.4,99.1,67.8);
			}
			$pageLabel++;
			$currentLabel++;
			if($pageLabel==9){
				$pdf->AddPage();
				$pageLabel = 1;
			}
		}

		$pdf->Output("F", "small-labels.pdf");
    	
    	$pdf = new FPDF();
		$pdf->AddPage();
		
		$row = 1;
	    $column = 1;
	    
	    $l = 0;
    	  
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
			    
			    if($batchData['bagsList']<>''){
			    	$bags = explode(",",$batchData['bagsList']);
			    	$quantity = $bags[$l];
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
			    
			    if($unit=='1000 CAPSULES'){
				    $quantity = '';
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
				
				$l++;
					
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