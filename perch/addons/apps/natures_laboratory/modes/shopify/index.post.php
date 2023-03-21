 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Shopify',
    ], $CurrentUser);

    echo $HTML->main_panel_start();
    
    echo "<p>Handle,Title,Body (HTML),Vendor,Product Category,Type,Tags,Published,Option1 Name,Option1 Value,Option2 Name,Option2 Value,Option3 Name,Option3 Value,Variant SKU,Variant Grams,Variant Inventory Tracker,Variant Inventory Qty,Variant Inventory Policy,Variant Fulfillment Service,Variant Price,Variant Compare At Price,Variant Requires Shipping,Variant Taxable,Variant Barcode,Image Src,Image Position,Image Alt Text,Gift Card,SEO Title,SEO Description,Google Shopping / Google Product Category,Google Shopping / Gender,Google Shopping / Age Group,Google Shopping / MPN,Google Shopping / AdWords Grouping,Google Shopping / AdWords Labels,Google Shopping / Condition,Google Shopping / Custom Product,Google Shopping / Custom Label 0,Google Shopping / Custom Label 1,Google Shopping / Custom Label 2,Google Shopping / Custom Label 3,Google Shopping / Custom Label 4,Variant Image,Variant Weight Unit,Variant Tax Code,Cost per item,Included / United Kingdom,Included / European Union,Price / European Union,Compare At Price / European Union,Included / International,Price / International,Compare At Price / International,Status<br />";
    
    /** CHEMICALS **/
    
    $export = $NaturesLaboratoryShopify->getParents(1);
    
    /** TINCTURES **/
    
    $export = $NaturesLaboratoryShopify->getParents(2);
    
    foreach($export as $row){
	    $handle = str_replace("-1000ml", "", $row['handle']);
	    $parts = explode(" ", $row['name']);
	    $size = end($parts);
	    $name = str_replace(" 1000ml", "", $row['name']);
	    if($size=='250ml'){
			$weight = 250;
		}elseif($size=='500ml'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
	    echo "$handle,$name,,Herbal Apothecary UK,,,\"level 2, tincture, $size\",TRUE,Size,$size,,,,,$row[SKU],$weight,shopify,$row[qty],deny,manual,$row[price],,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    $children = $NaturesLaboratoryShopify->getChildren($row['SKU']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['name']);
			$size = end($parts);
			if($size=='250ml'){
				$weight = 250;
			}elseif($size=='500ml'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
	    	echo "$handle,$row[name],,Herbal Apothecary UK,,,\"level 2, tincture, $size\",TRUE,Size,$size,,,,,$row[SKU],$weight,shopify,$row[qty],deny,manual,$row[price],,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    }
    }
    
    /** FLUIDS **/
    
    $export = $NaturesLaboratoryShopify->getParents(4);
    
    foreach($export as $row){
	    $handle = str_replace("-1000ml", "", $row['handle']);
	    $parts = explode(" ", $row['name']);
	    $size = end($parts);
	    $name = str_replace(" 1000ml", "", $row['name']);
	    if($size=='250ml'){
			$weight = 250;
		}elseif($size=='500ml'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
	    echo "$handle,$name,,Herbal Apothecary UK,,,\"level 2, fluid extract, $size\",TRUE,Size,$size,,,,,$row[SKU],$weight,shopify,$row[qty],deny,manual,$row[price],,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    $children = $NaturesLaboratoryShopify->getChildren($row['SKU']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['name']);
			$size = end($parts);
			if($size=='250ml'){
				$weight = 250;
			}elseif($size=='500ml'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
	    	echo "$handle,$row[name],,Herbal Apothecary UK,,,\"level 2, fluid extract, $size\",TRUE,Size,$size,,,,,$row[SKU],$weight,shopify,$row[qty],deny,manual,$row[price],,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    }
    }
    
    /** CUT HERB **/
    
    $export = $NaturesLaboratoryShopify->getParents(5);
    
    foreach($export as $row){
	    $handle = str_replace("-1000gm", "", $row['handle']);
	    $parts = explode(" ", $row['name']);
	    $size = end($parts);
	    $name = str_replace(" 1000gm", "", $row['name']);
	    if($size=='250gm'){
			$weight = 250;
		}elseif($size=='500gm'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$qty = $row['qty'];
		
	    echo "$handle,$name,,Herbal Apothecary UK,,,\"level 1, cut-herb, $size\",TRUE,Size,$size,,,,,$row[SKU],$weight,shopify,$qty,deny,manual,$row[price],,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    $children = $NaturesLaboratoryShopify->getChildren($row['SKU']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['name']);
			$size = end($parts);
			if($size=='250gm'){
				$weight = 250;
			}elseif($size=='500gm'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$qty = $qty*2;
	    	echo "$handle,$row[name],,Herbal Apothecary UK,,,\"level 1, cut-herb, $size\",TRUE,Size,$size,,,,,$row[SKU],$weight,shopify,$qty,deny,manual,$row[price],,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    }
    }
    
    /** WHOLE HERB **/
    
    $export = $NaturesLaboratoryShopify->getParents(6);
    
    foreach($export as $row){
	    $handle = str_replace("-1000gm", "", $row['handle']);
	    $parts = explode(" ", $row['name']);
	    $size = end($parts);
	    $name = str_replace(" 1000gm", "", $row['name']);
	    if($size=='250gm'){
			$weight = 250;
		}elseif($size=='500gm'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$qty = $row['qty'];
		
	    echo "$handle,$name,,Herbal Apothecary UK,,,\"level 1, whole-herb, $size\",TRUE,Size,$size,,,,,$row[SKU],$weight,shopify,$qty,deny,manual,$row[price],,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    $children = $NaturesLaboratoryShopify->getChildren($row['SKU']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['name']);
			$size = end($parts);
			if($size=='250gm'){
				$weight = 250;
			}elseif($size=='500gm'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$qty = $qty*2;
	    	echo "$handle,$row[name],,Herbal Apothecary UK,,,\"level 1, whole-herb, $size\",TRUE,Size,$size,,,,,$row[SKU],$weight,shopify,$qty,deny,manual,$row[price],,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    }
    }
    
    /** POWDER **/
    
    $export = $NaturesLaboratoryShopify->getParents(7);
    
    foreach($export as $row){
	    $handle = str_replace("-1000gm", "", $row['handle']);
	    $parts = explode(" ", $row['name']);
	    $size = end($parts);
	    $name = str_replace(" 1000gm", "", $row['name']);
	    if($size=='250gm'){
			$weight = 250;
		}elseif($size=='500gm'){
			$weight = 500;
		}else{
			$weight = 1000;
		}
		
		$qty = $row['qty'];
		
	    echo "$handle,$name,,Herbal Apothecary UK,,,\"level 1, powder, $size\",TRUE,Size,$size,,,,,$row[SKU],$weight,shopify,$row[qty],deny,manual,$row[price],,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    $children = $NaturesLaboratoryShopify->getChildren($row['SKU']);
	    foreach($children as $row){
		    $parts = explode(" ", $row['name']);
			$size = end($parts);
			if($size=='250gm'){
				$weight = 250;
			}elseif($size=='500gm'){
				$weight = 500;
			}else{
				$weight = 1000;
			}
			$qty = $qty*2;
	    	echo "$handle,$row[name],,Herbal Apothecary UK,,,\"level 1, powder, $size\",TRUE,Size,$size,,,,,$row[SKU],$weight,shopify,$qty,deny,manual,$row[price],,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    }
    }
    
    /** CAPSULES **/
    
    $export = $NaturesLaboratoryShopify->getParentsCapsules();
    
    foreach($export as $row){
	    $handle = str_replace("-1000", "", $row['handle']);
	    $parts = explode(" ", $row['name']);
	    $size = end($parts);
	    $name = str_replace(" 1000", "", $row['name']);
	    
	    echo "$handle,$name,,Herbal Apothecary UK,,,\"level 1, capsules, $size\",TRUE,Size,$size,,,,,$row[SKU],$weight,shopify,$row[qty],deny,manual,$row[price],,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    
	    $sku = explode("/", $row['SKU']);
	    
	    /* CREATE CAPSULE CHILDREN */
	    /* 100 Tub */
	    $qty = floor(($row['qty']*1000)/100);
	    $price = (($row['price']/1000)*100)*1.2;
	    $price = number_format($price,2);
	    echo "$handle,$name,,Herbal Apothecary UK,,,\"level 1, capsules, 100\",TRUE,Size,100,,,,,$sku[0]/100,140,shopify,$qty,deny,manual,$price,,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
	    
	    /* 60 Tub */
	    $qty = floor(($row['qty']*1000)/60);
	    $price = (($row['price']/1000)*100)*1.8;
	    $price = number_format($price,2);
	    echo "$handle,$name,,Herbal Apothecary UK,,,\"level 1, capsules, $size\",TRUE,Size,60,,,,,$sku[0]/60,80,shopify,$qty,deny,manual,$price,,TRUE,TRUE,,,,,FALSE,,,,,,,,,,,,,,,,,g,,,TRUE,TRUE,,,TRUE,,,active<br />";
    }
    
    echo $HTML->main_panel_end();