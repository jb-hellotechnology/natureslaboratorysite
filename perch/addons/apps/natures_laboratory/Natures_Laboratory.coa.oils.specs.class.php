<?php

class Natures_Laboratory_COA_Oils_Specs extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_coa_oils_spec';
	protected $pk        = 'natures_laboratory_coa_oils_specID';
	protected $singular_classname = 'Natures_Laboratory_COA_Oils_Spec';
	
	protected $default_sort_column = 'natures_laboratory_coa_oils_specID';
	
	public $static_fields = array('natures_laboratory_coa_products_specID,','productCode','commonName','biologicalSource','plantPart','cas','einecs','manufacturingMethod','countryOfOrigin','colour','odor','appearance','specificGravity','refractiveIndex','opticalRotation');	
	
	public function getSpec($code){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_coa_oils_spec WHERE productCode="'.$code.'"';
		$data = $this->db->get_row($sql);
		$json = json_encode($data);
		return $json;
		
	}
	
	public function byCode($code){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_coa_oils_spec WHERE productCode="'.$code.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function byBatch($batch){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_coa_oils_spec WHERE ourBatch="'.$batch.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}

}