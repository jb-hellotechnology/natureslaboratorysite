<?php

class Natures_Laboratory_Shopifys extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_shopify';
	protected $pk        = 'natures_laboratory_productID';
	protected $singular_classname = 'Natures_Laboratory_Shopify';
	
	protected $default_sort_column = 'natures_laboratory_productID';
	
	public $static_fields = array('perch3_natures_laboratory_productID','SKU','categoryID','name','qty','price','handle','productDynamicFields');	

	public function getParents($category){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE (STOCK_CODE NOT LIKE "%/%" AND STOCK_CODE NOT LIKE "%/ORG%") AND STOCK_CAT="'.$category.'" AND QTY_IN_STOCK>0 ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getCatalogueParents($category){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE (STOCK_CODE NOT LIKE "%/%" AND STOCK_CODE NOT LIKE "%/ORG%") AND STOCK_CAT="'.$category.'" AND QTY_IN_STOCK>0 ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getChildren($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE LIKE "'.$sku.'/%" AND STOCK_CODE NOT LIKE "%/ORG%" AND DESCRIPTION NOT LIKE "%Discontinued%" ORDER BY STOCK_CODE DESC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getParentsCapsules(){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE (STOCK_CODE LIKE "%/1000%") AND STOCK_CAT="8" AND QTY_IN_STOCK>0 ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getChildrenCapsules($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE LIKE "'.$sku.'/%" ORDER BY STOCK_CODE DESC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getCatalogueParentsCapsules(){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE (STOCK_CODE LIKE "%/1000%") AND STOCK_CAT="8" AND QTY_IN_STOCK>0 ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getCatalogueChildrenCapsules($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE LIKE "'.$sku.'/%" ORDER BY STOCK_CODE DESC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
}