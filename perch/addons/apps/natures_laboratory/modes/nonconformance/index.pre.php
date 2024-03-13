<?php
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
*/   
    if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
    
    $NaturesLaboratoryNonconformances = new Natures_Laboratory_Nonconformances($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $nonconformances = array();
    $nonconformances = $NaturesLaboratoryNonconformances->getNonconformances($_GET['q']);
    
    if($Form->submitted()) {
		$postvars = array('download');	   
    	$data = $Form->receive($postvars);   
    	$nonconformance = $data['download'];
    	
    	$nonconformanceData = $NaturesLaboratoryNonconformances->find($nonconformance,true);
    	$details = $nonconformanceData->to_array();
    	
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
		$pdf->Cell(0,10,'Non Conformance: '.$details['title'],0,1);
		$pdf->Line(0,44,300,44);
		$pdf->SetFont('Arial','',9);
		
		$thisDate = explode("-",$details['date']);
		$thisDate = "$thisDate[2]/$thisDate[1]/$thisDate[0]";
		
		$dynamic = json_decode($details['natures_laboratory_nonconformanceDynamicFields'],true);
		
		$section1 = $dynamic['textarea']['processed'];
		
		$pdf->WriteHTML("
<b>Textarea</b><br>
$section1<br><br />");

		foreach($dynamic['images'] as $image){
			//print_r($image);
			//print_r($image['image']['_default']);
			$pdf->Cell( 200, 80, $pdf->Image("../../../..".$image['image']['_default'], $pdf->GetX(), $pdf->GetY(), 180), 0, 1, 'L', false);
		}

		$pdf->WriteHTML("
<b>Date:</b> $thisDate<br><br>
<b><i>Shankar Katekhaye</i></b><br>
Quality Manager");
		
		$pdf->Output('D',"Natures Laboratory Non Conformance - $nonconformance.pdf");
		exit();
		
	}