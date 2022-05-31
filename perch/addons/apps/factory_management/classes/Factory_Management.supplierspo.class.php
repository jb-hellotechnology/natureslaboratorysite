<?php

class Factory_Management_Suppliers_PO extends PerchAPI_Factory
{
    protected $table     = 'fm_suppliers_po';
	protected $pk        = 'ORDER_NUMBER';
	protected $singular_classname = 'Factory_Management_Supplier_PO';
	
	protected $default_sort_column = 'ORDER_DATE';
	
	public $static_fields = array();
	
	public function getAll($page){
		
		$sql = 'SELECT * FROM perch3_fm_suppliers_po ORDER BY ORDER_NUMBER DESC LIMIT 0,25';
		$data = $this->db->get_rows($sql);
		return $this->return_instances($data);
		
	}	
	
	public function purchaseOrder($id){
		
		$sql = 'SELECT * FROM perch3_fm_suppliers_po WHERE ORDER_NUMBER="'.$id.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function purchaseOrders($account_ref){

		$sql = 'SELECT * FROM perch3_fm_suppliers_po WHERE ACCOUNT_REF="'.$account_ref.'" ORDER BY POID DESC';
		$data = $this->db->get_rows($sql);
		return $this->return_instances($data);
		
	}
	
}