<?php

class Natures_Laboratory_Goods_Ins extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_goods_in';
	protected $pk        = 'natures_laboratory_goods_inID';
	protected $singular_classname = 'Natures_Laboratory_Goods_In';
	
	protected $default_sort_column = 'natures_laboratory_goods_inID';
	
	public $static_fields = array('natures_laboratory_goods_inID,','staff','productCode','productDescription','dateIn','supplier','qty','suppliersBatch','ourBatch','bbe','qa','goods_inDynamicFields');	
	
}