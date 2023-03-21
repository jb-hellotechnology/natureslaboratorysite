<?php

class Natures_Laboratory_Shopifys extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_shopify';
	protected $pk        = 'natures_laboratory_productID';
	protected $singular_classname = 'Natures_Laboratory_Shopify';
	
	protected $default_sort_column = 'natures_laboratory_productID';
	
	public $static_fields = array('perch3_natures_laboratory_productID','SKU','categoryID','name','qty','price','handle','productDynamicFields');	

	public function getParents($category){
		$sql = 'SELECT * FROM perch3_natures_laboratory_shopify WHERE (SKU NOT LIKE "%/%" AND SKU NOT LIKE "%/ORG%") AND categoryID="'.$category.'" ORDER BY SKU ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getChildren($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natures_laboratory_shopify WHERE SKU LIKE "'.$sku.'/%" AND SKU NOT LIKE "%/ORG%" AND name NOT LIKE "%Discontinued%" ORDER BY SKU DESC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getParentsCapsules(){
		$sql = 'SELECT * FROM perch3_natures_laboratory_shopify WHERE (SKU LIKE "%/1000%") AND categoryID="8" ORDER BY SKU ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getChildrenCapsules($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natures_laboratory_shopify WHERE SKU LIKE "'.$sku.'/%" ORDER BY SKU DESC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
}