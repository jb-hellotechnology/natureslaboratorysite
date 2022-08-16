<?php
    
    $NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $batch = array();
    $batch = $NaturesLaboratoryGoodsIn->getBatchesData($_POST['code']);

	echo $batch;