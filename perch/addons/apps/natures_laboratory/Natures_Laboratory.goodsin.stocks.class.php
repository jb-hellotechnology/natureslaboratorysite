<?php

class Natures_Laboratory_Goods_Stocks extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_goods_stock';
	protected $pk        = 'natures_laboratory_goods_stockID';
	protected $singular_classname = 'Natures_Laboratory_Goods_Stock';
	
	protected $default_sort_column = 'natures_laboratory_goods_stockID';
	
	public $static_fields = array('natures_laboratory_goods_stockID,','stockCode','description','component1','component2','component3','component4','component5','component6','qty1','qty2','qty3','qty4','qty5','qty6','restriction','goods_stockDynamicFields');	
	
	public function getStock(){
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getByCode($code){
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$code.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
}