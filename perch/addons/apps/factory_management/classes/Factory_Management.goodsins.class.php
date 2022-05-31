<?php

class Factory_Management_Goods_Ins extends PerchAPI_Factory
{
    protected $table     = 'fm_goodsin';
	protected $pk        = 'goodsinID';
	protected $singular_classname = 'Factory_Management_Goods_In';
	
	protected $default_sort_column = 'goodinID';
	
	public $static_fields = array('goodsinID', 'staff', 'dateIn', 'qty', 'unit', 'suppliersBatch', 'ourBatch', 'bbe', 'countryOfOrigin');	
	
	public function getGoodsIn($id,$item){
		
		$sql = 'SELECT * FROM perch3_fm_goodsin WHERE po="'.$id.'" AND poItem="'.$item.'"';
		$data = $this->db->get_row($sql);
		return $this->return_instance($data);
		
	}
	
	public function updateGoodsIn($data,$id){
		$this->db->update('perch3_fm_goodsin', $data, 'goodsinID', $id);
		return true;
	}
	
}