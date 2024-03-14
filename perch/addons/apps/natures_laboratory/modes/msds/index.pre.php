<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;
    
    $NaturesLaboratoryMSDS = new Natures_Laboratory_MSDSs($API);
    $NaturesLaboratoryMSDSTemplate = new Natures_Laboratory_MSDS_Templates($API);
    $NaturesLaboratoryCOA = new Natures_Laboratory_COAs($API);
    $NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Specs($API);
    $NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $msds = array();
    $msds = $NaturesLaboratoryMSDS->getMSDSs();
    
    if($Form->submitted()){
	   	$postvars = array('msds');	   
    	$data = $Form->receive($postvars);   
    	$msds = $data['msds'];
    	
    	$msdsData = $NaturesLaboratoryMSDS->find($msds,true);
    	$details = $msdsData->to_array();
    	$detailsData = json_decode($details['natures_laboratory_msds_DynamicFields'],true);
    	
    	$msdsTemplateData = $NaturesLaboratoryMSDSTemplate->find($details['productType'],true);
    	$templateDetails = $msdsTemplateData->to_array();
    	$msdsTData = json_decode($templateDetails['natures_laboratory_msds_templateDynamicFields'],true);
    	
    	if($details['productType']=='3' OR $details['productType']=='4'){
	    	$coaDetails = $NaturesLaboratoryMSDS->findCOA($details['productCode']);
    	}
    	
    	$productData = $NaturesLaboratoryGoodsIn->getByCode($details['productCode']);
    	
    	class PDF extends FPDF
		{
			// Page header
			function Header()
			{
			    
			}
			
			function Footer()
			{
				$this->Line(0,276,300,276);
			    $this->SetY(-24);
			    $this->Image('../organic.png',10,280,0,12);
			    $this->Image('../9001.jpg',30,280,0,12);
			    $this->SetY(-17);$this->SetX(-10);
			    $this->SetFont('Arial','',6);
			    $this->Cell(0,3,"Nature's Laboratory Ltd",0,1,'R');
			    $this->SetY(-14);$this->SetX(-10);
				$this->Cell(0,3,"Unit 3B, Enterprise Way",0,1,'R');
				$this->SetY(-11);$this->SetX(-10);
				$this->Cell(0,3,"Whitby, North Yorkshire",0,1,'R');
				$this->SetY(-8);$this->SetX(-10);
				$this->Cell(0,3,"YO22 4NH",0,1,'R');
				
				$this->SetY(-17);$this->SetX(45);
				$this->Cell(60,3,"natureslaboratory.co.uk",0,0,'L');
				$this->SetY(-14);$this->SetX(45);
				$this->Cell(60,3,"herbalapothecaryuk.com",0,0,'L');
				$this->SetY(-11);$this->SetX(45);
				$this->Cell(60,3,"sweetcecilys.com",0,0,'L');
				$this->SetY(-8);$this->SetX(45);
				$this->Cell(60,3,"beevitalpropolis.com",0,1,'L');
				
				$this->SetY(-17);$this->SetX(90);
				$this->Cell(60,3,"Vat No.: 789 4316 78",0,0,'L');
				$this->SetY(-14);$this->SetX(90);
				$this->Cell(60,3,"Company Reg. No.: 4375564",0,0,'L');
				$this->SetY(-11);$this->SetX(90);
				$this->Cell(60,3,"01947 602346",0,0,'L');
				$this->SetY(-8);$this->SetX(90);
				$this->Cell(60,3,"info@natureslaboratory.co.uk",0,1,'L');
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
			    $w = array(70, 50, 50);
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

		}
		
		$pdf = new PDF();
		$pdf->AddPage();
		$pdf->Image('../nl_logo.jpg',10,10,0,20);
		$pdf->Line(0,35,300,35);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(0,3,"Nature's Laboratory",0,1,'R');
		$pdf->Cell(0,3,"Unit 3B, Enterprise Way",0,1,'R');
		$pdf->Cell(0,3,"Whitby",0,1,'R');
		$pdf->Cell(0,3,"North Yorkshire",0,1,'R');
		$pdf->Cell(0,3,"YO22 4NH",0,1,'R');
		$pdf->Cell(0,6,iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE','01947 602346  |  info@natureslaboratory.co.uk  |  natureslaboratory.co.uk'),0,1,'R');
		
		$pdf->SetXY(10, 35);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'MSDS: '.$detailsData['name'],0,1);
		$pdf->Line(0,44,300,44);
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'Section 1: Identification of the substance/mixture and of the company',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'1.1 Product identifiers:',0,1);
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(0,5,'(a) Product Name: '.$detailsData['name'],0,1);
		$pdf->MultiCell(0,5,'(b) Product Number: '.$details['productCode'],0,1);
		if($details['1_1_c']){$pdf->MultiCell(0,5,'(c) Brand: '.$details['1_1_c'],0,1);}else{$pdf->MultiCell(0,5,'(c) Brand: '.$msdsTData['1_1_c'],0,1);}
		if($details['1_1_d']){$pdf->MultiCell(0,5,'(d) Index No.: '.$details['1_1_d'],0,1);}else{$pdf->MultiCell(0,5,'(d) Index No.: '.$msdsTData['1_1_d'],0,1);}
		if($details['1_1_e']){$pdf->MultiCell(0,5,'(e) REACH No.: '.$details['1_1_e'],0,1);}else{$pdf->MultiCell(0,5,'(e) REACH No.: '.$msdsTData['1_1_e'],0,1);}
		if($details['1_1_f']){$pdf->MultiCell(0,5,'(f) CAS No.: '.$details['1_1_f'],0,1);}else{$pdf->MultiCell(0,5,'(f) CAS No.: '.$msdsTData['1_1_f'],0,1);}
		if($details['productType']=='Tincture' OR $details['productType']=='Fluid Extract'){
			$pdf->MultiCell(0,5,'(g) pH: '.$coaDetails['productCode'],0,1);
			$pdf->MultiCell(0,5,'(h) Specific Gravity: '.$coaDetails['productCode'],0,1);
		}

		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		1.2 Relevant identified uses of the substance or mixture and uses advised against:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['1_2']){$pdf->MultiCell(0,5,''.$details['1_2'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['1_2'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		1.3 Details of the supplier of the safety data sheet:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['1_3']){$pdf->MultiCell(0,5,''.$details['1_3'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['1_3'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		1.4 Emergency telephone number:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['1_4']){$pdf->MultiCell(0,5,''.$details['1_4'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['1_4'],0,1);}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 2: Hazards identification',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'2.1 Classification of the substance or mixture:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['2_1']){$pdf->MultiCell(0,5,''.$details['2_1'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['2_1'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		2.2 Label elements:',0,1);
		/* PICTOGRAMS HERE */
		if($details['flammable'] OR $msdsTData['flammable']){
			$pdf->Image('../flammable.gif', '120', '160', -150);
		}
		if($details['poisonous'] OR $msdsTData['poisonous']){
			$pdf->Image('../poison.gif', '140', '160', -150);
		}
		
		/* WARNINGS HERE */
		
		$pdf->SetFont('Arial','',9);
		if($msdsTData['eye_irritation']){$pdf->MultiCell(0,5,'H320: Causes eye irritation',0,1);}
		if($msdsTData['flammable_liquid']){$pdf->MultiCell(0,5,'H226: Flammable liquid',0,1);}
		
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		2.3 Precautionary statements:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['2_3']){$pdf->MultiCell(0,5,''.$details['2_3'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['2_3'],0,1);}

		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 3: Composition / information on ingredients',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'3.1 Substance synonyms:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['3_1']){$pdf->MultiCell(0,5,''.$details['3_1'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['3_1'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		3.2 Chemical description:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['3_2']){$pdf->MultiCell(0,5,''.$details['3_2'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['3_2'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		3.3 Ingredients:',0,1);
		/* INGREDIENTS HERE */
		$pdf->SetFont('Arial','',9);
		$i = 0;
		while($i<=20){
			$ingredient = $productData['COMPONENT_CODE_'.$i];
			$iData = $NaturesLaboratoryGoodsIn->getByCode($ingredient);
			if($ingredient<>'AMBERPET1V' AND $ingredient<>'PETLID' AND strlen($ingredient)>1){
				
				$sizes = array("1000g","1000ml","1000");
				$name = str_replace($sizes, "", $iData['DESCRIPTION']);
				
				$pdf->MultiCell(0,5,$name,0,1);
				
			}
			$i++;
		}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 4: First aid measures',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'4.1 General information:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['4_1']){$pdf->MultiCell(0,5,''.$details['4_1'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['4_1'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		4.2 After inhalation:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['4_2']){$pdf->MultiCell(0,5,''.$details['4_2'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['4_2'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		4.3 After eye contact:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['4_3']){$pdf->MultiCell(0,5,''.$details['4_3'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['4_3'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		4.4 In case of skin contact:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['4_4']){$pdf->MultiCell(0,5,''.$details['4_4'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['4_4'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		4.5 In case of ingestion:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['4_5']){$pdf->MultiCell(0,5,''.$details['4_5'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['4_5'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		4.6 Most important symptoms and effects, both acute and delayed:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['4_6']){$pdf->MultiCell(0,5,''.$details['4_6'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['4_6'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		4.7 Indication of any immediate medical attention and special treatment needed:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['4_7']){$pdf->MultiCell(0,5,''.$details['4_7'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['4_7'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		4.8 Self-protection of the first aider:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['4_8']){$pdf->MultiCell(0,5,''.$details['4_8'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['4_8'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		4.9 Information to physician:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['4_9']){$pdf->MultiCell(0,5,''.$details['4_9'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['4_9'],0,1);}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 5: Firefighting measures',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'5.1 Suitable extinguishing media:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['5_1']){$pdf->MultiCell(0,5,''.$details['5_1'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['5_1'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		5.2 Extinguishing media which must not be used for safety reasons:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['5_2']){$pdf->MultiCell(0,5,''.$details['5_2'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['5_2'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		5.3 Special hazards arising from the substance or mixture:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['5_3']){$pdf->MultiCell(0,5,''.$details['5_3'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['5_3'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		5.4 Advice for firefighters:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['5_4']){$pdf->MultiCell(0,5,''.$details['5_4'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['5_4'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		5.5 Additional information:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['5_5']){$pdf->MultiCell(0,5,''.$details['5_5'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['5_5'],0,1);}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 6: Accidental release measures',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'6.1 Personal precautions, protective equipment and emergency procedures:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['6_1']){$pdf->MultiCell(0,5,''.$details['6_1'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['6_1'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		6.2 Environmental precautions:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['6_2']){$pdf->MultiCell(0,5,''.$details['6_2'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['6_2'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		6.3 Methods and materials for containment and cleaning up:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['6_3']){$pdf->MultiCell(0,5,''.$details['6_3'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['6_3'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		6.4 Additional information:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['6_4']){$pdf->MultiCell(0,5,''.$details['6_4'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['6_4'],0,1);}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 7: Handling and storage',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'7.1 Precautions for safe handling:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['7_1']){$pdf->MultiCell(0,5,''.$details['7_1'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['7_1'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		7.2 Safe storage temperature',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['7_2']){$pdf->MultiCell(0,5,''.$details['7_2'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['7_2'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		7.3 Storage class:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['7_3']){$pdf->MultiCell(0,5,''.$details['7_3'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['7_3'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		7.4 Storage area',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['7_4']){$pdf->MultiCell(0,5,''.$details['7_4'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['7_4'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		7.5 Specific end use(s):',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['7_5']){$pdf->MultiCell(0,5,''.$details['7_5'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['7_5'],0,1);}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 8: Exposure controls / personal protection',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'8.1 Control parameters:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['8_1']){$pdf->MultiCell(0,5,''.$details['8_1'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['8_1'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		8.2 Exposure controls:',0,1);
		$pdf->SetFont('Arial','',9);
		foreach($msdsTData['exposure_controls'] as $item){
			$pdf->MultiCell(0,5,''.$item['8_2'],0,1);
		}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'Section 9: Physical and chemical properties',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'9.1 Information on basic physical and chemical properties:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['9_1_a']){$pdf->MultiCell(0,5,'(a) Appearance: '.$details['9_1_a'],0,1);}else{$pdf->MultiCell(0,5,'(a) Appearance: '.$msdsTData['9_1_a'],0,1);}
		if($details['9_1_b']){$pdf->MultiCell(0,5,'(b) Odour: '.$details['9_1_b'],0,1);}else{$pdf->MultiCell(0,5,'(b) Odour: '.$msdsTData['9_1_b'],0,1);}
		if($details['9_1_c']){$pdf->MultiCell(0,5,'(c) Odour threshold: '.$details['9_1_c'],0,1);}else{$pdf->MultiCell(0,5,'(c) Odour Threshold: '.$msdsTData['9_1_c'],0,1);}
		if($details['9_1_d']){$pdf->MultiCell(0,5,'(d) PH: '.$details['9_1_d'],0,1);}else{$pdf->MultiCell(0,5,'(d) PH: '.$msdsTData['9_1_d'],0,1);}
		if($details['9_1_e']){$pdf->MultiCell(0,5,'(e) Melting point/freezing point: '.$details['9_1_e'],0,1);}else{$pdf->MultiCell(0,5,'(e) Melting point/freezing point: '.$msdsTData['9_1_e'],0,1);}
		if($details['9_1_f']){$pdf->MultiCell(0,5,'(f) Initial boiling point and boiling range: '.$details['9_1_f'],0,1);}else{$pdf->MultiCell(0,5,'(f) Initial boiling point and boiling range: '.$msdsTData['9_1_f'],0,1);}
		if($details['9_1_g']){$pdf->MultiCell(0,5,'(g) Flash point: '.$details['9_1_g'],0,1);}else{$pdf->MultiCell(0,5,'(g) Flash point: '.$msdsTData['9_1_g'],0,1);}
		if($details['9_1_h']){$pdf->MultiCell(0,5,'(h) Evaporation rate: '.$details['9_1_h'],0,1);}else{$pdf->MultiCell(0,5,'(h) Evaporation rate: '.$msdsTData['9_1_h'],0,1);}
		if($details['9_1_i']){$pdf->MultiCell(0,5,'(i) Flammability: '.$details['9_1_i'],0,1);}else{$pdf->MultiCell(0,5,'(i) Flammability: '.$msdsTData['9_1_i'],0,1);}
		if($details['9_1_j']){$pdf->MultiCell(0,5,'(j) Upper/lower flammability limits: '.$details['9_1_j'],0,1);}else{$pdf->MultiCell(0,5,'(j) Upper/lower flammability limits: '.$msdsTData['9_1_j'],0,1);}
		if($details['9_1_k']){$pdf->MultiCell(0,5,'(k) Vapour pressure: '.$details['9_1_k'],0,1);}else{$pdf->MultiCell(0,5,'(k) Vapour pressure: '.$msdsTData['9_1_k'],0,1);}
		if($details['9_1_l']){$pdf->MultiCell(0,5,'(l) Vapour density: '.$details['9_1_l'],0,1);}else{$pdf->MultiCell(0,5,'(l) Vapour density: '.$msdsTData['9_1_l'],0,1);}
		if($details['9_1_m']){$pdf->MultiCell(0,5,'(m) Relative density: '.$details['9_1_m'],0,1);}else{$pdf->MultiCell(0,5,'(m) Relative density: '.$msdsTData['9_1_m'],0,1);}
		if($details['9_1_n']){$pdf->MultiCell(0,5,'(n) Solubility: '.$details['9_1_n'],0,1);}else{$pdf->MultiCell(0,5,'(n) Solubility: '.$msdsTData['9_1_n'],0,1);}
		if($details['9_1_o']){$pdf->MultiCell(0,5,'(o) Partition coefficient: '.$details['9_1_o'],0,1);}else{$pdf->MultiCell(0,5,'(o) Partition coefficient: '.$msdsTData['9_1_o'],0,1);}
		if($details['9_1_p']){$pdf->MultiCell(0,5,'(p) Auto-ignition temperature: '.$details['9_1_p'],0,1);}else{$pdf->MultiCell(0,5,'(p) Auto-ignition temperature: '.$msdsTData['9_1_p'],0,1);}
		if($details['9_1_q']){$pdf->MultiCell(0,5,'(q) Decomposition temperature: '.$details['9_1_q'],0,1);}else{$pdf->MultiCell(0,5,'(q) Decomposition temperature: '.$msdsTData['9_1_q'],0,1);}
		if($details['9_1_r']){$pdf->MultiCell(0,5,'(r) Viscosity: '.$details['9_1_r'],0,1);}else{$pdf->MultiCell(0,5,'(r) Viscosity: '.$msdsTData['9_1_r'],0,1);}
		if($details['9_1_s']){$pdf->MultiCell(0,5,'(s) Explosive properties: '.$details['9_1_s'],0,1);}else{$pdf->MultiCell(0,5,'(s) Explosive properties: '.$msdsTData['9_1_s'],0,1);}
		if($details['9_1_t']){$pdf->MultiCell(0,5,'(t) Oxidizing properties: '.$details['9_1_t'],0,1);}else{$pdf->MultiCell(0,5,'(t) Oxidizing properties: '.$msdsTData['9_1_t'],0,1);}
		if($details['9_1_u']){$pdf->MultiCell(0,5,'(u) Ethanol content: '.$details['9_1_u'],0,1);}else{$pdf->MultiCell(0,5,'(u) Ethanol content: '.$msdsTData['9_1_u'],0,1);}
		if($details['9_1_v']){$pdf->MultiCell(0,5,'(v) Bulk density: '.$details['9_1_v'],0,1);}else{$pdf->MultiCell(0,5,'(v) Bulk density: '.$msdsTData['9_1_v'],0,1);}
		if($details['9_1_w']){$pdf->MultiCell(0,5,'(w) Refraction index: '.$details['9_1_w'],0,1);}else{$pdf->MultiCell(0,5,'(w) Refraction index: '.$msdsTData['9_1_w'],0,1);}
		if($details['9_1_x']){$pdf->MultiCell(0,5,'(x) Dissociation constant: '.$details['9_1_x'],0,1);}else{$pdf->MultiCell(0,5,'(x) Dissociation index: '.$msdsTData['9_1_x'],0,1);}
		if($details['9_1_y']){$pdf->MultiCell(0,5,'(y) Surface tension: '.$details['9_1_y'],0,1);}else{$pdf->MultiCell(0,5,'(y) Surface tension: '.$msdsTData['9_1_y'],0,1);}
		if($details['9_1_z']){$pdf->MultiCell(0,5,'(z) Henry constant: '.$details['9_1_z'],0,1);}else{$pdf->MultiCell(0,5,'(z) Henry constant: '.$msdsTData['9_1_z'],0,1);}
		
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 10: Stability and reactivity',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'10.1 Reactivity',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['10_1']){$pdf->MultiCell(0,5,''.$details['10_1'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['10_1'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		10.2 Chemical stability',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['10_2']){$pdf->MultiCell(0,5,''.$details['10_2'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['10_2'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		10.3 Possibility of hazardous reactions',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['10_4']){$pdf->MultiCell(0,5,''.$details['10_4'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['10_3'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		10.4 Conditions to avoid:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['10_4']){$pdf->MultiCell(0,5,''.$details['10_4'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['10_4'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		10.5 Incompatible materials',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['10_5']){$pdf->MultiCell(0,5,''.$details['10_5'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['10_5'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		10.6 Hazardous decomposition products:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['10_6']){$pdf->MultiCell(0,5,''.$details['10_6'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['10_6'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		10.7 Additional information',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['10_7']){$pdf->MultiCell(0,5,''.$details['10_7'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['10_7'],0,1);}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 11: Toxicological information',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'11.1 Information on toxicological effects:',0,1);
		$pdf->SetFont('Arial','',9);
		foreach($msdsTData['accute_effects'] as $item){
			$pdf->MultiCell(0,5,''.$item['11_1'],0,1);
		}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		11.2 Irritant and corrosive effects:',0,1);
		$pdf->SetFont('Arial','',9);
		foreach($msdsTData['irritant_effects'] as $item){
			$pdf->MultiCell(0,5,''.$item['11_2'],0,1);
		}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		11.3 Respiratory or skin sensitisation:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['11_3']){$pdf->MultiCell(0,5,''.$details['11_3'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['11_3'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		11.4 STOT single exposure:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['11_4']){$pdf->MultiCell(0,5,''.$details['11_4'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['11_4'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		11.5 STOT repeated exposure:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['11_5']){$pdf->MultiCell(0,5,''.$details['11_5'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['11_5'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		11.6.1 Carcinogenicity:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['11_6_1']){$pdf->MultiCell(0,5,''.$details['11_6_1'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['11_6_1'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		11.6.2 Germ cell mutagenicity:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['11_6_2']){$pdf->MultiCell(0,5,''.$details['11_6_2'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['11_6_2'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		11.6.3 Reproductive toxicity:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['11_6_3']){$pdf->MultiCell(0,5,''.$details['11_6_3'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['11_6_3'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		11.6.4 Aspiration hazard:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['11_6_4']){$pdf->MultiCell(0,5,''.$details['11_6_4'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['11_6_4'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		11.6.5 Other adverse effects:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['11_6_5']){$pdf->MultiCell(0,5,''.$details['11_6_5'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['11_6_5'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		11.6.6 Additional information:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['11_6_6']){$pdf->MultiCell(0,5,''.$details['11_6_6'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['11_6_6'],0,1);}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 12: Ecological information',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'12.1 Ecotoxicity:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['12_1_a']){$pdf->MultiCell(0,5,'(a) Acute (short-term) fish toxicity: '.$details['12_1_a'],0,1);}else{$pdf->MultiCell(0,5,'(a) Acute (short-term) fish toxicity: '.$msdsTData['12_1_a'],0,1);}
		if($details['12_1_b']){$pdf->MultiCell(0,5,'(b) Chronic (long-term) fish toxicity: '.$details['12_1_b'],0,1);}else{$pdf->MultiCell(0,5,'(b) Chornic (long-term) fish toxicity: '.$msdsTData['12_1_b'],0,1);}
		if($details['12_1_c']){$pdf->MultiCell(0,5,'(c) Acute (short-term) daphnia toxicity: '.$details['12_1_c'],0,1);}else{$pdf->MultiCell(0,5,'(c) Acute (short-term) daphnia toxicity: '.$msdsTData['12_1_c'],0,1);}
		if($details['12_1_d']){$pdf->MultiCell(0,5,'(d) Chronic (long-term) daphnia toxicity: '.$details['12_1_d'],0,1);}else{$pdf->MultiCell(0,5,'(d) Chronic (long-term) daphnia toxicity: '.$msdsTData['12_1_d'],0,1);}
		if($details['12_1_e']){$pdf->MultiCell(0,5,'(e) Acute (short-term) algae toxicity: '.$details['12_1_e'],0,1);}else{$pdf->MultiCell(0,5,'(e) Acute (short-term) algae toxicity: '.$msdsTData['12_1_e'],0,1);}
		if($details['12_1_f']){$pdf->MultiCell(0,5,'(f) Chronic (long-term) algae toxicity: '.$details['12_1_f'],0,1);}else{$pdf->MultiCell(0,5,'(f) Chronic (long-term) algae toxicity: '.$msdsTData['12_1_f'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		12.2 Persistence and degradability:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['12_2']){$pdf->MultiCell(0,5,''.$details['12_2'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['12_2'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		12.3 Bioaccumulative potential:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['12_3']){$pdf->MultiCell(0,5,''.$details['12_3'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['12_3'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		12.4 Mobility in soil:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['12_4']){$pdf->MultiCell(0,5,''.$details['12_4'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['12_4'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		12.5 Results of PBT/vPvB assessment:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['12_5']){$pdf->MultiCell(0,5,''.$details['12_5'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['12_5'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		12.6 Other adverse effects:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['12_6']){$pdf->MultiCell(0,5,''.$details['12_6'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['12_6'],0,1);}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 13: Disposal considerations',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'13.1 Dispose according to local legislation:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['13_1']){$pdf->MultiCell(0,5,''.$details['13_1'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['13_1'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		13.2 Waste code product:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['13_2']){$pdf->MultiCell(0,5,''.$details['13_2'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['13_2'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		13.3 Appropriate disposal:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['13_3']){$pdf->MultiCell(0,5,''.$details['13_3'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['13_3'],0,1);}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		13.4 Additional information',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['13_4']){$pdf->MultiCell(0,5,''.$details['13_4'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['13_4'],0,1);}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 14: Transport information',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'14.1 Land transport (ADR/RID):',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['14_1_a']){$pdf->MultiCell(0,5,'(a) UN number: '.$details['14_1_a'],0,1);}else{$pdf->MultiCell(0,5,'(a) UN number'.$msdsTData['14_1_a'],0,1);}
		if($details['14_1_b']){$pdf->MultiCell(0,5,'(b) UN proper shipping name: '.$details['14_1_b'],0,1);}else{$pdf->MultiCell(0,5,'(b) UN proper shipping name:'.$msdsTData['14_1_b'],0,1);}
		if($details['14_1_c']){$pdf->MultiCell(0,5,'(c) Classification: '.$details['14_1_c'],0,1);}else{$pdf->MultiCell(0,5,'(c) Classification:'.$msdsTData['14_1_c'],0,1);}
		if($details['14_1_d']){$pdf->MultiCell(0,5,'(d) Transport hazard class(es): '.$details['14_1_d'],0,1);}else{$pdf->MultiCell(0,5,'(d) Transport hazard class(es):'.$msdsTData['14_1_d'],0,1);}
		if($details['14_1_e']){$pdf->MultiCell(0,5,'(e) Packaging group: '.$details['14_1_e'],0,1);}else{$pdf->MultiCell(0,5,'(e) Packaging group:'.$msdsTData['14_1_e'],0,1);}
		if($details['14_1_f']){$pdf->MultiCell(0,5,'(f) Environmental hazards: '.$details['14_1_f'],0,1);}else{$pdf->MultiCell(0,5,'(f) Environmental hazards:'.$msdsTData['14_1_f'],0,1);}
		if($details['14_1_g']){$pdf->MultiCell(0,5,'(g) Special precautions for user: '.$details['14_1_g'],0,1);}else{$pdf->MultiCell(0,5,'(g) Special precautions for user:'.$msdsTData['14_1_g'],0,1);}
		
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		14.2 Sea transport (IMDG):',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['14_2_a']){$pdf->MultiCell(0,5,'(a) UN number: '.$details['14_2_a'],0,1);}else{$pdf->MultiCell(0,5,'(a) UN number: '.$msdsTData['14_2_a'],0,1);}
		if($details['14_2_b']){$pdf->MultiCell(0,5,'(b) UN proper shipping name: '.$details['14_2_b'],0,1);}else{$pdf->MultiCell(0,5,'(b) UN proper shipping name: '.$msdsTData['14_2_b'],0,1);}
		if($details['14_2_c']){$pdf->MultiCell(0,5,'(c) Classification: '.$details['14_2_c'],0,1);}else{$pdf->MultiCell(0,5,'(c) Classification: '.$msdsTData['14_2_c'],0,1);}
		if($details['14_2_d']){$pdf->MultiCell(0,5,'(d) Transport hazard class(es): '.$details['14_2_d'],0,1);}else{$pdf->MultiCell(0,5,'(d) Transport hazard class(es): '.$msdsTData['14_2_d'],0,1);}
		if($details['14_2_e']){$pdf->MultiCell(0,5,'(e) Packaging group: '.$details['14_2_e'],0,1);}else{$pdf->MultiCell(0,5,'(e) Packaging group: '.$msdsTData['14_2_e'],0,1);}
		if($details['14_2_f']){$pdf->MultiCell(0,5,'(f) Environmental hazards: '.$details['14_2_f'],0,1);}else{$pdf->MultiCell(0,5,'(f) Environmental hazards: '.$msdsTData['14_2_f'],0,1);}
		if($details['14_2_g']){$pdf->MultiCell(0,5,'(g) Marine pollutant: '.$details['14_2_g'],0,1);}else{$pdf->MultiCell(0,5,'(g) Marine pollutant: '.$msdsTData['14_2_g'],0,1);}
		if($details['14_2_h']){$pdf->MultiCell(0,5,'(h) Special precautions for user: '.$details['14_2_h'],0,1);}else{$pdf->MultiCell(0,5,'(h) Special precautions for user: '.$msdsTData['14_2_h'],0,1);}
		
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		14.3 Land transport (ADR/RID):',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['14_3_a']){$pdf->MultiCell(0,5,'(a) UN number: '.$details['14_3_a'],0,1);}else{$pdf->MultiCell(0,5,'(a) UN number: '.$msdsTData['14_3_a'],0,1);}
		if($details['14_3_b']){$pdf->MultiCell(0,5,'(b) UN proper shipping name: '.$details['14_3_b'],0,1);}else{$pdf->MultiCell(0,5,'(b) UN proper shipping name: '.$msdsTData['14_3_b'],0,1);}
		if($details['14_3_c']){$pdf->MultiCell(0,5,'(c) Classification: '.$details['14_3_c'],0,1);}else{$pdf->MultiCell(0,5,'(c) Classification: '.$msdsTData['14_3_c'],0,1);}
		if($details['14_3_d']){$pdf->MultiCell(0,5,'(d) Transport hazard class(es): '.$details['14_3_d'],0,1);}else{$pdf->MultiCell(0,5,'(d) Transport hazard class(es): '.$msdsTData['14_3_d'],0,1);}
		if($details['14_3_e']){$pdf->MultiCell(0,5,'(e) Packaging group: '.$details['14_3_e'],0,1);}else{$pdf->MultiCell(0,5,'(e) Packaging group: '.$msdsTData['14_3_e'],0,1);}
		if($details['14_3_g']){$pdf->MultiCell(0,5,'(f) Special precautions for user: '.$details['14_3_f'],0,1);}else{$pdf->MultiCell(0,5,'(f) Special precautions for user: '.$msdsTData['14_3_f'],0,1);}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 15: Regulatory information',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'15.1 Safety, health and environmental regulations/legislation specific for the substance or mixture:',0,1);
		$pdf->SetFont('Arial','',9);
		foreach($msdsTData['regulatory_information'] as $item){
			$pdf->MultiCell(0,5,''.$item['15_1'].'
			',0,1);
		}
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'
		15.2 Chemical safety assessment:',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['15_2']){$pdf->MultiCell(0,5,''.$details['15_2'],0,1);}else{$pdf->MultiCell(0,5,''.$msdsTData['15_2'],0,1);}
		
		$pdf->SetFont('Arial','B',11);
		$pdf->MultiCell(0,10,'
		Section 16: Other information',0,1);
		$pdf->SetFont('Arial','B',9);
		$pdf->MultiCell(0,5,'Abbreviations and acronyms:',0,1);
		$pdf->SetFont('Arial','',9);
		$pdf->MultiCell(0,5,'ACGIH - American Conference of Governmental Industrial Hygiensts',0,1);
		$pdf->MultiCell(0,5,'ADR - European Agreement concerning the International Carriage of Dangerous Goods by Road',0,1);
		$pdf->MultiCell(0,5,'AGS - Committee on Hazardous Substances (Ausschuss für Gefahrstoffe)',0,1);
		$pdf->MultiCell(0,5,'CLP - Regulation on Classification, Labelling and Packaging of Substances and Mixtures',0,1);
		$pdf->MultiCell(0,5,'DFG - German Research Foundation (Deutsche Forschungsgemeinschaft)',0,1);
		$pdf->MultiCell(0,5,'Gestis - Information system on hazardous substances of the German Social Accident Insurance (Gefahrstoffinformationssystem der Deutschen Gesetzlichen Unfallversicherung)',0,1);
		$pdf->MultiCell(0,5,'IATA-DGR - International Air Transport Association-Dangerous Goods Regulations',0,1);
		$pdf->MultiCell(0,5,'ICAO-TI - International Civil Aviation Organization-Technical Instructions',0,1);
		$pdf->MultiCell(0,5,'IMDG - International Maritime Code for Dangerous Goods',0,1);
		$pdf->MultiCell(0,5,'LTV - Long Term Value',0,1);
		$pdf->MultiCell(0,5,'NIOSH - National Institute for Occupational Safety and Health',0,1);
		$pdf->MultiCell(0,5,'OSHA - Occupational Safety & Health Administration',0,1);
		$pdf->MultiCell(0,5,'PBT - Persistent, Bioaccumulative and Toxic',0,1);
		$pdf->MultiCell(0,5,'RID - Regulation concerning the International Carriage of Dangerous Goods by Rail',0,1);
		$pdf->MultiCell(0,5,'STV - Short Term Value',0,1);
		$pdf->MultiCell(0,5,'SVHC - Substances of Very High Concern',0,1);
		$pdf->MultiCell(0,5,'vPvB - very Persistent, very Bioaccumulative
		',0,1);
		
		$pdf->MultiCell(0,5,'Date: '.$msdsTData['date'],0,1);
		$pdf->MultiCell(0,5,'Document Version: '.$msdsTData['version'].'
		',0,1);
		
		$pdf->WriteHTML("<i>The above information describes exclusively the safety requirements of the product and is based on our present-day knowledge. The information is intended to give you advice about the safe handling of the product named in this safety data sheet, for storage, processing, transport and disposal. The information cannot be transferred to other products. In the case of mixing the product with other products or in the case of processing, the information on this safety data sheet is not necessarily valid for the new made-up material.</i><br><br>Prepared By<br><b><i>Shankar Katekhaye</i></b><br>Quality Manager");
		
		$pdf->Output('D',"Natures Laboratory MSDS.pdf");
		exit();
		
    }