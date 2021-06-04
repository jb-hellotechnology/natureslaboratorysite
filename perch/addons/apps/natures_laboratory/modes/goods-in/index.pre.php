<?php
    
    $NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API); 
    $NaturesLaboratoryGoodsSuppliers = new Natures_Laboratory_Goods_Suppliers($API); 
    
    $HTML = $API->get('HTML');
    
    $goodsIn = array();
    $goodsIn = $NaturesLaboratoryGoodsIn->all();