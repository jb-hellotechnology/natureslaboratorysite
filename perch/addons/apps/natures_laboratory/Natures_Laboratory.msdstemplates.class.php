<?php

class Natures_Laboratory_MSDS_Templates extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_msds_templates';
	protected $pk        = 'natures_laboratory_msds_templateID';
	protected $singular_classname = 'Natures_Laboratory_MSDS_Template';
	
	protected $default_sort_column = 'natures_laboratory_msds_templateID';
	
	public $static_fields = array('natures_laboratory_msds_templateID,','productType','natures_laboratory_msds_templateDynamicFields');	
	
	public function getMSDSTemplate($id){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_msds_templates WHERE natures_laboratory_msds_templateID="'.$id.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function allTemplates(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_msds_templates ORDER BY productType ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
}