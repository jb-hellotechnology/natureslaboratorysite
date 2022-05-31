<?php

class Supplier_Questionnaires extends PerchAPI_Factory
{
    protected $table     = 'perch3_fm_suppliers_questionnaires';
	protected $pk        = 'questionnaireID';
	protected $singular_classname = 'Supplier_Questionnaire';
	
	protected $default_sort_column = 'questionnaireID';
	
	public $static_fields   = array();	
	
	public function submit_questionnaire($data){
		
		$SUPPLIER_REF = strtoupper($data['SUPPLIER_REF']);
		unset($data['SUPPLIER_REF']);
		$answers = addslashes(json_encode($data,true));
		$sql = 'INSERT INTO perch3_fm_suppliers_questionnaire (SUPPLIER_REF, answers) VALUES ("'.$SUPPLIER_REF.'", "'.$answers.'")';
		$this->db->execute($sql);
		return true;
		
	}
	
	public function getQuestionnaires($id){
		
		$sql = 'SELECT * FROM perch3_fm_suppliers_questionnaire WHERE SUPPLIER_REF="'.$id.'" ORDER BY timestamp DESC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getQuestionnaire($id){
		
		$sql = 'SELECT * FROM perch3_fm_suppliers_questionnaire WHERE questionnaireID="'.$id.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}

}