 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Products',
    'button'  => [
            'text' => $Lang->get('Product'),
            'link' => $API->app_nav().'/labels/products/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Labels',
	    'link'  => $API->app_nav().'/labels/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Products',
	    'link'  => $API->app_nav().'/labels/products/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
   
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		echo $Form->text_field("productCode","Product Code",$details['productCode']);
		
		echo $Form->text_field("productName","Product Name",$details['productName']);
	
		$productList[] = array('label'=>'Please Select', 'value'=>0);
		$productList[] = array('label'=>'Tincture', 'value'=>'Tincture');
		$productList[] = array('label'=>'Fluid Extract', 'value'=>'Fluid Extract');
		$productList[] = array('label'=>'Cut Herb', 'value'=>'Cut Herb');
		$productList[] = array('label'=>'Powder', 'value'=>'Powder');
		$productList[] = array('label'=>'Whole Herb', 'value'=>'Whole Herb');
		$productList[] = array('label'=>'Essential Oil', 'value'=>'Essential Oil');
		$productList[] = array('label'=>'Cream', 'value'=>'Cream');
		$productList[] = array('label'=>'Gel', 'value'=>'Gel');
		$productList[] = array('label'=>'Whole', 'value'=>'Whole');
		$productList[] = array('label'=>'Capsules', 'value'=>'Capsules');
		$productList[] = array('label'=>'Fixed Oil', 'value'=>'Fixed Oil');
		$productList[] = array('label'=>'Loose Leaf Tea', 'value'=>'Loose Leaf Tea');
		$productList[] = array('label'=>'Floral Water', 'value'=>'Floral Water');

		echo $Form->select_field("productType","Product Type",$productList,$details['productType']);
		
		echo $Form->text_field("notes","Notes",$details['notes']);
		    
		echo $Form->submit_field('btnSubmit', 'Create Product', $API->app_path());
		
		echo $Form->form_end();
	
	}
	
    echo $HTML->main_panel_end();