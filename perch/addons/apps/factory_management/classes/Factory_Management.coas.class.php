<?php

class Factory_Management_COAs extends PerchAPI_Factory
{
    protected $table     = 'fm_coa';
	protected $pk        = 'coaID';
	protected $singular_classname = 'Factory_Management_COA';
	
	protected $default_sort_column = 'coaID';
	
	public $static_fields = array('coaID,','staff','productCode','productDescription','dateIn','supplier','qty','suppliersBatch','ourBatch','bbe','qa','coaDynamicFields');	
	
	public function getCOAs(){
		
		$sql = 'SELECT * FROM perch3_fm_coa ORDER BY coaID DESC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function updateCOAs(){
		$sql = 'SELECT * FROM perch3_fm_coa WHERE dateEntered>="'.$date.'" ORDER BY coaID DESC';
		$data = $this->db->get_rows($sql);
		foreach($data as $item){
			$date = $item['dateEntered'];
			$dates = explode("/",$date);
			$newDate = "$dates[2]-$dates[1]-$dates[0]";
			$sql = 'UPDATE perch3_fm_coa SET dateEntered="'.$newDate.'" WHERE coaID='.$item['coaID'];
			echo $sql;
			$update = $this->db->execute($sql);
		}
	}
	
	public function byBatch($batch){
		
		$sql = 'SELECT * FROM perch3_fm_coa WHERE ourBatch="'.$batch.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
}