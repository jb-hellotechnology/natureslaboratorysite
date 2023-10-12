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
	    	
	    	$labelList = array();

	    	foreach($data as $key => $value){

		    	$parts = explode('_',$key);
		    	if(count($parts)>1){
			    	$batchData = $NaturesLaboratoryLabels->getLabelData($parts[1]);
			    	$totalLabels = $totalLabels+$batchData['quantity'];
			    	$q = 0;
			    	while($q<$batchData['quantity']){
			    		array_push($labelList,'pngs/'.$parts[1].'/label.png');
			    		$q++;
			    	}
		    	}
		    	
			}
			
			$currentLabel = 0;
			$firstLabel = $data['start'];
			$pageLabel = $firstLabel;
			
			//print_r($labelList);
			
			$pdf = new FPDF('L', 'in', array(4,3));

			while($currentLabel<$totalLabels){
				$pdf->AddPage();
				$labelBg = $labelList[$currentLabel];
				$pdf->Image($labelBg,0,0,4,3);
				$currentLabel++;
			}
	
			$pdf->Output("D", "labels.pdf");
			
/*
			$pdf = new FPDF();
			$pdf->AddPage();

			while($currentLabel<$totalLabels){
				$labelBg = $labelList[$currentLabel];
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
*/

	    
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
				
				array_map('unlink', glob("pngs/$labelsID/*.*"));
				rmdir('pngs/'.$labelsID);
		    	
			}   
			
			$labels = $NaturesLaboratoryLabels->getLabels();
			
	    }
    	
	}