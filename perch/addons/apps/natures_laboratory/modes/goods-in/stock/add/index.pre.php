<?php
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	$NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    $Template = $API->get('Template');

    if($Form->submitted()) {
    
        //FOR ITEMS PROGRAMMATICALLY ADDED TO FORM
        $postvars = array('stockCode','description','component1','component2','component3','component4','component5','component6','qty1','qty2','qty3','qty4','qty5','qty6');	   
    	$data = $Form->receive($postvars);      

        $new_time = $NaturesLaboratoryGoodsStock->create($data);

        // SHOW RELEVANT MESSAGE
        if ($new_time) {
            $message = $HTML->success_message('Stock has been successfully created. Return to %sStock%s', '<a href="'.$API->app_path().'/goods-in/stock/">', '</a>'); 
        }else{
            $message = $HTML->failure_message('Sorry, Stock could not be created.');
        }
        
    }