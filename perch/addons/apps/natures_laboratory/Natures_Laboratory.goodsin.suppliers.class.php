<?php

class Natures_Laboratory_Goods_Suppliers extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_goods_suppliers';
	protected $pk        = 'natures_laboratory_goods_suppliersID';
	protected $singular_classname = 'Natures_Laboratory_Goods_Supplier';
	
	protected $default_sort_column = 'name';
	
	public $static_fields = array('natures_laboratory_goods_suppliersID','name','goods_supplierDynamicFields');	
	
}