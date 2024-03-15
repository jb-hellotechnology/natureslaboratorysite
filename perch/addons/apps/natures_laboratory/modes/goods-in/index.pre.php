<?php
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
*/   
    if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
    
    $NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API); 
    $NaturesLaboratoryGoodsSuppliers = new Natures_Laboratory_Goods_Suppliers($API); 
    $NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Ins($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $goodsIn = array();
    $goodsIn = $NaturesLaboratoryGoodsIn->getGoodsIn($_GET['q']);
    
    if($Form->submitted()) {
	    
	    unlink('labels.zip');
    	
    	$batches = array();
	    foreach($_POST as $key=>$value){
			if(substr($key, 0, 6)=='batch_'){
				$parts = explode("_", $key);
				array_push($batches, $parts[1]);
			}
		}
		
		$files = array();
		
		foreach($batches as $id){
			
			$label = 1;
	    	
	    	$totalLabels = 0;
	    	
	    	$labelList = array();

	    	$batchData = $NaturesLaboratoryGoodsIn->getBatchData($id);
	    	$totalLabels = $totalLabels+$batchData['bags']+1;
	    	
	    	$dir = new DirectoryIterator('pngs/'.$batchData['natures_laboratory_goods_inID']);
			foreach ($dir as $fileinfo) {
			    if (!$fileinfo->isDot()) {
			        array_push($labelList,'pngs/'.$batchData['natures_laboratory_goods_inID'].'/'.$fileinfo->getFilename());
			    }
			}
			
			$tL = $totalLabels;
			$currentLabel = 0;
			$pageLabel = 1;
			
			$pdf = new FPDF('L', 'in', array(4,3));
	
			while($currentLabel<$totalLabels){
				$pdf->AddPage();
				$labelBg = $labelList[$currentLabel];
				$pdf->Image($labelBg,0,0,4,3);
				$pageLabel++;
				$currentLabel++;
			}
	
			$pdf->Output("F", "labels/small-labels-$id.pdf");
			
			array_push($files, "labels/small-labels-$id.pdf");
	    	
	    	$pdf = new FPDF('L', 'mm', array(101.6,76.2));
	
	    	$parts = explode('_',$id);
	    	$batchData = $NaturesLaboratoryGoodsIn->getBatchData($id);
	    	
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
	    	
	    	$x = 8;
	    	$y1 = 12;
		    $y2 = 30;
		    $y3 = 40;
		    $y4 = 50;
		    
		    $l = 0;
	
	    	while($y<=$batchData['bags']){
		    	$pdf->AddPage();
	
			    if($batchData['bagsList']<>''){
			    	$bags = explode(",",$batchData['bagsList']);
			    	$quantity = $bags[$l];
		    	}
			    
			    if($unit=='1000 CAPSULES'){
				    $quantity = '';
			    }
			    
				$pdf->SetFont('Arial','B',38);
				$pdf->SetXY($x, $y1);
				$pdf->Cell(90,5,"$productCode",0);
				
				$pdf->SetFont('Arial','B',28);
				$pdf->SetXY($x, $y2);
				$pdf->Cell(90,5,"BATCH: $batch",0);
				
				$pdf->SetFont('Arial','B',28);
				$pdf->SetXY($x, $y3);
				$pdf->Cell(90,5,"BBE: $bbe",0);
				
				$pdf->SetFont('Arial','B',28);
				$pdf->SetXY($x, $y4);
				$pdf->Cell(90,5,"WEIGHT: $quantity $unit",0);
				
				$y++;
				$l++;
					
			}
	    	
	    	$pdf->Output('F',"labels/big-labels-$id.pdf");
	    	
	    	array_push($files, "labels/big-labels-$id.pdf");
		}
		
		$zipname = 'labels.zip';
		$zip = new ZipArchive;
		$zip->open($zipname, ZipArchive::CREATE);
		foreach ($files as $file) {
		  $zip->addFile($file);
		}
		$zip->close();
		
		header('Content-Type: application/zip');
		header('Content-disposition: attachment; filename='.$zipname);
		header('Content-Length: ' . filesize($zipname));
		readfile($zipname);
		
		foreach($files as $file){ // iterate files
		  if(is_file($file)) {
		    unlink($file); // delete file
		  }
		}
    	
	}