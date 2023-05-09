<?php
	
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
    
    $NaturesLaboratoryShopify = new Natures_Laboratory_Shopifys($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=beevital_shopify_stock_update.csv');
	
	$output = fopen( 'php://output', 'w' );
	
	ob_end_clean();
    
    fputcsv($output, array("Handle", "Option1 Name", "Option1 Value", "Option2 Name", "Option2 Value", "Option3 Name", "Option3 Value", "Location", "Incoming", "Unavailable", "Committed", "Available", "On Hand"));
    
    
    #BOOKS
    $item = $NaturesLaboratoryShopify->getBySKU('BOOK01');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("bee-propolis-natural-healing-from-the-hive", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #POLLEN CAPSULES
    $item = $NaturesLaboratoryShopify->getBySKU('BV17');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("pollen-capsules", "Size", "60 Capsules", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV18');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("pollen-capsules", "Size", "120 Capsules", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV19');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("pollen-capsules", "Size", "300 Capsules", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #POLLEN GRANULES
    $item = $NaturesLaboratoryShopify->getBySKU('BVPG');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("pollen-granules", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #POLLEN HONEY
    $item = $NaturesLaboratoryShopify->getBySKU('BVPO');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("pollen-honey", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $qty = floor($qty/6);
    $data = array("pollen-honey-6-pack", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #THROAT SPRAY
    $item = $NaturesLaboratoryShopify->getBySKU('BVPG');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-honey-throat-spray", "Multibuy", "1 Pack", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $qty2 = floor($qty/2);
    $data = array("propolis-honey-throat-spray", "Multibuy", "2 Pack", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty2", "$qty2");
    fputcsv($output, $data);
    $qty3 = floor($qty/3);
    $data = array("propolis-honey-throat-spray", "Multibuy", "3 Pack", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty3", "$qty3");
    fputcsv($output, $data);
    $qty = floor($qty/6);
    $data = array("propolis-honey-throat-spray-6-pack", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #PROPOLIS SOAP
    $item = $NaturesLaboratoryShopify->getBySKU('BV25');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-lemongrass-soap", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $qty = floor($qty/6);
    $data = array("propolis-lemongrass-soap-6-pack", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #BGEL
    $item = $NaturesLaboratoryShopify->getBySKU('BV41');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-b-gel", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $qty = floor($qty/6);
    $data = array("propolis-b-gel-6-pack", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #PROPOLIS CAPSULES
    $item = $NaturesLaboratoryShopify->getBySKU('BV14');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-capsules", "Size", "60 Capsules", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV15');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-capsules", "Size", "120 Capsules", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV16');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-capsules", "Size", "300 Capsules", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV14');
    $qty = floor(($item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'])/6);
    $data = array("propolis-capsules-6-pack", "Size", "60 Capsules", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV15');
    $qty = floor(($item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'])/6);
    $data = array("propolis-capsules-6-pack", "Size", "120 Capsules", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV16');
    $qty = floor(($item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'])/6);
    $data = array("propolis-capsules-6-pack", "Size", "300 Capsules", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #PROPOLIS CREAM
    $item = $NaturesLaboratoryShopify->getBySKU('BV05');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-cream", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $qty = floor($qty/6);
    $data = array("propolis-cream-6-pack", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #PROPOLIS HONEY
    $item = $NaturesLaboratoryShopify->getBySKU('BVPH');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-honey", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $qty = floor($qty/6);
    $data = array("propolis-honey-6-pack", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #PROPOLIS LIP BALM
    $item = $NaturesLaboratoryShopify->getBySKU('BV26');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-lip-balm", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $qty = floor($qty/6);
    $data = array("propolis-lip-balm-6-pack", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #MOUTHWASH
    $item = $NaturesLaboratoryShopify->getBySKU('BV23');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-mouthwash", "Multibuy", "1 Pack", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $qty2 = $qty/2;
    $data = array("propolis-moutwash", "Multibuy", "2 Pack", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty2", "$qty2");
    fputcsv($output, $data);
    $qty = floor($qty/6);
    $data = array("propolis-mouthwash-6-pack", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #SYRUP
    $item = $NaturesLaboratoryShopify->getBySKU('BV42/G');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-syrup-with-elderberry-honey", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $qty = floor($qty/6);
    $data = array("propolis-syrup-with-elderberry-honey-6-pack", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #PROPOLIS TABLETS
    $item = $NaturesLaboratoryShopify->getBySKU('BV03');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-tablets", "Size", "60 Tablets", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV12');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-tablets", "Size", "120 Tablets", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV13');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-tablets", "Size", "360 Tablets", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV03');
    $qty = floor(($item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'])/6);
    $data = array("propolis-tablets-6-pack", "Size", "60 Tablets", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV12');
    $qty = floor(($item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'])/6);
    $data = array("propolis-tablets-6-pack", "Size", "120 Tablets", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV13');
    $qty = floor(($item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'])/6);
    $data = array("propolis-tablets-6-pack", "Size", "360 Tablets", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #PROPOLIS TINCTURE
    $item = $NaturesLaboratoryShopify->getBySKU('BV01');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-tincture", "Size", "30ml", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV08');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-tincture", "Size", "100ml", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV01');
    $qty = floor(($item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'])/6);
    $data = array("propolis-tincture-6-pack", "Size", "30ml", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV08');
    $qty = floor(($item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'])/6);
    $data = array("propolis-tincture-6-pack", "Size", "100ml", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
   
    #TOOTH & GUM LIQUID
    $item = $NaturesLaboratoryShopify->getBySKU('BV27');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-tooth-gum-liquid", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $qty = floor($qty/6);
    $data = array("propolis-tooth-gum-liquid-6-pack", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #PROPOLIS TOOTHPASTE
    $item = $NaturesLaboratoryShopify->getBySKU('BV21');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("propolis-toothpaste", "Multibuy", "1 Pack", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $qty2 = floor($qty/2);
    $data = array("propolis-toothpaste", "Multibuy", "2 Pack", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty2", "$qty2");
    fputcsv($output, $data);
    $qty3 = floor($qty/3);
    $data = array("propolis-toothpaste", "Multibuy", "3 Pack", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty3", "$qty3");
    fputcsv($output, $data);
    $qty = floor($qty/6);
    $data = array("propolis-toothpaste-6-pack", "Title", "Default Title", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    
    #PROPOLIS LIQUID
    $item = $NaturesLaboratoryShopify->getBySKU('BV31');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("water-soluble-propolis-liquid", "Size", "30ml", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV32');
    $qty = $item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'];
    $data = array("water-soluble-propolis-liquid", "Size", "100ml", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV31');
    $qty = floor(($item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'])/6);
    $data = array("water-soluble-propolis-liquid-trade", "Size", "30ml", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);
    $item = $NaturesLaboratoryShopify->getBySKU('BV32');
    $qty = floor(($item['QTY_IN_STOCK']-$item['QTY_ALLOCATED'])/6);
    $data = array("water-soluble-propolis-liquid-trade", "Size", "100ml", "", "", "", "", "Nature's Laboratory", "0", "0", "0", "$qty", "$qty");
    fputcsv($output, $data);

       
	exit();