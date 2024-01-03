<?php

class Natures_Laboratory_COA_Capsules extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_coa_capsules';
	protected $pk        = 'natures_laboratory_coa_capsuleID';
	protected $singular_classname = 'Natures_Laboratory_COA_Capsule';
	
	protected $default_sort_column = 'natures_laboratory_coa_capsuleID';
	
	public $static_fields = array('natures_laboratory_coa_capsuleID','spec','dateEntered','ourBatch','countryOfOrigin','colour','odour','taste','natures_laboratory_coa_productDynamicFields');	
	
	public function getCOAs($q){
		
		$today = date('Y-m-d');
		$date = strtotime($today.' -1 year');
		$date = date('Y-m-d', $date);
		
		if($q){
			$sql = 'SELECT perch3_natures_laboratory_coa_capsules.*, perch3_natureslaboratory_stock.* FROM perch3_natures_laboratory_coa_capsules, perch3_natureslaboratory_stock WHERE perch3_natures_laboratory_coa_capsules.dateEntered>="'.$date.'" AND (perch3_natures_laboratory_coa_capsules.spec="'.$q.'" OR perch3_natures_laboratory_coa_capsules.ourBatch="'.$q.'" OR perch3_natureslaboratory_stock.DESCRIPTION LIKE "%'.$q.'%") AND perch3_natureslaboratory_stock.STOCK_CODE=perch3_natures_laboratory_coa_capsules.spec ORDER BY perch3_natures_laboratory_coa_capsules.natures_laboratory_coa_capsuleID DESC';
		}else{
			$sql = 'SELECT * FROM perch3_natures_laboratory_coa_capsules WHERE dateEntered>="'.$date.'" ORDER BY natures_laboratory_coa_capsuleID DESC LIMIT 20';
		}
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function updateCOAs(){
		$sql = 'SELECT * FROM perch3_natures_laboratory_coa_capsules WHERE dateEntered>="'.$date.'" ORDER BY natures_laboratory_coa_capsuleID DESC';
		$data = $this->db->get_rows($sql);
		foreach($data as $item){
			$date = $item['dateEntered'];
			$dates = explode("/",$date);
			$newDate = "$dates[2]-$dates[1]-$dates[0]";
			$sql = 'UPDATE perch3_natures_laboratory_coa_capsules SET dateEntered="'.$newDate.'" WHERE natures_laboratory_coa_capsuleID='.$item['natures_laboratory_coaID'];
			echo $sql;
			$update = $this->db->execute($sql);
		}
	}
	
	public function byBatch($batch){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_coa_capsules WHERE ourBatch="'.$batch.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
}