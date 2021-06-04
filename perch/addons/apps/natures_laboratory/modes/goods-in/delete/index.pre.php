<?php
	$NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $Goods = array();
    $details = array();

    if($Form->submitted()) {
    
        $goodsID = (int) $_GET['id'];  
		$Goods = $NaturesLaboratoryGoodsIn->find($goodsID, true);
		
		$Goods->delete();
		$deleted = true;
		$message = $HTML->success_message('Goods have been successfully deleted. Return to %sGoods In%s', '<a href="'.$API->app_path().'/goods-in/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this record?', '', ''); 
    }