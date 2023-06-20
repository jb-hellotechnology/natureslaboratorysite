<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryProduction = new Natures_Laboratory_Productions($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $production = array();
    $production = $NaturesLaboratoryProduction->getProduction();
    
    $task = $NaturesLaboratoryProduction->find($_GET['id'], true);
    
    if($_GET['id']){
    
	    if($Form->submitted()) {
	    
	        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
	        $postvars = array('sku', 'date_day', 'date_month', 'date_year', 'datePressed_day', 'datePressed_month', 'datePressed_year', 'dateSageUpdated_day', 'dateSageUpdated_month', 'dateSageUpdated_year', 'sageUpdatedBy', 'barrel', 'status', 'specification', 'packaging', 'labelling', 'units');	   
	    	$data = $Form->receive($postvars);     
	
			$data['date'] = "$data[date_year]-$data[date_month]-$data[date_day]";
	    	unset($data['date_year']);
	    	unset($data['date_month']);
	    	unset($data['date_day']);
	    	
	    	$data['datePressed'] = "$data[datePressed_year]-$data[datePressed_month]-$data[datePressed_day]";
	    	unset($data['datePressed_year']);
	    	unset($data['datePressed_month']);
	    	unset($data['datePressed_day']);
	    	
	    	$data['dateSageUpdated'] = "$data[dateSageUpdated_year]-$data[dateSageUpdated_month]-$data[dateSageUpdated_day]";
	    	unset($data['dateSageUpdated_year']);
	    	unset($data['dateSageUpdated_month']);
	    	unset($data['dateSageUpdated_day']);
	
	        $new_schedule = $task->update($data);
	        
	        $postvars = array('ingredients');	   
	    	$data = $Form->receive($postvars);
	    	$i = 1;
	    	while($i<=$data['ingredients']){
		    	$postvars = array('ingredient_'.$i,'batch_'.$i,'batch_alt_'.$i);	   
				$iData = $Form->receive($postvars);
				if($iData['ingredient_'.$i] AND $iData['batch_'.$i]){
					$NaturesLaboratoryProduction->saveIngredientBatch($_GET['id'],$iData['ingredient_'.$i],$iData['batch_'.$i],$iData['batch_alt_'.$i]);
				}
		    	$i++;
	    	}
	
	        $message = $HTML->success_message('Production process successfully entered production. Go to %sIn Production%s to print WPO.', '<a href="'.$API->app_path().'/production/in-production/">', '</a>');
	        
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
							$this->Cell(0,3,"WPO Produced at ". date('H:i:s d/m/Y'),0,1,'L');					    
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
						    $w = array(30, 100, 30, 20);
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
					$pdf->Cell(0,6,'To be deducted from Sage as soon as you put in production',0,1);
					
					$pdf->SetFont('Arial','B',8);
					$header = array('Code','Product','Batch No','Quantity');
					$data = "";
					
					$i = 1;
					$units = 100000000;
					while($i<=50){
						$iQty = $NaturesLaboratoryProduction->getIngredient($process['sku'],$i);
						$required = round($product['COMPONENT_QTY_'.$i]*$process['units'],2);
						if($iQty['STOCK_CODE']=='ALC96'){
							$required = round($required*1.04,2);
						}
						
						if($iQty){
							$batchData = $NaturesLaboratoryProduction->getBatchData($process['natures_laboratory_productionID'],$iQty['STOCK_CODE']);
							$data .= "$iQty[STOCK_CODE],$iQty[DESCRIPTION],$batchData[batchCode],$required;";
							$i++;
						}else{
							break;
						}
					}
					
					$i--;
					
					$data = substr($data,0,-1);
					
					$pdf->BasicTable3($header,$data);
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(0,6,'',0,1);
					$pdf->Cell(0,6,'When deducting component stock from Sage please enter reference in the following format: INITIAL/WPO NO/FINISHED BATCH NO',0,1);
					$pdf->Cell(0,6,'Check stock on Sage and raw material on shelves then deduct if correct. Stock check complete? Y / N',0,1);
					$pdf->Cell(0,6,'',0,1);
					
					$pdf->SetFont('Arial','B',10);
					$pdf->Cell(0,10,'Product Information',0,1);
					
					$pdf->SetFont('Arial','B',8);
					
					$header = array('Item','Detail');
					$data = "Barrel,".$process['barrel']." ".$process['barrel2']." ".$process['barrel3']." ".$process['barrel4']." ".$process['barrel5'].";Date Went Into Production,".$process['date'].";Date Due To Press,".$process['datePressed'].";Finished Batch Number,".$process['batchPrefix'].''.$process['finishedBatch'];
					$pdf->BasicTable2($header,$data);
					
					$pdf->Output('D',"Natures Laboratory WPO - ".$wpo.".pdf");
				}else{
			    	//DOWNLOAD LABEL
			    	$label = $process;
			    	
			    	$labelBg = '../labels/'.$label.'/label.png';
					
					$currentLabel = 0;
					$firstLabel = $_POST['start'];
					$pageLabel = $firstLabel;
					$totalLabels = $_POST['labels'];
					
					//print_r($labelList);
					
					$pdf = new FPDF();
					$pdf->AddPage();
		
					while($currentLabel<$totalLabels){
						if($pageLabel==1){
							$pdf->Image($labelBg,3.7,12,99.1,67.8);
						}elseif($pageLabel==2){
							$pdf->Image($labelBg,105.1,12,99.1,67.8);
						}elseif($pageLabel==3){
							$pdf->Image($labelBg,3.7,79.8,99.1,67.8);
						}elseif($pageLabel==4){
							$pdf->Image($labelBg,105.1,79.8,99.1,67.8);
						}elseif($pageLabel==5){
							$pdf->Image($labelBg,3.7,147.8,99.1,67.8);
						}elseif($pageLabel==6){
							$pdf->Image($labelBg,105.1,147.8,99.1,67.8);
						}elseif($pageLabel==7){
							$pdf->Image($labelBg,3.7,215.6,99.1,67.8);
						}elseif($pageLabel==8){
							$pdf->Image($labelBg,105.1,215.6,99.1,67.8);
						}
						$pageLabel++;
						$currentLabel++;
						if($pageLabel==9){
							$pdf->AddPage();
							$pageLabel = 1;
						}
					}
		
					$pdf->Output("D", "labels.pdf");
		    	}	    	
		    }
		}
	}
		    