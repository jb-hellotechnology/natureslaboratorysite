 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Shopify',
    ], $CurrentUser);

    echo $HTML->main_panel_start();
    
    foreach($export as $row){
	    echo "$row[SKU],$row[name],$row[qty],$row[price]<br />";
	    $children = $NaturesLaboratoryShopify->getChildren($row['SKU']);
	    foreach($children as $row){
	    	echo "$row[SKU],$row[name],$row[qty],$row[price]<br />";
	    }
	    echo "<hr />";
    }
    
    echo $HTML->main_panel_end();