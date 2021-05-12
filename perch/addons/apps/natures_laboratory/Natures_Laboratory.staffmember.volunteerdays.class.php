<?php

class Natures_Laboratory_Staff_Member_Volunteerdays extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_staff_volunteerdays';
	protected $pk        = 'natures_laboratory_staff_volunteerdayID';
	protected $singular_classname = 'Natures_Laboratory_Staff_Member_Volunteerday';
	
	protected $default_sort_column = 'date';
	
	public $static_fields = array('natures_laboratory_staff_volunteerdayID,','staffID','date');	
	
	public function getDate($staffID,$date){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_staff_volunteerdays WHERE staffID="'.$staffID.'" AND date="'.$date.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getDays($staffID){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_staff_volunteerdays WHERE staffID="'.$staffID.'" ORDER BY date DESC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}

	
}