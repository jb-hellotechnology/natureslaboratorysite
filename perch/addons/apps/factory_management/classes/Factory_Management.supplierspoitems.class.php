<?php

class Factory_Management_Suppliers_PO_Items extends PerchAPI_Factory
{
    protected $table     = 'fm_suppliers_po_items';
	protected $pk        = 'ACCOUNT_REF';
	protected $singular_classname = 'Factory_Management_Supplier_PO_Items';
	
	protected $default_sort_column = 'POPID';
	
	public $static_fields = array();	
	
	public function poItems($id){
		
		$sql = 'SELECT * FROM perch3_fm_suppliers_po_items WHERE ORDER_NUMBER="'.$id.'"';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	
	public function poItem($po,$id){
		
		$sql = 'SELECT * FROM perch3_fm_suppliers_po_items WHERE ORDER_NUMBER="'.$po.'" AND ITEM_NUMBER="'.$id.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function poItemByStockCode($code){
		
		$sql = 'SELECT * FROM perch3_fm_suppliers_po_items WHERE STOCK_CODE="'.$code.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
}