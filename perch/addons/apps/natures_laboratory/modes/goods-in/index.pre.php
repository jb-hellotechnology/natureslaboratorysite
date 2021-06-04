<?php
    
    $NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API);  
    
    $HTML = $API->get('HTML');
    
    $goodsIn = array();
    $goodsIn = $NaturesLaboratoryGoodsIn->all();