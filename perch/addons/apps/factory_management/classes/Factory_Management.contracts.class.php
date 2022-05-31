<?php

class Factory_Management_Suppliers_Contracts extends PerchAPI_Factory
{
    protected $table     = 'fm_suppliers_contracts';
	protected $pk        = 'contractID';
	protected $singular_classname = 'Factory_Management_Supplier_Contracts';
	
	protected $default_sort_column = 'contractID';
	
	public $static_fields = array('contractID', 'product', 'quantity', 'price', 'startDate', 'endDate', 'ACCOUNT_REF');	
	
	public function update($data){
		
		$sql = 'UPDATE perch3_fm_suppliers_contracts SET product="'.$data['product'].'", quantity="'.$data['quantity'].'", price="'.$data['price'].'", startDate="'.$data['startDate'].'", endDate="'.$data['endDate'].'", ACCOUNT_REF="'.$data['ACCOUNT_REF'].'" WHERE contractID="'.$data['contractID'].'"';
		$this->db->execute($sql);
		return true;
		
	}
	
	public function deleteContract($contract){
		
		$sql = 'DELETE FROM perch3_fm_suppliers_contracts WHERE contractID="'.$contract.'"';
		$this->db->execute($sql);
		return true;
		
	}
	
}