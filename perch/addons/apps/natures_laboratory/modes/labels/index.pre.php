<?php
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryLabels = new Natures_Laboratory_Labels($API); 
    $NaturesLaboratoryLabelsProducts = new Natures_Laboratory_Labels_Products($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $labels = array();
    $labels = $NaturesLaboratoryLabels->getLabels();
    
    if($Form->submitted()) {
		//MAKE LABELS
		$postvars = array('start','task');
		$data = $Form->receive($postvars); 
		
		if($data['task']=='labels'){
		
			foreach($labels as $Labels){
				array_push($postvars, 'batch_'.$Labels['natures_laboratory_labelID']);
			}   
	
	    	$data = $Form->receive($postvars); 
	    	
	    	$start = $data['start']; 
	    	
	    	$label = 1;
	    	
	    	$totalLabels = 0;
	    	  
	    	foreach($data as $key => $value){
	
		    	$parts = explode('_',$key);
		    	$batchData = $NaturesLaboratoryLabels->getLabelData($parts[1]);
		    	$totalLabels = $totalLabels+$batchData['quantity'];
		    	
			}
			
			$productData = $NaturesLaboratoryLabelsProducts->getProduct($batchData['productCode']);
	    	if($productData['productRange']=='' AND $productData['organic']!=='organic'){
		    	$labelBg = '../label.jpg';
	    	}elseif($productData['productRange']==1){
		    	$labelBg = '../label_ruskin.jpg';
		    	$ruskin = 1;
	    	}elseif($productData['organic']=='organic'){
		    	$labelBg = '../label_organic.jpg';
		    	$organic = 1;
	    	}
			
			$tL = $totalLabels;
			$totalLabels = $totalLabels+$start-1;
				
			class PDF extends FPDF
			{
				// Page header
				function Header()
				{
					global $totalLabels;
					global $tL;
					$pages = ceil($totalLabels/8);
					$page = $this->PageNo();
					global $start;
					global $labelBg;
					
					$remainder = $totalLabels % 8;
					
					$labelsOnPage = $page*8;
					if($labelsOnPage>$totalLabels){
						$labelsOnPage = $totalLabels;
					}
	
					if($page == $pages AND $pages>1){
	
						$totalPossible = 8*$pages;
						$remainder = $totalPossible-$totalLabels;
	
						if($remainder == 0){
							
							$this->Image($labelBg,5,14,99.1,67.8);
						    $this->Image($labelBg,105.1,14,99.1,67.8);
						    $this->Image($labelBg,5,81.8,99.1,67.8);
						    $this->Image($labelBg,105.1,81.8,99.1,67.8);
						    $this->Image($labelBg,5,149.6,99.1,67.8);
						    $this->Image($labelBg,105.1,149.6,99.1,67.8);
						    $this->Image($labelBg,5,217.4,99.1,67.8);
						    $this->Image($labelBg,105.1,217.4,99.1,67.8);
							
						}elseif($remainder == 1){
							
							$this->Image($labelBg,5,14,99.1,67.8);
						    $this->Image($labelBg,105.1,14,99.1,67.8);
						    $this->Image($labelBg,5,81.8,99.1,67.8);
						    $this->Image($labelBg,105.1,81.8,99.1,67.8);
						    $this->Image($labelBg,5,149.6,99.1,67.8);
						    $this->Image($labelBg,105.1,149.6,99.1,67.8);
						    $this->Image($labelBg,5,217.4,99.1,67.8);
							
						}elseif($remainder == 2){
							
							$this->Image($labelBg,5,14,99.1,67.8);
						    $this->Image($labelBg,105.1,14,99.1,67.8);
						    $this->Image($labelBg,5,81.8,99.1,67.8);
						    $this->Image($labelBg,105.1,81.8,99.1,67.8);
						    $this->Image($labelBg,5,149.6,99.1,67.8);
						    $this->Image($labelBg,105.1,149.6,99.1,67.8);
						
						}elseif($remainder == 3){
							
							$this->Image($labelBg,5,14,99.1,67.8);
						    $this->Image($labelBg,105.1,14,99.1,67.8);
						    $this->Image($labelBg,5,81.8,99.1,67.8);
						    $this->Image($labelBg,105.1,81.8,99.1,67.8);
						    $this->Image($labelBg,5,149.6,99.1,67.8);
							
						}elseif($remainder == 4){
							
							$this->Image($labelBg,5,14,99.1,67.8);
						    $this->Image($labelBg,105.1,14,99.1,67.8);
						    $this->Image($labelBg,5,81.8,99.1,67.8);
						    $this->Image($labelBg,105.1,81.8,99.1,67.8);
							
						}elseif($remainder == 5){
							
							$this->Image($labelBg,5,14,99.1,67.8);
						    $this->Image($labelBg,105.1,14,99.1,67.8);
						    $this->Image($labelBg,5,81.8,99.1,67.8);
							
						}elseif($remainder == 6){
							
							$this->Image($labelBg,6,14,99.1,67.8);
						    $this->Image($labelBg,105.1,14,99.1,67.8);
							
						}elseif($remainder == 7){
							
							$this->Image($labelBg,6,14,99.1,67.8);
							
						}
					
					}else if($page == 1){
					
						if($start==1){
						    if($tL>0){$this->Image($labelBg,5,14,99.1,67.8);}
						    if($tL>1){$this->Image($labelBg,105.1,14,99.1,67.8);}
						    if($tL>2){$this->Image($labelBg,5,81.8,99.1,67.8);}
						    if($tL>3){$this->Image($labelBg,105.1,81.8,99.1,67.8);}
						    if($tL>4){$this->Image($labelBg,5,149.6,99.1,67.8);}
						    if($tL>5){$this->Image($labelBg,105.1,149.6,99.1,67.8);}
						    if($tL>6){$this->Image($labelBg,5,217.4,99.1,67.8);}
						    if($tL>7){$this->Image($labelBg,105.1,217.4,99.1,67.8);}
						}elseif($start==2){
						    if($tL>0){$this->Image($labelBg,105.1,14,99.1,67.8);}
						    if($tL>1){$this->Image($labelBg,5,81.8,99.1,67.8);}
						    if($tL>2){$this->Image($labelBg,105.1,81.8,99.1,67.8);}
						    if($tL>3){$this->Image($labelBg,5,149.6,99.1,67.8);}
						    if($tL>4){$this->Image($labelBg,105.1,149.6,99.1,67.8);}
						    if($tL>5){$this->Image($labelBg,5,217.4,99.1,67.8);}
						    if($tL>6){$this->Image($labelBg,105.1,217.4,99.1,67.8);}
						}elseif($start==3){
						    if($tL>0){$this->Image($labelBg,5,81.8,99.1,67.8);}
						    if($tL>1){$this->Image($labelBg,105.1,81.8,99.1,67.8);}
						    if($tL>2){$this->Image($labelBg,5,149.6,99.1,67.8);}
						    if($tL>3){$this->Image($labelBg,105.1,149.6,99.1,67.8);}
						    if($tL>4){$this->Image($labelBg,5,217.4,99.1,67.8);}
						    if($tL>5){$this->Image($labelBg,105.1,217.4,99.1,67.8);}
						}elseif($start==4){
						    if($tL>0){$this->Image($labelBg,105.1,81.8,99.1,67.8);}
						    if($tL>1){$this->Image($labelBg,5,149.6,99.1,67.8);}
						    if($tL>2){$this->Image($labelBg,105.1,149.6,99.1,67.8);}
						    if($tL>3){$this->Image($labelBg,5,217.4,99.1,67.8);}
						    if($tL>4){$this->Image($labelBg,105.1,217.4,99.1,67.8);}
						}elseif($start==5){
						    if($tL>0){$this->Image($labelBg,5,149.6,99.1,67.8);}
						    if($tL>1){$this->Image($labelBg,105.1,149.6,99.1,67.8);}
						    if($tL>2){$this->Image($labelBg,5,217.4,99.1,67.8);}
						    if($tL>3){$this->Image($labelBg,105.1,217.4,99.1,67.8);}
						}elseif($start==6){
						    if($tL>0){$this->Image($labelBg,105.1,149.6,99.1,67.8);}
						    if($tL>1){$this->Image($labelBg,5,217.4,99.1,67.8);}
						    if($tL>2){$this->Image($labelBg,105.1,217.4,99.1,67.8);}
						}elseif($start==7){
						    if($tL>0){$this->Image($labelBg,5,217.4,99.1,67.8);}
		 				    if($tL>1){$this->Image($labelBg,105.1,217.4,99.1,67.8);}
						}elseif($start==8){
						    if($tL>0){$this->Image($labelBg,105.1,217.4,99.1,67.8);}
						}
				    
				    }else{
					    
					    $this->Image($labelBg,6,14,99.1,67.8);
					    $this->Image($labelBg,105.1,14,99.1,67.8);
					    $this->Image($labelBg,6,81.8,99.1,67.8);
					    $this->Image($labelBg,105.1,81.8,99.1,67.8);
					    $this->Image($labelBg,6,149.6,99.1,67.8);
					    $this->Image($labelBg,105.1,149.6,99.1,67.8);
					    $this->Image($labelBg,6,217.4,99.1,67.8);
					    $this->Image($labelBg,105.1,217.4,99.1,67.8);
					    
				    }
				}
				
				function WriteHTML($html)
				{
				    // HTML parser
				    $html = str_replace("\n",' ',$html);
				    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
				    foreach($a as $i=>$e)
				    {
				        if($i%2==0)
				        {
				            // Text
				            if($this->HREF)
				                $this->PutLink($this->HREF,$e);
				            else
				                $this->Write(5,$e);
				        }
				        else
				        {
				            // Tag
				            if($e[0]=='/')
				                $this->CloseTag(strtoupper(substr($e,1)));
				            else
				            {
				                // Extract attributes
				                $a2 = explode(' ',$e);
				                $tag = strtoupper(array_shift($a2));
				                $attr = array();
				                foreach($a2 as $v)
				                {
				                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
				                        $attr[strtoupper($a3[1])] = $a3[2];
				                }
				                $this->OpenTag($tag,$attr);
				            }
				        }
				    }
				}
	
			}
			
			$pdf = new PDF();
			$pdf->AddPage();
			$pdf->SetMargins(0,0,0);
			$pdf->SetAutoPageBreak(false,0);
			
			if($start==1){
				$row = 1;
			    $column = 1;
		    }elseif($start==2){
			    $row = 1;
			    $column = 2;
		    }elseif($start==3){
			    $row = 2;
			    $column = 1;
		    }elseif($start==4){
			    $row = 2;
			    $column = 2;
		    }elseif($start==5){
			    $row = 3;
			    $column = 1;
		    }elseif($start==6){
			    $row = 3;
			    $column = 2;
		    }elseif($start==7){
			    $row = 4;
			    $column = 1;
		    }elseif($start==8){
			    $row = 4;
			    $column = 2;
		    }
		    
		    if($ruskin==1){
			
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
					    	$x = 106;
					    	$imgX = 144;
					    	$imgX2 = 152;
					    }else{
						    $x = 6;
						    $imgX = 44;
						    $imgX2 = 65;
					    }
					    
					    $first = array(44,55,70);
					    $second = 70;
					    $third = 140;
					    $fourth = 210;
					    
					    if($row==1){
						    $imgY = 16;
						    $imgY2 = 65;
						    $y1 = 37;
						    $y2 = 48;
						    $y3 = 65;
						    $y4 = 74;
					    }
					    
					    if($row==2){
						    $imgY = 83;
						    $imgY2 = 116;
						    $y1 = 105;
						    $y2 = 116;
						    $y3 = 132;
						    $y4 = 142;
					    }
					    
					    if($row==3){
						    $imgY = 151;
						    $imgY2 = 183;
						    $y1 = 172;
						    $y2 = 183;
						    $y3 = 201;
						    $y4 = 210;
					    }
					    
					    if($row==4){
						    $imgY = 218;
							$imgY2 = 251;
						    $y1 = 240;
						    $y2 = 251;
						    $y3 = 268;
						    $y4 = 278;
					    }
					    
					    $pdf->SetTextColor(0,76,117);
					    
					    $pdf->SetXY($x, $y1);
						$pdf->SetFont('Arial','B',14);
						$pdf->Cell(90,10,"$productData[productType]   $productCode",0);
						$pdf->SetFont('Arial','B',10);
						$pdf->SetXY($x, $y2);
						$pdf->MultiCell(60, 4, $productName, 0, "L");
						$pdf->SetXY($x, $y3);
						$pdf->SetFont('Arial','B',5);
						$pdf->MultiCell(60,2,"$productData[notes]",0);
						$pdf->SetFont('Arial','B',10);
						$pdf->SetXY($x, $y4);
						$pdf->Cell(90,2,"$batch        $bbe     $size",0);
						
						if($productData['productType']<>''){
						
							$codeContents = "https://natureslaboratory.co.uk/perch/addons/apps/natures_laboratory/products/go/?id=".$batch."&size=".$size."&bbe=".$bbe;
						    $fileName = 'qr_'.str_replace("/","-",$batch).'.png';
						    QRcode::png($codeContents, $fileName);
						    $pdf->Image($fileName,$imgX,$imgY,-200);
							unlink($fileName);
							
						}
						
						if($productData['productType']=='Capsules' || $productData['productType']=='Tincture' || $productData['productType']=='Fluid Extract'){
							
							$pdf->Image('../herbmark.jpg',$imgX2,$imgY2,-1050);
							
						}
						
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
			
			}else{
	    	
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
					    	$x = 113;
					    	$imgX = 182;
					    	$imgX2 = 170;
					    }else{
						    $x = 14;
						    $imgX = 82;
						    $imgX2 = 70;
					    }
					    
					    $first = array(44,55,70);
					    $second = 70;
					    $third = 140;
					    $fourth = 210;
					    
					    if($column==1){
						    $rectX = 5;
					    }else{
						    $rectX = 105;
					    }
					    
					    if($row==1){
						    $imgY = 18;
						    $imgY2 = 20;
						    $y1 = 40;
						    $y2 = 51;
						    $y3 = 62;
						    $y4 = 72;
						    $rectY = 40;
					    }
					    
					    if($row==2){
						    $imgY = 86;
						    $imgY2 = 88;
						    $y1 = 108;
						    $y2 = 119;
						    $y3 = 130;
						    $y4 = 140;
						    $rectY = 107.5;
					    }
					    
					    if($row==3){
						    $imgY = 154;
						    $imgY2 = 156;
						    $y1 = 176;
						    $y2 = 187;
						    $y3 = 199;
						    $y4 = 208;
						    $rectY = 175.5;
					    }
					    
					    if($row==4){
						    $imgY = 221;
							$imgY2 = 223;
						    $y1 = 243;
						    $y2 = 254;
						    $y3 = 266;
						    $y4 = 276;
						    $rectY = 243;
					    }
					    
					    $pdf->SetXY($x, $y1);
						$pdf->SetFont('Arial','B',14);
						
						if($productData['restriction']=='allergen'){
					    	$pdf->SetFillColor(244, 141, 2);
					    	$pdf->SetTextColor(255, 255, 255);
					    	$pdf->Rect($rectX,$rectY,70,10,'F');
				    	}elseif($productData['restriction']=='poison'){
					    	$pdf->SetFillColor(196, 30, 58);
					    	$pdf->SetTextColor(255, 255, 255);
					    	$pdf->Rect($rectX,$rectY,70,10,'F');
				    	}else{
					    	$pdf->SetTextColor(0, 0, 0);
				    	}
						
						$pdf->Cell(90,10,"$productData[productType]   $productCode",0);
						$pdf->SetTextColor(0, 0, 0);
						$pdf->SetFont('Arial','B',10);
						$pdf->SetXY($x, $y2);
						$pdf->MultiCell(60, 4, $productName, 0, "L");
						$pdf->SetXY($x, $y3);
						$pdf->SetFont('Arial','B',5);
						$pdf->MultiCell(70,2,"$productData[notes]",0);
						$pdf->SetFont('Arial','B',10);
						$pdf->SetXY($x, $y4);
						$pdf->Cell(90,2,"Batch: $batch  BBE: $bbe  $size",0);
						
						if($productData['productType']<>''){
						
							$codeContents = "https://natureslaboratory.co.uk/perch/addons/apps/natures_laboratory/products/go/?id=".$batch."&size=".$size."&bbe=".$bbe;
						    $fileName = 'qr_'.str_replace("/","-",$batch).'.png';
						    QRcode::png($codeContents, $fileName);
						    $pdf->Image($fileName,$imgX,$imgY,-180);
							unlink($fileName);
							
						}
						
						if($productData['productType']=='Capsules' || $productData['productType']=='Tincture' || $productData['productType']=='Fluid Extract'){
							
							$pdf->Image('../herbmark.jpg',$imgX2,$imgY2,-950);
							
						}
						
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
					
	    	}
	    	
	    	$pdf->Output();
	    	ob_end_clean();
	    
	    }elseif($data['task']=='delete'){
		    
		    foreach($labels as $Labels){
				array_push($postvars, 'batch_'.$Labels['natures_laboratory_labelID']);
			}   
	
	    	$data = $Form->receive($postvars);
		 	foreach($data as $key => $value){
	
		    	$parts = explode('_',$key);
		    	$batchData = $NaturesLaboratoryLabels->getLabelData($parts[1]);
		    	$labelsID = $batchData['natures_laboratory_labelID'];  
				$Labels = $NaturesLaboratoryLabels->deleteLabel($labelsID);
		    	
			}   
			
			$labels = $NaturesLaboratoryLabels->getLabels();
			
	    }
    	
	}