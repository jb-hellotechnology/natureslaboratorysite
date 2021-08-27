<?php
    
    $NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $batch = array();
    $batch = $NaturesLaboratoryGoodsIn->getBatchData($_POST['batch']);

	$json = json_encode($batch,true);
    
    echo $json;