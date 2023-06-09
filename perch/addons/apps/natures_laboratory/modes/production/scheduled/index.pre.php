<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryProduction = new Natures_Laboratory_Productions($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $scheduled = array();
    $scheduled = $NaturesLaboratoryProduction->getScheduled();
    
    $schedule = $NaturesLaboratoryProduction->find($_GET['id'], true);
    
    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('sku','date_day','date_month','date_year','datePressed_day','datePressed_month','datePressed_year','dateSageUpdated_day','dateSageUpdated_month','dateSageUpdated_year','sageUpdatedBy','barrel','status', 'producedBy', 'batchPrefix');	   
    	$data = $Form->receive($postvars);     
    	
    	$data['finishedBatch'] = $NaturesLaboratoryProduction->getBatchNumber();

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

        $new_schedule = $schedule->update($data);
        
        $process = $NaturesLaboratoryProduction->getProcess($_GET['id']);
        $product = $NaturesLaboratoryProduction->getProduct($process['sku']);
        
        $productType = '';
        if($product['STOCK_CAT']=='2'){$productType = 'TINCTURE';}
        if($product['STOCK_CAT']=='4'){$productType = 'FLUID EXTRACT';}
        if($product['STOCK_CAT']=='8'){$productType = 'CAPSULES';}
        if($product['STOCK_CAT']=='10'){$productType = 'BEEVITAL';}
        if($product['STOCK_CAT']=='11'){$productType = 'CREAM';}
        
        $productName = $product['DESCRIPTION'];
        $productCode = $product['STOCK_CODE'];
        
        // GET BG IMAGE
        $productLabel = '../../label_manufacturing.jpg';
        
        // CREATE FOLDER
		$labelsID = $_GET['id'];
		mkdir("../labels/$labelsID", 0755);
		$url = "../labels/$labelsID";
		
		$name = wordwrap($productName, 24, "<br />");
		$nameLines = explode("<br />", $name);
					
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
			imagettftext($im, 60, 0, 40, $lineStart, $green, $fontLight, $line);
			$lineStart = $lineStart + 80;
		}
		
		$wpo = 'P'.str_pad($_GET['id'], 6, '0', STR_PAD_LEFT);

		imagettftext($im, 20, 0, 40, 710, $green, $fontHeavy, "WPO");
		imagettftext($im, 28, 0, 40, 750, $green, $fontLight, "$wpo");
		
		imagettftext($im, 20, 0, 270, 710, $green, $fontHeavy, "Batch");
		imagettftext($im, 28, 0, 270, 750, $green, $fontLight, "$data[batchPrefix]$data[finishedBatch]");
		
		imagettftext($im, 20, 0, 500, 710, $green, $fontHeavy, "Date In");
		imagettftext($im, 28, 0, 500, 750, $green, $fontLight, "$data[date]");
		
		imagettftext($im, 20, 0, 730, 710, $green, $fontHeavy, "Date Out");
		imagettftext($im, 28, 0, 730, 750, $green, $fontLight, "$data[datePressed]");
		
		imagettftext($im, 20, 0, 990, 710, $green, $fontHeavy, "Barrel");
		imagettftext($im, 28, 0, 990, 750, $green, $fontLight, "$data[barrel]");

		
		// Output and free memory
		imagepng($im,"../labels/$labelsID/label".'.png');
		

        // SHOW RELEVANT MESSAGE
        if ($new_schedule) {
            $message = $HTML->success_message('Production process successfully entered production. Go to %sIn Production%s to print WPO.', '<a href="'.$API->app_path().'/production/in-production/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, production process could not be created.');
        }
        
    }