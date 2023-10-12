<?php
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryProduction = new Natures_Laboratory_Productions($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $production = array();
    $production = $NaturesLaboratoryProduction->getCompleted();
    
    $task = $NaturesLaboratoryProduction->find($_GET['id'], true);
    
    if($_GET['id']){
    
	    if($Form->submitted()) {
	    
	        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
	        $postvars = array('dateAddedToSage_day', 'dateAddedToSage_month', 'dateAddedToSage_year', 'labelCheck', 'qcCheck', 'addedToSageBy');	   
	    	$data = $Form->receive($postvars);     
	
			$data['dateAddedToSage'] = "$data[dateAddedToSage_year]-$data[dateAddedToSage_month]-$data[dateAddedToSage_day]";
	    	unset($data['dateAddedToSage_year']);
	    	unset($data['dateAddedToSage_month']);
	    	unset($data['dateAddedToSage_day']);
	
	        $new_schedule = $task->update($data);

	        $message = $HTML->success_message('Successfully updated.', '<a href="'.$API->app_path().'/production/completed/">', '</a>');
	        
	    }
    
    }else{
	    
		if($Form->submitted()) {
	    
	    	if($_POST['download']){
		    	$parts = explode("_", $_POST['download']);
		    	$process = $parts[1];
		    	
		    	if($parts[0]=='wpo'){
		    		//DOWNLOAD WPO	
		    		
		    		class PDF extends FPDF
					{
						// Page header
						function Header()
						{
						    
						}
						
						function Footer()
						{
						    $this->SetY(-24);
						    $this->SetY(-17);$this->SetX(10);
						    $this->SetFont('Arial','',6);
						    $this->Cell(0,3,"For Internal Use Only",0,1,'L');
						    $this->SetY(-14);$this->SetX(10);
							$this->Cell(0,3,"Record Produced at ". date('H:i:s d/m/Y'),0,1,'L');
						    
						}
						
						protected $B = 0;
						protected $I = 0;
						protected $U = 0;
						protected $HREF = '';
						
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
						
						function OpenTag($tag, $attr)
						{
						    // Opening tag
						    if($tag=='B' || $tag=='I' || $tag=='U')
						        $this->SetStyle($tag,true);
						    if($tag=='A')
						        $this->HREF = $attr['HREF'];
						    if($tag=='BR')
						        $this->Ln(5);
						}
						
						function CloseTag($tag)
						{
						    // Closing tag
						    if($tag=='B' || $tag=='I' || $tag=='U')
						        $this->SetStyle($tag,false);
						    if($tag=='A')
						        $this->HREF = '';
						}
						
						function SetStyle($tag, $enable)
						{
						    // Modify style and select corresponding font
						    $this->$tag += ($enable ? 1 : -1);
						    $style = '';
						    foreach(array('B', 'I', 'U') as $s)
						    {
						        if($this->$s>0)
						            $style .= $s;
						    }
						    $this->SetFont('',$style);
						}
						
						function PutLink($URL, $txt)
						{
						    // Put a hyperlink
						    $this->SetTextColor(0,0,255);
						    $this->SetStyle('U',true);
						    $this->Write(5,$txt,$URL);
						    $this->SetStyle('U',false);
						    $this->SetTextColor(0);
						}
						
						function BasicTable($header, $data)
						{
						    // Colors, line width and bold font
						    $this->SetFillColor(62,111,94);
						    $this->SetTextColor(255);
						    $this->SetDrawColor(0,0,0);
						    $this->SetLineWidth(.3);
						    $this->SetFont('','B');
						    // Header
						    $w = array(60, 60, 60);
						    for($i=0;$i<count($header);$i++)
						        $this->Cell($w[$i],7,$header[$i],1,0,'L',true);
						    $this->Ln();
						    // Color and font restoration
						    $this->SetFillColor(247,247,247);
						    $this->SetTextColor(0);
						    $this->SetFont('');
						    // Data
						    $fill = false;
						    $data2 = explode(";",$data);
						    foreach($data2 as $row)
						    {
							    $row = explode(",",$row);
						        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
						        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
						        $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
						        $this->Ln();
						        $fill = !$fill;
						    }
						    // Closing line
						    $this->Cell(array_sum($w),0,'','T');
						}
						
						function BasicTable2($header, $data)
						{
						    // Colors, line width and bold font
						    $this->SetFillColor(62,111,94);
						    $this->SetTextColor(255);
						    $this->SetDrawColor(0,0,0);
						    $this->SetLineWidth(.3);
						    $this->SetFont('','B');
						    // Header
						    $w = array(70, 110);
						    for($i=0;$i<count($header);$i++)
						        $this->Cell($w[$i],7,$header[$i],1,0,'L',true);
						    $this->Ln();
						    // Color and font restoration
						    $this->SetFillColor(247,247,247);
						    $this->SetTextColor(0);
						    $this->SetFont('');
						    // Data
						    $fill = false;
						    $data2 = explode(";",$data);
						    foreach($data2 as $row)
						    {
							    $row = explode(",",$row);
						        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
						        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
						        $this->Ln();
						        $fill = !$fill;
						    }
						    // Closing line
						    $this->Cell(array_sum($w),0,'','T');
						}
						
						function BasicTable3($header, $data)
						{
						    // Colors, line width and bold font
						    $this->SetFillColor(62,111,94);
						    $this->SetTextColor(255);
						    $this->SetDrawColor(0,0,0);
						    $this->SetLineWidth(.3);
						    $this->SetFont('','B');
						    // Header
						    $w = array(30, 90, 20, 20, 20);
						    for($i=0;$i<count($header);$i++)
						        $this->Cell($w[$i],7,$header[$i],1,0,'L',true);
						    $this->Ln();
						    // Color and font restoration
						    $this->SetFillColor(247,247,247);
						    $this->SetTextColor(0);
						    $this->SetFont('');
						    // Data
						    $fill = false;
						    $data2 = explode(";",$data);
						    foreach($data2 as $row)
						    {
							    $row = explode(",",$row);
						        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
						        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
						        $this->Cell($w[2],6,$row[2],'LR',0,'L',$fill);
						        $this->Cell($w[3],6,$row[3],'LR',0,'L',$fill);
						        $this->Cell($w[4],6,$row[4],'LR',0,'L',$fill);
						        $this->Ln();
						        $fill = !$fill;
						    }
						    // Closing line
						    $this->Cell(array_sum($w),0,'','T');
						}
			
					}
					
					$pdf = new PDF();
					$pdf->AddPage();
					$pdf->Image('../../nl_logo.jpg',10,10,0,20);
					$pdf->Line(0,35,300,35);
					$pdf->SetFont('Arial','',9);
					$pdf->Cell(0,3,"Nature's Laboratory",0,1,'R');
					$pdf->Cell(0,3,"Unit 3B, Enterprise Way",0,1,'R');
					$pdf->Cell(0,3,"Whitby",0,1,'R');
					$pdf->Cell(0,3,"North Yorkshire",0,1,'R');
					$pdf->Cell(0,3,"YO22 4NH",0,1,'R');
					$pdf->Cell(0,6,iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE','01947 602346  |  info@natureslaboratory.co.uk  |  natureslaboratory.co.uk'),0,1,'R');
					
					$process = $NaturesLaboratoryProduction->getProcess($process);
					$product = $NaturesLaboratoryProduction->getProduct($process['sku']);
					
					$wpo = 'P'.str_pad($process['natures_laboratory_productionID'], 6, '0', STR_PAD_LEFT);
					
					$pdf->SetXY(10, 45);
					$pdf->SetFont('Arial','B',16);
					$pdf->Cell(0,10,'WPO: '.$wpo,0,1);
					
					$pdf->SetFont('Arial','B',8);
					$header = array('Date Scheduled','WPO Number','Product Code');
					$data = $process['date'].",$wpo,".$process['sku'];
					$pdf->BasicTable($header,$data);
					
					$pdf->SetXY(10, 70);
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(0,10,'Order Details',0,1);
					$pdf->SetFont('Arial','B',8);
					
					$header = array('Item','Detail');
					$data = "Description,".$product['DESCRIPTION'].";";
					if($process['specification']){
						$data .= "Specification,".$process['specification'].";";
					}
					if($process['packaging']){
						$data .= "Packaging Requirements,".$process['packaging'].";";
					}
					if($process['labelling']){
						$data .= "Labelling Requirements,".$process['labelling'].";";
					}
					$data .= "Quantity Required,".$process['units']."";
					
					$pdf->BasicTable2($header,$data);
					
					$pdf->Cell(0,2,'',0,1);
					
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(0,8,'Stock Breakdown',0,1);
					
					$pdf->SetFont('Arial','B',8);
					$header = array('Code','Product','Batch No','BBE','Quantity');
					$data = "";
					
					$i = 1;
					$units = 100000000;
					
					$formulationLog = json_decode($process['formulationLog'],true);
					
					foreach($formulationLog as $ingredient){
						$key = array_keys($ingredient);
						$ingredientSKU = $key[0];
						if($ingredientSKU<>'0'){
							$product = $NaturesLaboratoryProduction->getProduct($ingredientSKU);
							$batchData = $NaturesLaboratoryProduction->getBatchData($process['natures_laboratory_productionID'],$ingredientSKU);
							$bbe = $NaturesLaboratoryProduction->getBatchBBE($batchData['batchCode']);
							
							$data .= "$ingredientSKU, $product[DESCRIPTION], $batchData[batchCode], $bbe[bbe], $ingredient[$ingredientSKU];";
							if($batchData['batchCodeAlt']){
								$data .= "$ingredientSKU, $product[DESCRIPTION], $batchData[batchCodeAlt], $bbe[bbe],;";	
							}
						}
					}
					
/*
					while($i<=50){
						$iQty = $NaturesLaboratoryProduction->getIngredient($process['sku'],$i);
						$required = round($product['COMPONENT_QTY_'.$i]*$process['units'],2);
						
						if($iQty){
							$batchData = $NaturesLaboratoryProduction->getBatchData($process['natures_laboratory_productionID'],$iQty['STOCK_CODE']);
							$bbe = $NaturesLaboratoryProduction->getBatchBBE($batchData['batchCode']);
							$data .= "$iQty[STOCK_CODE],$iQty[DESCRIPTION], $batchData[batchCode], $bbe[bbe],$required;";
							
							if($batchData['batchCodeAlt']){
								$batchData = $NaturesLaboratoryProduction->getBatchData($process['natures_laboratory_productionID'],$iQty['STOCK_CODE']);
								$bbe = $NaturesLaboratoryProduction->getBatchBBE($batchData['batchCode']);
								$data .= "$iQty[STOCK_CODE],$iQty[DESCRIPTION], $batchData[batchCodeAlt], $bbe[bbe],;";
							}
							
							$i++;
						}else{
							break;
						}
					}
*/
					
					$i--;
					
					$data = substr($data,0,-1);
					
					$pdf->BasicTable3($header,$data);
					
					$pdf->Cell(0,2,'',0,1);
					
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(0,10,'Product Information',0,1);
					
					$pdf->SetFont('Arial','B',8);
					
					$header = array('Item','Detail');
					$data = "";
					if($process['barrel']){
						$data = "Barrel,$process[barrel];";
					}
					$data .= "Date Went Into Production,".$process['date'].";Date Due To Press,".$process['datePressed'].";Date Completed,$process[completedDate];Date Components Deducted From Sage,$process[dateSageUpdated];Sage Updated By,$process[sageUpdatedBy];Quantity Made,$process[unitsMade];Batch Number Allocated,".$process['batchPrefix'].''.$process['finishedBatch'];
					$pdf->BasicTable2($header,$data);
					
					$pdf->Cell(0,2,'',0,1);
					
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(0,10,'Sign Off',0,1);
					
					$pdf->SetFont('Arial','B',8);
					
					$header = array('Check','Detail');
					$data = "Label Check,$process[labelCheck];Q.C. Check,$process[qcCheck];Date Finished Product Added to Sage Stock,$process[dateAddedToSage];Added to Sage By,$process[addedToSageBy]";
					$pdf->BasicTable2($header,$data);
					
					$pdf->Output('D',"Natures Laboratory WPO - ".$wpo.".pdf");
					exit();
					
			    }else{
			    	//DOWNLOAD LABEL
			    	$label = $process;
			    	
			    	$dir = '../productlabels/'.$label;
			    	$files = scandir($dir);

					$currentLabel = 0;
					$firstLabel = $_POST['start'];
					
					$pageLabel = $firstLabel;
					$totalLabels = count($files);
					
					//print_r($labelList);

					$pdf = new FPDF('L', 'in', array(4,3));

					foreach($files as $labelFile){
						if($labelFile<>'.' && $labelFile<>'..' && $labelFile<>'.DS_Store'){
							$pdf->AddPage();
							$labelBg = $labelBg;
							$pdf->Image('../productlabels/'.$label.'/'.$labelFile,0,0,4,3);
							$currentLabel++;
						}
					}
			
					$pdf->Output("D", "labels.pdf");
					
/*
					$pdf = new FPDF();
					$pdf->AddPage();
		
					foreach($files as $labelFile){
						if($labelFile<>'.' && $labelFile<>'..' && $labelFile<>'.DS_Store'){
							if($pageLabel==1){
								$pdf->Image('../productlabels/'.$label.'/'.$labelFile,3.7,12,99.1,67.8);
							}elseif($pageLabel==2){
								$pdf->Image('../productlabels/'.$label.'/'.$labelFile,105.1,12,99.1,67.8);
							}elseif($pageLabel==3){
								$pdf->Image('../productlabels/'.$label.'/'.$labelFile,3.7,79.8,99.1,67.8);
							}elseif($pageLabel==4){
								$pdf->Image('../productlabels/'.$label.'/'.$labelFile,105.1,79.8,99.1,67.8);
							}elseif($pageLabel==5){
								$pdf->Image('../productlabels/'.$label.'/'.$labelFile,3.7,147.8,99.1,67.8);
							}elseif($pageLabel==6){
								$pdf->Image('../productlabels/'.$label.'/'.$labelFile,105.1,147.8,99.1,67.8);
							}elseif($pageLabel==7){
								$pdf->Image('../productlabels/'.$label.'/'.$labelFile,3.7,215.6,99.1,67.8);
							}elseif($pageLabel==8){
								$pdf->Image('../productlabels/'.$label.'/'.$labelFile,105.1,215.6,99.1,67.8);
							}
							$pageLabel++;
							$currentLabel++;
							if($pageLabel==9){
								$pdf->AddPage();
								$pageLabel = 1;
							}
						}
					}
		
					$pdf->Output("D", "labels.pdf");
*/
		    	}
		    }
	    }
    }