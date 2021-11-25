<?php
    
    $NaturesLaboratoryGoodsIn = new Natures_Laboratory_Goods_Ins($API); 
    $NaturesLaboratoryGoodsSuppliers = new Natures_Laboratory_Goods_Suppliers($API); 
    $NaturesLaboratoryGoodsStock = new Natures_Laboratory_Goods_Stocks($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $codes = array();
    $codes = $NaturesLaboratoryGoodsIn->checkCodes($_POST['code'],$_POST['batch']);

    echo $codes;