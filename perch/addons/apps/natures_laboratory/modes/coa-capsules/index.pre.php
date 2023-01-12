<?php
	ini_set('display_errors', 1);
/*
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
	if (!$CurrentUser->has_priv('natures_laboratory.coa')) exit;
    
    $NaturesLaboratoryCOA = new Natures_Laboratory_COA_Capsules($API);
    $NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Capsules_Specs($API);
    $NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API);
    
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
    	
    	$specDetails = $NaturesLaboratoryCOASpec->byCode($details['spec']);
    	
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
			    $w = array(70, 50);
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
			
			function BasicTable2($header, $data)
			{
			    // Colors, line width and bold font
			    $this->SetFillColor(62,111,94);
			    $this->SetTextColor(255);
			    $this->SetDrawColor(0,0,0);
			    $this->SetLineWidth(.3);
			    $this->SetFont('','B');
			    // Header
			    $w = array(40,40,40,40);
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
		$pdf->Image('../nl_logo.jpg',10,10,0,20);
		$pdf->Line(0,35,300,35);
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(0,3,"Nature's Laboratory",0,1,'R');
		$pdf->Cell(0,3,"Unit 3B, Enterprise Way",0,1,'R');
		$pdf->Cell(0,3,"Whitby",0,1,'R');
		$pdf->Cell(0,3,"North Yorkshire",0,1,'R');
		$pdf->Cell(0,3,"YO22 4NH",0,1,'R');
		$pdf->Cell(0,6,iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE','01947 602346  |  info@natureslaboratory.co.uk  |  natureslaboratory.co.uk'),0,1,'R');
		
		$components = json_decode($specDetails['natures_laboratory_coa_capsules_specDynamicFields'],true);
		
		$pdf->SetXY(10, 35);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(0,10,'Certificate of Analysis: '.$details['spec'].' '.$components['commonname'],0,1);

		if($details['image']['_default']<>''){
			$pdf->Image("../../../../../perch/resources/".$details['image']['path'],140,50,0,40);
		}
		
		$manDate = explode("-",$details['dateManufacture']);
		$manDate = "$manDate[2]/$manDate[1]/$manDate[0]";
		
		$bbeDate = explode("-",$details['bbe']);
		$bbeDate = "$bbeDate[2]/$bbeDate[1]/$bbeDate[0]";
		
		$pdf->Line(0,44,300,44);
		$pdf->SetFont('Arial','',9);
		$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Product Description: ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(100,5,'Capsule',0,1);
		$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Product Batch Number: ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(100,5,$details['ourBatch'],0,1);
		$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Date of Manufacturing: ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(100,5,$manDate,0,1);
		$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Best Before Use Date: ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(100,5,$bbeDate,0,1);
		$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Country of Manufacture: ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(100,5,'United Kingdom',0,1);

		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'Product Description',0,1);
		$pdf->SetFont('Arial','',9);
		if($details['colour']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Colour:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$details['colour'],0,1);}
		if($details['odour']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Odour:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$details['odour'],0,1);}
		if($details['taste']<>''){$pdf->SetFont('Arial','B',9);$pdf->Cell(60,5,'Taste:  ',0,0);$pdf->SetFont('Arial','',9);$pdf->Cell(0,5,$details['taste'],0,1);}

		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'Composition',0,1);
		$pdf->SetFont('Arial','',9);
		$header = array('Product Code','Botanical Source','Plant Part','Quantity Ratio');
		$data = '';
		
		foreach($components['components'] as $component){
			$data .= "$component[productCode],$component[botanicalSource],$component[plantPart],$component[quantityRatio],";
		}
		$data = substr($data,0,-1);
		$pdf->BasicTable2($header,$data);
		$pdf->Cell(0,3,'',0,1);
		
		
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0,10,'Contaminants / Impurities',0,1);
		$pdf->SetFont('Arial','',9);
		$pdf->WriteHTML("Testing for inorganic impurities, toxic (heavy) metals, microbial limits, mycotoxins and pesticides are carried out on a batch by batch basis according to specific customer requirements. These will normally be in line with British Pharmacopoeia limits. Nature's Laboratory Ltd do not knowingly supply material containing pesticide residues above the legal maximum residue levels.");	
		
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(0,10,'',0,1);
		
		$thisDate = explode("-",$components['dateCreated']);
		$thisDate = "$thisDate[2]/$thisDate[1]/$thisDate[0]";
		
		$pdf->WriteHTML("<b>Storage</b><br>Store in cool and dry condition. Keep away from direct sunlight and heat.<br><br><b>Labels</b><br>Label contains following information:<br>1. Manufacturing company name<br>2. Type of product and product code<br>3. Product Latin and common name<br>4. Product strength <br>5. Pack size<br>6. Best before date<br>7. Contact information<br><br><b>Allergens</b><br><br>");
		
		$header = array('Allergen Type','Present');
		$data = 'Cereal/Wheat Products,No;Seafood and Shellfish,No;Egg Products,No;Fish and Fish Products,No;Lupin (i.e. Lupin Flour),No;Milk and Dairy Products,No;Molluscs (inc. Squid and Octopus),No;Nut and Nut Products,No;Peanuts and Peanut Products,No;Soybean and Soybean Products,No;Sesame Seed and Products Thereof,No;Celery and Products Thereof,No;Mustard and Products Thereof,No;Animal Products,No';
		$pdf->BasicTable($header,$data);
		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(0,10,'',0,1);
		
		$pdf->WriteHTML("<b>Allergen Statement</b><b>: </b>Unless otherwise stated, the products supplied are to the best of our knowledge free from nut, nut derivatives and allergens. Herbal Apothecary does handle some nut and allergen products but follows careful handling and segregation procedures. However, due to the nature of the products supplied, it is impossible for the Company to absolutely guarantee that no cross contamination has taken place at some point in the supply chain prior to delivery at our premises.<br><br><b>Non-GM Statement</b>: This product is produced or derived from ingredients supplied from non-GM sources. This is verified by our suppliers' statements and IP certificates where applicable.<br><br><b>Animal non testing statement</b>: We provide the best assurance that no animal testing is used in any phase of product development by the company, its laboratories.<br><br><b>BSE TSE Statement</b>: This is to certify that the products listed above are produced entirely from materials of natural/herbal origin and therefore are free from human or any other animal derived materials including bovine products. In addition, there are no animal derived components used in the manufacturing or handling processes of this product. As such, this material can be declared free of Bovine Spongiform Encephalopathy (BSE) and Transmissible Spongiform Encephalopathy (TSE).<br><br><b>Irradiation statement</b>: In order to address the concerns of the consumer and to ensure compliance with the legislation, Nature's Laboratory do not trade herbs have been irradiated. Purchasing specifications stipulate that irradiated herbs and spices are not acceptable, and this is checked during supplier audits at origin and processing plants.<br><br><b>Use in Production</b>: If the goods or any part thereof supplied under the contract are processed, altered or tampered with in any way by the buyer or receiver of the goods or any other person, the quality of the goods shall be deemed to be acceptable by the buyer. All customers' quality checks are to be completed on the entire load prior to production and use.<br><br><b>Additional information</b><br>1. Our product does not contain any restricted ingredients such as preservatives, additives etc.<br>2. Product consumed by general public after prescribed by herbalist or suitably qualified person.<br>3. All statements contained in this document reflect our current state of knowledge and experience, and are intended - and to be viewed - as information about this respective product only. As such, they do not constitute an exempt from any customer obligation to conduct own testing. Also, compliance with all regulations legally relevant to further processing shall be incumbent upon the customer and/or user of this product.<br><br><b>Date:</b> $thisDate<br><br>Prepared By<br><b><i>Shankar Katekhaye</i></b><br>Quality Manager");
		
		$pdf->Output('D',"Natures Laboratory COA - $details[ourBatch].pdf");
		exit();
		
    }