<?php

class Natures_Laboratory_Goods_Ins extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_goods_in';
	protected $pk        = 'natures_laboratory_goods_inID';
	protected $singular_classname = 'Natures_Laboratory_Goods_In';
	
	protected $default_sort_column = 'natures_laboratory_goods_inID';
	
	public $static_fields = array('natures_laboratory_goods_inID,','staff','productCode','productDescription','dateIn','supplier','qty','suppliersBatch','ourBatch','bbe','qa','goods_inDynamicFields');	
	
	public function getGoodsIn(){
		
		$today = date('Y-m-d');
		$date = strtotime($today.' -1 year');
		$date = date('Y-m-d', $date);
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_goods_in WHERE dateIn>="'.$date.'" ORDER BY dateIn DESC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getBatchData($batch){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_goods_in WHERE ourBatch='.$batch;
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getBatchNumber(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_goods_in ORDER BY ourBatch DESC LIMIT 1';
		$data = $this->db->get_row($sql);
		$batch = $data['ourBatch']+1;
		return $batch;
		
	}
	
}