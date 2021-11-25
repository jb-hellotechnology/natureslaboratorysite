<?php

class Natures_Laboratory_Labels_Products extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_labels_products';
	protected $pk        = 'natures_laboratory_labels_productID';
	protected $singular_classname = 'Natures_Laboratory_Labels_Product';
	
	protected $default_sort_column = 'productCode';
	
	public $static_fields = array('perch3_natures_laboratory_labels_productID,','productCode','productName','productType','productRange','notes');	

	public function getProduct($code){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_labels_products WHERE productCode="'.$code.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
}