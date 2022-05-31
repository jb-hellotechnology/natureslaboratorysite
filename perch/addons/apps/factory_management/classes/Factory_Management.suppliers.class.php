<?php

class Factory_Management_Suppliers extends PerchAPI_Factory
{
    protected $table     = 'fm_suppliers';
	protected $pk        = 'SUPPLIERID';
	protected $singular_classname = 'Factory_Management_Supplier';
	
	protected $default_sort_column = 'NAME';
	
	public $static_fields = array();	
	
	public function suppliers($q,$approved){
		
		if($approved){
			if($q){
				$sql = 'SELECT * FROM perch3_fm_suppliers, perch3_fm_suppliers_data WHERE perch3_fm_suppliers.ACCOUNT_REF = perch3_fm_suppliers_data.ACCOUNT_REF AND perch3_fm_suppliers_data.supplierDynamicFields LIKE \'%"status":"Approved"%\' AND perch3_fm_suppliers.NAME LIKE \'%'.$q.'%\'';
			}else{
				$sql = 'SELECT * FROM perch3_fm_suppliers, perch3_fm_suppliers_data WHERE perch3_fm_suppliers.ACCOUNT_REF = perch3_fm_suppliers_data.ACCOUNT_REF AND perch3_fm_suppliers_data.supplierDynamicFields LIKE \'%"status":"Approved"%\'';
			}
		}else{
			if($q){
				$sql = 'SELECT * FROM perch3_fm_suppliers WHERE NAME LIKE "%'.$q.'%" OR ACCOUNT_REF LIKE "%'.$q.'%" ORDER BY ACCOUNT_REF';
			}else{
				$sql = 'SELECT * FROM perch3_fm_suppliers ORDER BY ACCOUNT_REF';
			}
		}
		$data = $this->return_instances($this->db->get_rows($sql));
		return $data;
		
	}
	
	public function approvedSuppliers($q){
		
		if($q){
			$sql = 'SELECT * FROM perch3_fm_suppliers_data WHERE ACCOUNT_REF LIKE "%'.$q.'%" AND supplierDynamicFields LIKE "%\"Approved\"%" ORDER BY ACCOUNT_REF';
		}else{
			$sql = 'SELECT * FROM perch3_fm_suppliers_data WHERE supplierDynamicFields LIKE "%\"Approved\"%" ORDER BY ACCOUNT_REF';
		}
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function supplier($accountref){
		
		$sql = 'SELECT * FROM perch3_fm_suppliers WHERE SUPPLIERID="'.$accountref.'" ORDER BY SUPPLIERID DESC LIMIT 1';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function supplierByRef($accountref){
		
		$sql = 'SELECT * FROM perch3_fm_suppliers WHERE ACCOUNT_REF="'.$accountref.'" ORDER BY SUPPLIERID DESC LIMIT 1';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
}