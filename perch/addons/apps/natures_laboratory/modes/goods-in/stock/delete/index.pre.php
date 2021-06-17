<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
	
	$NaturesLaboratoryGoodsStocks = new Natures_Laboratory_Goods_Stocks($API);   
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');

    if($Form->submitted()) {
    
        $stockID = (int) $_GET['id'];  
		$Stock = $NaturesLaboratoryGoodsStocks->find($stockID, true);
		
		$Stock->delete();
		$deleted = true;
		$message = $HTML->success_message('Stock has been successfully deleted. Return to %sStock%s', '<a href="'.$API->app_path().'/goods-in/stock/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this Stock?', '', ''); 
    }