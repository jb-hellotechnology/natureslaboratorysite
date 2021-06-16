<?php
    
    $NaturesLaboratoryCOA = new Natures_Laboratory_COAs($API);
    $NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Specs($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $coa = array();
    $coa = $NaturesLaboratoryCOA->getCOAs();
    
    if($Form->submitted()){
	   	$postvars = array('coa');	   
    	$data = $Form->receive($postvars);   
    	$coa = $data['coa'];
    	
    	$coaData = $NaturesLaboratoryCOA->find($coa,true);
    	$details = $coaData->to_array();
    	
    	$specDetails = $NaturesLaboratoryCOASpec->byCode($details['productCode']);
    	
    	class PDF extends FPDF
		{
			// Page header
			function Header()
			{
			    
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

		}
		
		$pdf = new PDF();
		$pdf->AddPage();
		$pdf->Image('../nl_logo.jpg',10,10,0,20);
		$pdf->SetFont('Arial','',8);
		$pdf->Cell(0,3,"Nature's Laboratory",0,1,'R');
		$pdf->Cell(0,3,"Unit 3B, Enterprise Way",0,1,'R');
		$pdf->Cell(0,3,"Whitby",0,1,'R');
		$pdf->Cell(0,3,"North Yorkshire",0,1,'R');
		$pdf->Cell(0,3,"YO22 4NH",0,1,'R');
		$pdf->Cell(0,6,iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE','01947 602346  |  info@natureslaboratory.co.uk  |  natureslaboratory.co.uk'),0,1,'R');
		
		$pdf->SetXY(10, 35);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Certificate of Analysis: '.$specDetails['commonName'],0,1);
		$pdf->SetFont('Arial','',8);
		if($specDetails['productDescription']<>''){$pdf->Cell(0,5,'Product Description: '.$specDetails['productDescription'],0,1);}
		if($specDetails['biologicalSource']<>''){$pdf->Cell(0,5,'Biological Source: '.$specDetails['biologicalSource'],0,1);}
		if($specDetails['productDescription']<>''){$pdf->Cell(0,5,'Product Code:  '.$specDetails['productCode'],0,1);}
		if($details['ourBatch']<>''){$pdf->Cell(0,5,'Batch Number:  '.$details['ourBatch'],0,1);}
		if($specDetails['productDescription']<>''){$pdf->Cell(0,5,'Plant Part: '.$specDetails['plantPart'],0,1);}
		if($details['countryOfOrigin']<>''){$pdf->Cell(0,5,'Country of Origin:  '.$details['countryOfOrigin'],0,1);}
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'Product Description',0,1);
		$pdf->SetFont('Arial','',8);
		if($details['colour']<>''){$pdf->Cell(0,5,'Colour:  '.$details['colour'],0,1);}
		if($details['odour']<>''){$pdf->Cell(0,5,'Odour:  '.$details['odour'],0,1);}
		if($details['taste']<>''){$pdf->Cell(0,5,'Taste:  '.$details['taste'],0,1);}
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'Identification',0,1);
		$pdf->SetFont('Arial','',8);
		if($details['macroscopic']<>''){$pdf->Cell(0,5,'Macroscopic Characters:  '.$details['macroscopic'],0,1);}
		if($details['microscopic']<>''){$pdf->Cell(0,5,'Microscopic Characters:  '.$details['microscopic'],0,1);}
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'Tests',0,1);
		$pdf->SetFont('Arial','',8);
		if($details['foreignMatterAmount']<>''){$pdf->Cell(0,5,'Foreign Matter:  '.$details['foreignMatterAmount'],0,1);}
		if($details['lossOnDryingAmount']<>''){$pdf->Cell(0,5,'Loss on Drying:  '.$details['lossOnDryingAmount'],0,1);}
		if($details['totalAshAmount']<>''){$pdf->Cell(0,5,'Total Ash:  '.$details['totalAshAmount'],0,1);}
		$pdf->SetFont('Arial','B',11);
		if($details['box1']<>''){
			$pdf->Cell(0,10,'Content',0,1);
			$pdf->SetFont('Arial','',8);
			$pdf->WriteHTML(nl2br($details['box1']));
			$pdf->Cell(0,5,'',0,1);
		}
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'Toxic (Heavy) Metals',0,1);
		$pdf->SetFont('Arial','',8);
		if($details['leadAmount']<>''){$pdf->Cell(0,5,'Lead (Pb): '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['leadAmount']),0,1);}
		if($details['arsenicAmount']<>''){$pdf->Cell(0,5,'Arsenic (As): '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['arsenicAmount']),0,1);}
		if($details['mercuryAmount']<>''){$pdf->Cell(0,5,'Mercury (Hg): '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['mercuryAmount']),0,1);}
		if($details['box1']<>''){
			$pdf->Cell(0,5,'Additional Heavy Metals Notes:',0,1);
			$pdf->WriteHTML(nl2br($details['box2']));
			$pdf->Cell(0,5,'',0,1);
		}
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'Microbial Levels',0,1);
		$pdf->SetFont('Arial','',8);
		if($details['totalAerobicAmount']<>''){$pdf->Cell(0,5,'Total Aerobic Microbial Count: '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['totalAerobicAmount']),0,1);}
		if($details['totalCombinedYeastMouldAmount']<>''){$pdf->Cell(0,5,'Total Combined Yeast/Moulds Count: '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['totalCombinedYeastMouldAmount']),0,1);}
		if($details['enteroBacteriaAmount']<>''){$pdf->Cell(0,5,'Enterocateria Count (including Pseudomonas): '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['enteroBacteriaAmount']),0,1);}
		if($details['escherichiaAmount']<>''){$pdf->Cell(0,5,'Escherichia Coli: '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['escherichiaAmount']),0,1);}
		if($details['salmonellaAmount']<>''){$pdf->Cell(0,5,'Salmonella: '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['salmonellaAmount']),0,1);}
		if($details['staphylococcusAmount']<>''){$pdf->Cell(0,5,'Staphylococcus Aureus: '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['staphylococcusAmount']),0,1);}
		if($details['box3']<>''){
			$pdf->Cell(0,5,'Additional Microbial Information:',0,1);
			$pdf->WriteHTML(nl2br($details['box3']));
			$pdf->Cell(0,5,'',0,1);
		}
		if($details['mycotoxinsAmount']<>''){$pdf->Cell(0,5,'Mycotoxins (Aflatoxins, Ochratoxin A): '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['mycotoxinsAmount']),0,1);}
		if($details['pesticidesAmount']<>''){$pdf->Cell(0,5,'Pesticides: '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['pesticidesAmount']),0,1);}
		if($details['box1']<>''){
			$pdf->Cell(0,5,'Additional Pesticide Notes:',0,1);
			$pdf->WriteHTML(nl2br($details['box4']));
			$pdf->Cell(0,5,'',0,1);
		}
		if($details['allergensPresent']<>''){$pdf->Cell(0,5,'Allergens: '.iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$details['allergensPresent']),0,1);}
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'',0,1);
		$pdf->SetFont('Arial','',8);
		$pdf->WriteHTML("<b>Storage</b><br>Store in cool and dry condition. Keep away from direct sunlight and heat.<br><br><b>Labels</b><br>Label contains following information:<br>1. Manufacturing company name<br>2. Type of product and product code<br>3. Product Latin and common name<br>4. Product strength <br>5. Pack size<br>6. Best before date<br>7. Contact information<br><br><b>Allergen Statement</b><b>: </b>Unless otherwise stated, the products supplied are to the best of our knowledge free from nut, nut derivatives and allergens. Herbal Apothecary does handle some nut and allergen products but follows careful handling and segregation procedures. However, due to the nature of the products supplied, it is impossible for the Company to absolutely guarantee that no cross contamination has taken place at some point in the supply chain prior to delivery at our premises.<br><br><b>Non-GM Statement</b>: This product is produced or derived from ingredients supplied from non-GM sources. This is verified by our suppliers' statements and IP certificates where applicable.<br><br><b>Animal non testing statement</b>: We provide the best assurance that no animal testing is used in any phase of product development by the company, its laboratories.<br><br><b>BSE TSE Statement</b>: This is to certify that the products listed above are produced entirely from materials of natural/herbal origin and therefore are free from human or any other animal derived materials including bovine products. In addition, there are no animal derived components used in the manufacturing or handling processes of this product. As such, this material can be declared free of Bovine Spongiform Encephalopathy (BSE) and Transmissible Spongiform Encephalopathy (TSE).<br><br><b>Irradiation statement</b>: In order to address the concerns of the consumer and to ensure compliance with the legislation, Nature's Laboratory do not trade herbs have been irradiated. Purchasing specifications stipulate that irradiated herbs and spices are not acceptable, and this is checked during supplier audits at origin and processing plants.<br><br><b>Use in Production</b>: If the goods or any part thereof supplied under the contract are processed, altered or tampered with in any way by the buyer or receiver of the goods or any other person, the quality of the goods shall be deemed to be acceptable by the buyer. All customers' quality checks are to be completed on the entire load prior to production and use.<br><br><b>Additional information</b><br>1. Our product does not contain any restricted ingredients such as preservatives, additives etc.<br>2. Product consumed by general public after prescribed by herbalist or suitably qualified person.<br>3. All statements contained in this document reflect our current state of knowledge and experience, and are intended - and to be viewed - as information about this respective product only. As such, they do not constitute an exempt from any customer obligation to conduct own testing. Also, compliance with all regulations legally relevant to further processing shall be incumbent upon the customer and/or user of this product.<br><br>");
		
		$pdf->Output('D',"Natures Laboratory COA - $specDetails[commonName].pdf");
		exit();
		
    }