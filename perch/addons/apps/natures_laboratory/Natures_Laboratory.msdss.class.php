<?php

class Natures_Laboratory_MSDSs extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_msds';
	protected $pk        = 'natures_laboratory_msdsID';
	protected $singular_classname = 'Natures_Laboratory_MSDS';
	
	protected $default_sort_column = 'natures_laboratory_msdsID';
	
	public $static_fields = array('natures_laboratory_msdsID,','productType','productCode','natures_laboratory_msdsDynamicFields');	
	
	public function getMSDSs(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_msds ORDER BY productCode ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getMSDSTemplates(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_msds_templates ORDER BY productType ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function updateCOAs(){
		$sql = 'SELECT * FROM perch3_natures_laboratory_coa WHERE dateEntered>="'.$date.'" ORDER BY natures_laboratory_coaID DESC';
		$data = $this->db->get_rows($sql);
		foreach($data as $item){
			$date = $item['dateEntered'];
			$dates = explode("/",$date);
			$newDate = "$dates[2]-$dates[1]-$dates[0]";
			$sql = 'UPDATE perch3_natures_laboratory_coa SET dateEntered="'.$newDate.'" WHERE natures_laboratory_coaID='.$item['natures_laboratory_coaID'];
			echo $sql;
			$update = $this->db->execute($sql);
		}
	}
	
	public function byBatch($batch){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_coa WHERE ourBatch="'.$batch.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function findCOA($sku){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_coa_products WHERE spec="'.$sku.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getMSDSProducts(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_cas ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getProducts(){
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function createCAS($data){
		
		$sql = 'INSERT INTO perch3_natures_laboratory_cas (STOCK_CODE, CAS) VALUES ("'.$data['STOCK_CODE'].'", "'.$data['CAS'].'")';
		$data = $this->db->execute($sql);
		return $data;
		
	}
	
	public function updateCAS($data){
		
		$sql = 'UPDATE perch3_natures_laboratory_cas SET STOCK_CODE="'.$data['STOCK_CODE'].'", CAS="'.$data['CAS'].'" WHERE casID="'.$data['casID'].'"';
		$data = $this->db->execute($sql);
		return $data;
		
	}
	
	public function getCAS($id){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_cas WHERE casID="'.$id.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getCASCode($id){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_cas WHERE STOCK_CODE="'.$id.'"';
		$data = $this->db->get_row($sql);
		if($data){
			return $data;	
		}else{
			$data['CAS'] = 'NO CAS AVAILABLE';
			return $data;
		}
		
	}
	
	public function deleteCAS($id){
		
		$sql = 'DELETE FROM perch3_natures_laboratory_cas WHERE casID="'.$id.'"';
		$data = $this->db->execute($sql);
		return $data;
		
	}
	
}