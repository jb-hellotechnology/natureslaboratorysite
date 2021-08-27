 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Labels',
    'button'  => [
            'text' => $Lang->get('Labels'),
            'link' => $API->app_nav().'/labels/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Labels',
	    'link'  => $API->app_nav().'/labels/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Products',
	    'link'  => $API->app_nav().'/labels/products/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();

		echo $Form->hidden('staff',$_SESSION['userID']);
		$productList[] = array('label'=>'Please Select', 'value'=>0);
		foreach($products as $Product){
			$productList[] = array('label'=>$Product['productCode']." | ".$Product['productName'], 'value'=>$Product['productCode']);
		}
		echo $Form->select_field("productCode","Product Code",$productList,'');
		
		echo $Form->text_field("batch","Batch Code",'');
		
		echo $Form->date_field("bbe","BBE",'');
		
		echo $Form->text_field("size","Size",'');
		
		echo $Form->text_field("quantity","Quantity of Labels Required",'');
		    
		echo $Form->submit_field('btnSubmit', 'Create Labels', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();