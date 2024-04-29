<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;
    
    $NaturesLaboratoryCOA = new Natures_Laboratory_COAs($API);
    $NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Specs($API);
    $NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $coa = array();
    $coa = $NaturesLaboratoryCOA->getCOAs($_GET['q']);
    
    if($Form->submitted()){
	   	$postvars = array('coa');	   
    	$data = $Form->receive($postvars);   
    	$coa = $data['coa'];
    	
    	$coaData = $NaturesLaboratoryCOA->find($coa,true);
    	$details = $coaData->to_array();
    	
    	$specDetails = $NaturesLaboratoryCOASpec->byCode($details['productCode']);
    	
    	$batch = $NaturesLaboratoryGoodsIn->getBatchData($details['ourBatch']);
    	
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
			    //$this->Image('../organic.png',10,280,0,12);
			    $this->Image('../9001.jpg',10,280,0,12);
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
		$pdf->Cell(0,10,'Certificate of Analysis: '.$specDetails['commonName'],0,1);
		$pdf->Line(0,44,300,44);
		$pdf->SetFont('Arial','',9);
		if($specDetails['productDescription']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Product Description: ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(100,5,$specDetails['productDescription'],0,1);}
		if($specDetails['biologicalSource']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Biological Source: ',0,0);$pdf->SetFont('Arial','',9);$pdf->SetFont('Arial','I',9);$pdf->Cell(0,5,$specDetails['biologicalSource'],0,1);$pdf->SetFont('Arial','',9);}
		if($specDetails['productDescription']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Product Code:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$specDetails['productCode'],0,1);}
		if($details['ourBatch']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Batch Number:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$details['ourBatch'],0,1);}
		if($batch['bbe']<>NULL AND $batch['bbe']>'1970-01-01'){$bbe = explode("-",$batch['bbe']);$bbe = "$bbe[2]/$bbe[1]/$bbe[0]";$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'BBE:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$bbe,0,1);}
		if($specDetails['productDescription']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Plant Part: ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$specDetails['plantPart'],0,1);}
		if($details['countryOfOrigin']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Country of Origin:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$details['countryOfOrigin'],0,1);}
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'Product Description',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['colour']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Colour:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$details['colour'],0,1);}
		if($details['odour']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Odour:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$details['odour'],0,1);}
		if($details['taste']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Taste:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$details['taste'],0,1);}
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'Identification',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['macroscopic']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Macroscopic Characters:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$details['macroscopic'],0,1);}
		if($details['microscopic']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Microscopic Characters:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$details['microscopic'],0,1);}
		
		if($details['foreignMatterAmount']<>'' AND $details['lossOnDryingAmount']<>'' AND $details['totalAshAmount']<>''){	
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(0,10,'Tests',0,1);
			$pdf->SetFont('Arial','',9);	
			$header = array('Test','Result','Specification');
			$data = '';
			if($details['foreignMatterAmount']<>''){
				$data = $data."Foreign Matter,$details[foreignMatterAmount],$specDetails[foreignMatter];";
			}
			if($details['lossOnDryingAmount']<>''){
				$data = $data."Loss On Drying,$details[lossOnDryingAmount],$specDetails[lossOnDrying];";
			}
			if($details['totalAshAmount']<>''){
				$data = $data."Total Ash,$details[totalAshAmount],$specDetails[totalAsh];";
			}
			$data = substr($data,0,-1);
			$pdf->BasicTable($header,$data);
			$pdf->Cell(0,3,'',0,1);
		}

		$pdf->SetFont('Arial','B',11);
		if($details['box1']<>''){
			$pdf->Cell(0,10,'Content',0,1);
			$pdf->SetFont('Arial','',9);
			$pdf->WriteHTML(nl2br($details['box1']));
			$pdf->Cell(0,5,'',0,1);
		}
	
		if($details['leadAmount']<>'' AND $details['arsenicAmount']<>'' AND $details['mercuryAmount']<>''){
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(0,10,'Toxic (Heavy) Metals',0,1);
			$pdf->SetFont('Arial','',9);
			$header = array('Metal','Result','Specification');
			$data = '';
			if($details['leadAmount']<>''){
				$data = $data."Lead (PB),".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['leadAmount']).",".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$specDetails['leadPb']).";";
			}
			if($details['arsenicAmount']<>''){
				$data = $data."Arsenic (AS),".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['arsenicAmount']).",".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$specDetails['arsenicAs']).";";
			}
			if($details['mercuryAmount']<>''){
				$data = $data."Mercury (Hg),".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['mercuryAmount']).",".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$specDetails['mercuryHg']).";";
			}
			$data = substr($data,0,-1);
			$pdf->BasicTable($header,$data);
			$pdf->Cell(0,3,'',0,1);
		}
		
		if($details['box2']<>''){
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(0,5,'Additional Heavy Metals Notes:',0,1);
			$pdf->SetFont('Arial','',9);
			$pdf->WriteHTML(nl2br($details['box2']));
			$pdf->Cell(0,5,'',0,1);
		}
		
		
		if($details['totalAerobicAmount']<>'' OR $details['totalCombinedYeastMouldAmount']<>'' OR $details['enteroBacteriaAmount']<>'' OR $details['escherichiaAmount']<>'' OR $details['salmonellaAmount']<>'' OR $details['staphylococcusAmount']<>''){
			$pdf->SetFont('Arial','B',11);
			$pdf->Cell(0,10,'Microbial Levels',0,1);
			$pdf->SetFont('Arial','',9);
			$header = array('Metal','Result','Specification');
			$data = '';
			if($details['totalAerobicAmount']<>''){
				$data = $data."Total Aerobic Microbial Count,".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['totalAerobicAmount']).",".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$specDetails['totalAerobicMicrobialCount']).";";
			}
			if($details['totalCombinedYeastMouldAmount']<>''){
				$data = $data."Total Combined Yeast/Moulds Count,".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['totalCombinedYeastMouldAmount']).",".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$specDetails['totalCombinedYeastMouldsCount']).";";
			}
			if($details['enteroBacteriaAmount']<>''){
				$data = $data."Enterocateria Count (including Pseudomonas),".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['enteroBacteriaAmount']).",".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$specDetails['enterobacteriaCountIncludingPseudomonas']).";";	
			}
			if($details['escherichiaAmount']<>''){
				$data = $data."Escherichia Coli,".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['escherichiaAmount']).",".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$specDetails['escherichiaColi']).";";
			}
			if($details['salmonellaAmount']<>''){
				$data = $data."Salmonella,".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['salmonellaAmount']).",".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$specDetails['salmonella']).";";
			}
			if($details['staphylococcusAmount']<>''){
				$data = $data."Staphylococcus Aureus,".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['staphylococcusAmount']).",".iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$specDetails['staphylococcusAureus']).";";
			}
			$data = substr($data,0,-1);
			$pdf->BasicTable($header,$data);
		
		}
		
		$pdf->Cell(0,3,'',0,1);
		if($details['box3']<>''){
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(0,5,'Additional Microbial Information:',0,1);
			$pdf->SetFont('Arial','',9);
			$pdf->WriteHTML(nl2br($details['box3']));
			$pdf->Cell(0,5,'',0,1);
		}
		if($details['mycotoxinsAmount']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Mycotoxins (Aflatoxins, Ochratoxin A): ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['mycotoxinsAmount']),0,1);}
		if($details['pesticidesAmount']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Pesticides: ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['pesticidesAmount']),0,1);}
		if($details['box4']<>''){
			$pdf->SetFont('Arial','B',9);
			$pdf->Cell(0,5,'Additional Pesticide Notes:',0,1);
			$pdf->SetFont('Arial','',9);
			$pdf->WriteHTML(nl2br($details['box4']));
			$pdf->Cell(0,5,'',0,1);
		}
		if($details['allergensPresent']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Allergens: ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['allergensPresent']),0,1);}
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'',0,1);
		$pdf->SetFont('Arial','',9);
		
		$thisDate = explode("-",$details['dateEntered']);
		$thisDate = "$thisDate[2]/$thisDate[1]/$thisDate[0]";
		
		$pdf->WriteHTML("<b>Storage</b><br>Store in cool and dry condition. Keep away from direct sunlight and heat.<br><br><b>Labels</b><br>Label contains following information:<br>1. Manufacturing company name<br>2. Type of product and product code<br>3. Product Latin and common name<br>4. Product strength <br>5. Pack size<br>6. Best before date<br>7. Contact information<br><br><b>Allergen Statement</b><b>: </b>Unless otherwise stated, the products supplied are to the best of our knowledge free from nut, nut derivatives and allergens. Herbal Apothecary does handle some nut and allergen products but follows careful handling and segregation procedures. However, due to the nature of the products supplied, it is impossible for the Company to absolutely guarantee that no cross contamination has taken place at some point in the supply chain prior to delivery at our premises.<br><br><b>Non-GM Statement</b>: This product is produced or derived from ingredients supplied from non-GM sources. This is verified by our suppliers' statements and IP certificates where applicable.<br><br><b>Animal non testing statement</b>: We provide the best assurance that no animal testing is used in any phase of product development by the company, its laboratories.<br><br><b>BSE TSE Statement</b>: This is to certify that the products listed above are produced entirely from materials of natural/herbal origin and therefore are free from human or any other animal derived materials including bovine products. In addition, there are no animal derived components used in the manufacturing or handling processes of this product. As such, this material can be declared free of Bovine Spongiform Encephalopathy (BSE) and Transmissible Spongiform Encephalopathy (TSE).<br><br><b>Irradiation statement</b>: In order to address the concerns of the consumer and to ensure compliance with the legislation, Nature's Laboratory do not trade herbs have been irradiated. Purchasing specifications stipulate that irradiated herbs and spices are not acceptable, and this is checked during supplier audits at origin and processing plants.<br><br><b>Use in Production</b>: If the goods or any part thereof supplied under the contract are processed, altered or tampered with in any way by the buyer or receiver of the goods or any other person, the quality of the goods shall be deemed to be acceptable by the buyer. All customers' quality checks are to be completed on the entire load prior to production and use.<br><br><b>Additional information</b><br>1. Our product does not contain any restricted ingredients such as preservatives, additives etc.<br>2. Product consumed by general public after prescribed by herbalist or suitably qualified person.<br>3. All statements contained in this document reflect our current state of knowledge and experience, and are intended - and to be viewed - as information about this respective product only. As such, they do not constitute an exempt from any customer obligation to conduct own testing. Also, compliance with all regulations legally relevant to further processing shall be incumbent upon the customer and/or user of this product.<br><br><b>Date:</b> $thisDate<br><br>Prepared By<br><b><i>Shankar Katekhaye</i></b><br>Quality Manager");
		
		$pdf->Output('D',"Natures Laboratory COA - $specDetails[commonName].pdf");
		exit();
		
    }