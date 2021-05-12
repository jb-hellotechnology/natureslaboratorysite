<?php

class Natures_Laboratory_Staff_Member_Earlyfinishes extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_staff_earlyfinish';
	protected $pk        = 'natures_laboratory_staff_earlyfinishID';
	protected $singular_classname = 'Natures_Laboratory_Staff_Member_Earlyfinish';
	
	protected $default_sort_column = 'date';
	
	public $static_fields = array('natures_laboratory_staff_earlyfinishID,','date','targetHit');	
	
	public function getDate($date){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_staff_earlyfinish WHERE date="'.$date.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
}