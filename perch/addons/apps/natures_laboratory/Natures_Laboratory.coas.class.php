<?php

class Natures_Laboratory_COAs extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_coa';
	protected $pk        = 'natures_laboratory_coaID';
	protected $singular_classname = 'Natures_Laboratory_COA';
	
	protected $default_sort_column = 'natures_laboratory_coaID';
	
	public $static_fields = array('natures_laboratory_coaID,','staff','productCode','productDescription','dateIn','supplier','qty','suppliersBatch','ourBatch','bbe','qa','goods_inDynamicFields');	
	
	public function getCOAs($q){
		
		$today = date('Y-m-d');
		$date = strtotime($today.' -1 year');
		$date = date('Y-m-d', $date);
		
		if($q){
			$sql = 'SELECT perch3_natures_laboratory_coa.*, perch3_natureslaboratory_stock.* FROM perch3_natures_laboratory_coa, perch3_natureslaboratory_stock WHERE perch3_natures_laboratory_coa.dateEntered>="'.$date.'" AND (perch3_natures_laboratory_coa.productCode="'.$q.'" OR perch3_natures_laboratory_coa.ourBatch="'.$q.'" OR perch3_natureslaboratory_stock.DESCRIPTION LIKE "%'.$q.'%") AND perch3_natureslaboratory_stock.STOCK_CODE=perch3_natures_laboratory_coa.productCode ORDER BY perch3_natures_laboratory_coa.natures_laboratory_coaID DESC';
		}else{
			$sql = 'SELECT * FROM perch3_natures_laboratory_coa WHERE dateEntered>="'.$date.'" ORDER BY natures_laboratory_coaID DESC LIMIT 20';
		}
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
	
}