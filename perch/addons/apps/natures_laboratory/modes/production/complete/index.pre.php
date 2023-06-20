<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
	
	$NaturesLaboratoryProduction = new Natures_Laboratory_Productions($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    $Template->set('natures_laboratory/production_wpo.html','nl');
    
    $task = $NaturesLaboratoryProduction->find($_GET['id'], true);

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('status', 'unitsMade', 'packagingNotes', '250ml', '500ml', '1000ml', '5l', '25l', 'other', 'bbe_day', 'bbe_month', 'bbe_year', 'completedBy');	   
    	$data = $Form->receive($postvars);     
    	
    	$data['bbe'] = "$data[bbe_year]-$data[bbe_month]-$data[bbe_day]";
    	$productBBE = "$data[bbe_month]/$data[bbe_year]";
    	unset($data['bbe_year']);
    	unset($data['bbe_month']);
    	unset($data['bbe_day']);
    	
    	if(!$data['250ml']){unset($data['250ml']);}
    	if(!$data['500ml']){unset($data['500ml']);}
    	if(!$data['1000ml']){unset($data['1000ml']);}
    	if(!$data['5l']){unset($data['5l']);}
    	if(!$data['25l']){unset($data['25l']);}
    	if(!$data['other']){unset($data['other']);}
    	
    	$data['completedDate'] = date('Y-m-d');

        $new_task = $task->update($data);
        
        //STORE FORMULATION
        $NaturesLaboratoryProduction->storeFormulation($_GET['id']);
        
        //CREATE LABELS
        $process = $NaturesLaboratoryProduction->getProcess($_GET['id']);
        $product = $NaturesLaboratoryProduction->getProduct($process['sku']);
        $labelSpec = $NaturesLaboratoryProduction->getLabelSpec($product['STOCK_CODE']);
       
        $productType = '';
        if($product['STOCK_CAT']=='2'){$productType = 'TINCTURE';}
        if($product['STOCK_CAT']=='4'){$productType = 'FLUID EXTRACT';}
        if($product['STOCK_CAT']=='8'){$productType = 'CAPSULES';}
        if($product['STOCK_CAT']=='10'){$productType = 'BEEVITAL';}
        if($product['STOCK_CAT']=='11'){$productType = 'CREAM';}
        
        $productName = $product['DESCRIPTION'];
        $productCode = $product['STOCK_CODE'];
        $productNotes = $labelSpec['notes'];
        $productOrganic = $labelSpec['organic'];
        $productRestriction = $labelSpec['restriction'];
        
        $batch = "$process[batchPrefix]$process[finishedBatch]";
        
        // GET BG IMAGE
        $productLabel = '../../label_standard.jpg';
        if($productOrganic == 'organic' AND $productRestriction==''){
	        $productLabel = '../../label_organic.jpg';
        }elseif($productRestriction == 'allergen' AND $productOrganic==''){
	        $productLabel = '../../label_allergen.jpg';
        }elseif($productRestriction == 'poison' AND $productOrganic==''){
	        $productLabel = '../../label_poison.jpg';
        }elseif($productOrganic=='organic' AND $productRestriction=='allergen'){
	        $productLabel = '../../label_organic_allergen.jpg';
        }elseif($productOrganic=='organic' AND $productRestriction=='poison'){
	        $productLabel = '../../label_organic_poison.jpg';
        }
        
        // CREATE FOLDER
		mkdir("../productlabels/$_GET[id]", 0755);
		$url = "../productlabels/$_GET[id]";
		
		$name = wordwrap($product['DESCRIPTION'], 22, "<br />");
		$nameLines = explode("<br />", $name);
		
		$notes = wordwrap($labelSpec['notes'], 46, "<br />");
		$notesLines = explode("<br />", $notes);
		
		$totalLabel = 1;
		$label = 1;
		while($label<=$data['250ml']){
			
			// Create the image
			$im = imagecreatetruecolor(1171, 800);
			
			// Create some colors
			$green = imagecolorallocate($im, 001, 149, 135);
			
			// Replace path by your own font path
			$fontLight = '../../Helvetica.ttf';
			$fontHeavy = '../../Helvetica-Bold.ttf';
			
			// Copy the stamp image onto our photo using the margin offsets and the photo 
			// width to calculate positioning of the stamp. 
			$background = imagecreatefromjpeg($productLabel);
			imagecopy($im, $background, 0, 0, 0, 0, 1171, 800);
			
			// Add the text
			imagettftext($im, 28, 0, 40, 280, $green, $fontHeavy, ucwords($productType)."          ".ucwords($productCode));
			
			$lineStart = 360;
			foreach($nameLines as $line){
				$line = trim($line);
				imagettftext($im, 40, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 65;
			}
			
			foreach($notesLines as $line){
				$line = trim($line);
				imagettftext($im, 20, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 26;
			}
			
			imagettftext($im, 20, 0, 40, 710, $green, $fontHeavy, "Batch");
			imagettftext($im, 28, 0, 40, 750, $green, $fontLight, "$process[batchPrefix]$process[finishedBatch]");
			
			imagettftext($im, 20, 0, 270, 710, $green, $fontHeavy, "BBE");
			imagettftext($im, 28, 0, 270, 750, $green, $fontLight, "$productBBE");
			
			imagettftext($im, 20, 0, 500, 710, $green, $fontHeavy, "Size");
			imagettftext($im, 28, 0, 500, 750, $green, $fontLight, "250ml");
			
			$codeContents = "https://natureslaboratory.co.uk/perch/addons/apps/natures_laboratory/products/go/?id=".$batch."&size=250ml&bbe=".$productBBE;
		    $fileName = 'qr_'.str_replace("/","-",$batch).'.png';
		    QRcode::png($codeContents, $fileName, QR_ECLEVEL_L, 6);
		    $qr = imagecreatefrompng($fileName);
		    imagecopyresized($im, $qr, 860, 238, 0, 0, 280, 280, 300, 300);
			unlink($fileName);
			
			// Output and free memory
			imagepng($im,"../productlabels/$_GET[id]/label_250ml_".$totalLabel.'.png');
			
			$totalLabel++;
			$label++;
		
		}
		
		$label = 1;
		while($label<=$data['500ml']){
			
			// Create the image
			$im = imagecreatetruecolor(1171, 800);
			
			// Create some colors
			$green = imagecolorallocate($im, 001, 149, 135);
			
			// Replace path by your own font path
			$fontLight = '../../Helvetica.ttf';
			$fontHeavy = '../../Helvetica-Bold.ttf';
			
			// Copy the stamp image onto our photo using the margin offsets and the photo 
			// width to calculate positioning of the stamp. 
			$background = imagecreatefromjpeg($productLabel);
			imagecopy($im, $background, 0, 0, 0, 0, 1171, 800);
			
			// Add the text
			imagettftext($im, 28, 0, 40, 280, $green, $fontHeavy, ucwords($productType)."          ".ucwords($productCode));
			
			$lineStart = 360;
			foreach($nameLines as $line){
				$line = trim($line);
				imagettftext($im, 40, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 65;
			}
			
			foreach($notesLines as $line){
				$line = trim($line);
				imagettftext($im, 20, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 26;
			}
			
			imagettftext($im, 20, 0, 40, 710, $green, $fontHeavy, "Batch");
			imagettftext($im, 28, 0, 40, 750, $green, $fontLight, "$process[batchPrefix]$process[finishedBatch]");
			
			imagettftext($im, 20, 0, 270, 710, $green, $fontHeavy, "BBE");
			imagettftext($im, 28, 0, 270, 750, $green, $fontLight, "$productBBE");
			
			imagettftext($im, 20, 0, 500, 710, $green, $fontHeavy, "Size");
			imagettftext($im, 28, 0, 500, 750, $green, $fontLight, "500ml");
			
			$codeContents = "https://natureslaboratory.co.uk/perch/addons/apps/natures_laboratory/products/go/?id=".$batch."&size=500ml&bbe=".$productBBE;
		    $fileName = 'qr_'.str_replace("/","-",$batch).'.png';
		    QRcode::png($codeContents, $fileName, QR_ECLEVEL_L, 6);
		    $qr = imagecreatefrompng($fileName);
		    imagecopyresized($im, $qr, 860, 238, 0, 0, 280, 280, 300, 300);
			unlink($fileName);
			
			// Output and free memory
			imagepng($im,"../productlabels/$_GET[id]/label_500ml_".$totalLabel.'.png');
			
			$totalLabel++;
			$label++;
		
		}
		
		$label = 1;
		while($label<=$data['1000ml']){
			
			// Create the image
			$im = imagecreatetruecolor(1171, 800);
			
			// Create some colors
			$green = imagecolorallocate($im, 001, 149, 135);
			
			// Replace path by your own font path
			$fontLight = '../../Helvetica.ttf';
			$fontHeavy = '../../Helvetica-Bold.ttf';
			
			// Copy the stamp image onto our photo using the margin offsets and the photo 
			// width to calculate positioning of the stamp. 
			$background = imagecreatefromjpeg($productLabel);
			imagecopy($im, $background, 0, 0, 0, 0, 1171, 800);
			
			// Add the text
			imagettftext($im, 28, 0, 40, 280, $green, $fontHeavy, ucwords($productType)."          ".ucwords($productCode));
			
			$lineStart = 360;
			foreach($nameLines as $line){
				$line = trim($line);
				imagettftext($im, 40, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 65;
			}
			
			foreach($notesLines as $line){
				$line = trim($line);
				imagettftext($im, 20, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 26;
			}
			
			imagettftext($im, 20, 0, 40, 710, $green, $fontHeavy, "Batch");
			imagettftext($im, 28, 0, 40, 750, $green, $fontLight, "$process[batchPrefix]$process[finishedBatch]");
			
			imagettftext($im, 20, 0, 270, 710, $green, $fontHeavy, "BBE");
			imagettftext($im, 28, 0, 270, 750, $green, $fontLight, "$productBBE");
			
			imagettftext($im, 20, 0, 500, 710, $green, $fontHeavy, "Size");
			imagettftext($im, 28, 0, 500, 750, $green, $fontLight, "1000ml");
			
			$codeContents = "https://natureslaboratory.co.uk/perch/addons/apps/natures_laboratory/products/go/?id=".$batch."&size=1000ml&bbe=".$productBBE;
		    $fileName = 'qr_'.str_replace("/","-",$batch).'.png';
		    QRcode::png($codeContents, $fileName, QR_ECLEVEL_L, 6);
		    $qr = imagecreatefrompng($fileName);
		    imagecopyresized($im, $qr, 860, 238, 0, 0, 280, 280, 300, 300);
			unlink($fileName);
			
			// Output and free memory
			imagepng($im,"../productlabels/$_GET[id]/label_1000ml_".$totalLabel.'.png');
			
			$totalLabel++;
			$label++;
		
		}
		
		$label = 1;
		while($label<=$data['5l']){
			
			// Create the image
			$im = imagecreatetruecolor(1171, 800);
			
			// Create some colors
			$green = imagecolorallocate($im, 001, 149, 135);
			
			// Replace path by your own font path
			$fontLight = '../../Helvetica.ttf';
			$fontHeavy = '../../Helvetica-Bold.ttf';
			
			// Copy the stamp image onto our photo using the margin offsets and the photo 
			// width to calculate positioning of the stamp. 
			$background = imagecreatefromjpeg($productLabel);
			imagecopy($im, $background, 0, 0, 0, 0, 1171, 800);
			
			// Add the text
			imagettftext($im, 28, 0, 40, 280, $green, $fontHeavy, ucwords($productType)."          ".ucwords($productCode));
			
			$lineStart = 360;
			foreach($nameLines as $line){
				$line = trim($line);
				imagettftext($im, 40, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 65;
			}
			
			foreach($notesLines as $line){
				$line = trim($line);
				imagettftext($im, 20, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 26;
			}
			
			imagettftext($im, 20, 0, 40, 710, $green, $fontHeavy, "Batch");
			imagettftext($im, 28, 0, 40, 750, $green, $fontLight, "$process[batchPrefix]$process[finishedBatch]");
			
			imagettftext($im, 20, 0, 270, 710, $green, $fontHeavy, "BBE");
			imagettftext($im, 28, 0, 270, 750, $green, $fontLight, "$productBBE");
			
			imagettftext($im, 20, 0, 500, 710, $green, $fontHeavy, "Size");
			imagettftext($im, 28, 0, 500, 750, $green, $fontLight, "5l");
			
			$codeContents = "https://natureslaboratory.co.uk/perch/addons/apps/natures_laboratory/products/go/?id=".$batch."&size=5l&bbe=".$productBBE;
		    $fileName = 'qr_'.str_replace("/","-",$batch).'.png';
		    QRcode::png($codeContents, $fileName, QR_ECLEVEL_L, 6);
		    $qr = imagecreatefrompng($fileName);
		    imagecopyresized($im, $qr, 860, 238, 0, 0, 280, 280, 300, 300);
			unlink($fileName);
			
			// Output and free memory
			imagepng($im,"../productlabels/$_GET[id]/label_5l_".$totalLabel.'.png');
			
			$totalLabel++;
			$label++;
		
		}
		
		$label = 1;
		while($label<=$data['25l']){
			
			// Create the image
			$im = imagecreatetruecolor(1171, 800);
			
			// Create some colors
			$green = imagecolorallocate($im, 001, 149, 135);
			
			// Replace path by your own font path
			$fontLight = '../../Helvetica.ttf';
			$fontHeavy = '../../Helvetica-Bold.ttf';
			
			// Copy the stamp image onto our photo using the margin offsets and the photo 
			// width to calculate positioning of the stamp. 
			$background = imagecreatefromjpeg($productLabel);
			imagecopy($im, $background, 0, 0, 0, 0, 1171, 800);
			
			// Add the text
			imagettftext($im, 28, 0, 40, 280, $green, $fontHeavy, ucwords($productType)."          ".ucwords($productCode));
			
			$lineStart = 360;
			foreach($nameLines as $line){
				$line = trim($line);
				imagettftext($im, 40, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 65;
			}
			
			foreach($notesLines as $line){
				$line = trim($line);
				imagettftext($im, 20, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 26;
			}
			
			imagettftext($im, 20, 0, 40, 710, $green, $fontHeavy, "Batch");
			imagettftext($im, 28, 0, 40, 750, $green, $fontLight, "$process[batchPrefix]$process[finishedBatch]");
			
			imagettftext($im, 20, 0, 270, 710, $green, $fontHeavy, "BBE");
			imagettftext($im, 28, 0, 270, 750, $green, $fontLight, "$productBBE");
			
			imagettftext($im, 20, 0, 500, 710, $green, $fontHeavy, "Size");
			imagettftext($im, 28, 0, 500, 750, $green, $fontLight, "25l");
			
			$codeContents = "https://natureslaboratory.co.uk/perch/addons/apps/natures_laboratory/products/go/?id=".$batch."&size=25l&bbe=".$productBBE;
		    $fileName = 'qr_'.str_replace("/","-",$batch).'.png';
		    QRcode::png($codeContents, $fileName, QR_ECLEVEL_L, 6);
		    $qr = imagecreatefrompng($fileName);
		    imagecopyresized($im, $qr, 860, 238, 0, 0, 280, 280, 300, 300);
			unlink($fileName);
			
			// Output and free memory
			imagepng($im,"../productlabels/$_GET[id]/label_25l_".$totalLabel.'.png');
			
			$totalLabel++;
			$label++;
		
		}
		
		$label = 1;
		if($data['other']){
			
			// Create the image
			$im = imagecreatetruecolor(1171, 800);
			
			// Create some colors
			$green = imagecolorallocate($im, 001, 149, 135);
			
			// Replace path by your own font path
			$fontLight = '../../Helvetica.ttf';
			$fontHeavy = '../../Helvetica-Bold.ttf';
			
			// Copy the stamp image onto our photo using the margin offsets and the photo 
			// width to calculate positioning of the stamp. 
			$background = imagecreatefromjpeg($productLabel);
			imagecopy($im, $background, 0, 0, 0, 0, 1171, 800);
			
			// Add the text
			imagettftext($im, 28, 0, 40, 280, $green, $fontHeavy, ucwords($productType)."          ".ucwords($productCode));
			
			$lineStart = 360;
			foreach($nameLines as $line){
				$line = trim($line);
				imagettftext($im, 40, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 65;
			}
			
			foreach($notesLines as $line){
				$line = trim($line);
				imagettftext($im, 20, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 26;
			}
			
			imagettftext($im, 20, 0, 40, 710, $green, $fontHeavy, "Batch");
			imagettftext($im, 28, 0, 40, 750, $green, $fontLight, "$process[batchPrefix]$process[finishedBatch]");
			
			imagettftext($im, 20, 0, 270, 710, $green, $fontHeavy, "BBE");
			imagettftext($im, 28, 0, 270, 750, $green, $fontLight, "$productBBE");
			
			imagettftext($im, 20, 0, 500, 710, $green, $fontHeavy, "Size");
			imagettftext($im, 28, 0, 500, 750, $green, $fontLight, $data['other']);
			
			$codeContents = "https://natureslaboratory.co.uk/perch/addons/apps/natures_laboratory/products/go/?id=".$batch."&size=".$data['other']."&bbe=".$productBBE;
		    $fileName = 'qr_'.str_replace("/","-",$batch).'.png';
		    QRcode::png($codeContents, $fileName, QR_ECLEVEL_L, 6);
		    $qr = imagecreatefrompng($fileName);
		    imagecopyresized($im, $qr, 860, 238, 0, 0, 280, 280, 300, 300);
			unlink($fileName);
			
			// Output and free memory
			imagepng($im,"../productlabels/$_GET[id]/label_other_".$totalLabel.'.png');
			
			$totalLabel++;
			$label++;
		
		}
        

        // SHOW RELEVANT MESSAGE
        if ($new_task) {
            $message = $HTML->success_message('Production process successfully completed. Return to %sProduction%s', '<a href="'.$API->app_path().'/production/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, production process could not be completed.');
        }
        
    }