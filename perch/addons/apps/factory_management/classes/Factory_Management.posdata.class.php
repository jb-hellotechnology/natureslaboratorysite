<?php

class Factory_Management_Suppliers_PO_Data extends PerchAPI_Factory
{
    protected $table     = 'fm_suppliers_po_data';
	protected $pk        = 'suppliersPOID';
	protected $singular_classname = 'Factory_Management_Supplier_PO_Data';
	
	protected $default_sort_column = 'suppliersPOID';
	
	public $static_fields = array();	
	
	public function po($id){
		
		$sql = 'SELECT * FROM perch3_fm_suppliers_po_data WHERE POID="'.$id.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function updatePOData($data){

		$sql = 'SELECT * FROM perch3_fm_suppliers_po_data WHERE POID="'.$data['POID'].'"';
		$exists = $this->db->get_row($sql);
		if($exists){
			$sql = 'UPDATE perch3_fm_suppliers_po_data SET poDynamicFields = "'.addslashes($data['poDynamicFields']).'", QAC = "'.addslashes($data['QAC']).'" WHERE POID="'.$data['POID'].'"';
			$data = $this->db->execute($sql);
		}else{
			$sql = 'INSERT INTO perch3_fm_suppliers_po_data (POID, poDynamicFields, QAC) VALUES ("'.$data['POID'].'", "'.addslashes($data['poDynamicFields']).'", "'.addslashes($data['QAC']).'")';
			$data = $this->db->execute($sql);
		}
		
		return true;
		
	}
	
}