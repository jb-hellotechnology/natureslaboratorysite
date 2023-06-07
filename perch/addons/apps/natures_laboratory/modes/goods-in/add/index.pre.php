<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
	
	$NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API);
	$NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API); 
	$NaturesLaboratoryGoodsSuppliers = new Natures_Laboratory_Goods_Suppliers($API);   
	$NaturesLaboratoryCOACountries = new Natures_Laboratory_COA_Countries($API);  
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $Goods = array();
    $details = array();
    
    $stock = $NaturesLaboratoryGoodsStock->getStock();
    $supplier = $NaturesLaboratoryGoodsSuppliers->all();
	$country = $NaturesLaboratoryCOACountries->all();
	
    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('staff','productCode','dateIn_day','dateIn_month','dateIn_year','supplier','qty','unit','bags','bagsList','suppliersBatch','bbe_day','bbe_month','bbe_year','noBBE','noCOA','qa','notes','countryOfOrigin');	   
    	$data = $Form->receive($postvars);   
    	
    	$product = explode(" | ", $data['productCode']);
    	$data['productCode'] = $product[0];
    	$data['productDescription'] = $product[1];   
    	
    	$data['dateIn'] = "$data[dateIn_year]-$data[dateIn_month]-$data[dateIn_day]";
    	$productBBE = $data['bbe_month'].'/'.$data['bbe_year'];
    	unset($data['dateIn_year']);
    	unset($data['dateIn_month']);
    	unset($data['dateIn_day']);
    	
    	if($data['noBBE']=='skip'){
	    	$data['bbe']='1970-01-01';
	    }else{
	    	$data['bbe'] = "$data[bbe_year]-$data[bbe_month]-$data[bbe_day]";
    	}
    	
    	unset($data['bbe_year']);
    	unset($data['bbe_month']);
    	unset($data['bbe_day']);
    	unset($data['noBBE']);
    	
    	$data['ourBatch'] = $NaturesLaboratoryGoodsIn->getBatchNumber();
    	
    	$weights = explode(",",$data['bagsList']);
        
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM  

        $new_goods = $NaturesLaboratoryGoodsIn->create($data);
        
        // GET PRODUCT DATA
        $product = $NaturesLaboratoryGoodsStock->getByCode($data['productCode']);
        $productCode = $product['stockCode'];
        $productType = $product['category'];
        $productName = $product['description'];
        $productRestriction = $product['restriction'];
        
        if($productType=='1'){$productType = 'Unclassified';}
		if($productType=='2'){$productType = 'Tincture';}
		if($productType=='4'){$productType = 'Fluid Extract';}
		if($productType=='5'){$productType = 'Cut Herb';}
		if($productType=='6'){$productType = 'Whole Herb';}
		if($productType=='7'){$productType = 'Powder';}
		if($productType=='8'){$productType = 'Capsule';}
		if($productType=='9'){$productType = 'Chinese Herb';}
		if($productType=='10'){$productType = 'BeeVital';}
		if($productType=='11'){$productType = 'Cream';}
		if($productType=='12'){$productType = 'Essential Oil';}
		if($productType=='13'){$productType = 'Fixed Oil';}
		if($productType=='14'){$productType = 'Packaging';}
		if($productType=='15'){$productType = 'Gums';}
		if($productType=='16'){$productType = 'Misc';}
		if($productType=='17'){$productType = 'Detox';}
		if($productType=='18'){$productType = 'Organic';}
		if($productType=='20'){$productType = 'Tea';}
		if($productType=='21'){$productType = 'Supplement';}
		if($productType=='22'){$productType = "Sweet Cecily's";}
		if($productType=='40'){$productType = 'Bespoke Blend';}
		if($productType=='999'){$productType = 'Discontinued';}
        
        // GET BG IMAGE
        $productLabel = '../../label_standard.jpg';
        if($productRestriction == 'allergen'){
	        $productLabel = '../../label_allergen.jpg';
        }elseif($productRestriction == 'poison'){
	        $productLabel = '../../label_poison.jpg';
        }
        
        if($productType=='Organic'){
	        $productLabel = '../../label_organic.jpg';
	        if($productRestriction == 'allergen'){
		        $productLabel = '../../label_organic_allergen.jpg';
	        }elseif($productRestriction == 'poison'){
		        $productLabel = '../../label_organic_poison.jpg';
	        }
        }
        
        // CREATE FOLDER
		$labelsID = $new_goods->natures_laboratory_goods_inID();
		mkdir("../pngs/$labelsID", 0755);
		$url = "../pngs/$labelsID";
		
		$name = wordwrap($productName, 22, "<br />");
		$nameLines = explode("<br />", $name);
		
		$notes = wordwrap($productNotes, 46, "<br />");
		$notesLines = explode("<br />", $notes);
		
		$batch = $new_goods->ourBatch();
		
		$bag = 0;
		while($bag<=$data['bags']){
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
				imagettftext($im, 40, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 60;
			}
			
			foreach($notesLines as $line){
				imagettftext($im, 20, 0, 40, $lineStart, $green, $fontLight, $line);
				$lineStart = $lineStart + 26;
			}
	
			imagettftext($im, 20, 0, 40, 710, $green, $fontHeavy, "Batch");
			imagettftext($im, 28, 0, 40, 750, $green, $fontLight, "$batch");
			
			imagettftext($im, 20, 0, 270, 710, $green, $fontHeavy, "BBE");
			imagettftext($im, 28, 0, 270, 750, $green, $fontLight, "$productBBE");
			
			imagettftext($im, 20, 0, 500, 710, $green, $fontHeavy, "Size");
			if($bag==$data['bags']){
				imagettftext($im, 28, 0, 500, 750, $green, $fontLight, "SAMPLE");
			}else{
				imagettftext($im, 28, 0, 500, 750, $green, $fontLight, "$weights[$bag]");
			}
			
			$codeContents = "https://natureslaboratory.co.uk/perch/addons/apps/natures_laboratory/goods-in/go/?id=".$batch;
		    $fileName = 'qr_'.str_replace("/","-",$batch).'.png';
		    QRcode::png($codeContents, $fileName, QR_ECLEVEL_L, 7);
		    $qr = imagecreatefrompng($fileName);
		    imagecopyresized($im, $qr, 860, 238, 0, 0, 280, 280, 300, 300);
			unlink($fileName);
			
			// Output and free memory
			imagepng($im,"../pngs/$labelsID/label_".$bag.'.png');
			$bag++;
		}

        // SHOW RELEVANT MESSAGE
        if ($new_goods) {
            $message = $HTML->success_message('Goods In has been successfully created. Return to %sGoods In%s', '<a href="'.$API->app_path().'/goods-in/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Goods In could not be created.');
        }
        
    }