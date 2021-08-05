<?php

class Natures_Laboratory_Labels extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_labels';
	protected $pk        = 'natures_laboratory_labelID';
	protected $singular_classname = 'Natures_Laboratory_Label';
	
	protected $default_sort_column = 'natures_laboratory_labelID';
	
	public $static_fields = array('perch3_natures_laboratory_labelID,','productCode','batch','bbe','size','quantity','labelDynamicFields');	
	
	public function getLabels(){
		
		$today = date('Y-m-d');
		$date = strtotime($today.' -1 year');
		$date = date('Y-m-d', $date);
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_labels ORDER BY natures_laboratory_labelID DESC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getLabelData($batch){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_labels WHERE batch="'.$batch.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function products(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_labels_products ORDER BY productCode ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getProduct($productID){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_labels_products WHERE productCode="'.$productID.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
}