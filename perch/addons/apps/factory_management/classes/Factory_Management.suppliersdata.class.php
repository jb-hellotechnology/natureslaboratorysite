<?php

class Factory_Management_Suppliers_Data extends PerchAPI_Factory
{
    protected $table     = 'fm_suppliers_data';
	protected $pk        = 'ACCOUNT_REF';
	protected $singular_classname = 'Factory_Management_Supplier_Data';
	
	protected $default_sort_column = 'suppliersDataID';
	
	public $static_fields = array();	
	
	public function supplier($accountref){
		
		$sql = 'SELECT * FROM perch3_fm_suppliers_data WHERE ACCOUNT_REF="'.$accountref.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function updateSupplierData($data){

		$sql = 'SELECT * FROM perch3_fm_suppliers_data WHERE ACCOUNT_REF="'.$data['ACCOUNT_REF'].'"';
		$exists = $this->db->get_row($sql);
		if($exists){
			$sql = 'UPDATE perch3_fm_suppliers_data SET supplierDynamicFields = "'.addslashes($data['supplierDynamicFields']).'" WHERE ACCOUNT_REF="'.$data['ACCOUNT_REF'].'"';
			$data = $this->db->execute($sql);
		}else{
			$sql = 'INSERT INTO perch3_fm_suppliers_data (ACCOUNT_REF, supplierDynamicFields) VALUES ("'.$data['ACCOUNT_REF'].'", "'.addslashes($data['supplierDynamicFields']).'")';
			$data = $this->db->execute($sql);
		}
		
		return true;
		
	}
	
}