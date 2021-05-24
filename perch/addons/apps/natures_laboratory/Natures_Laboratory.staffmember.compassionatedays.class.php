<?php

class Natures_Laboratory_Staff_Member_Compassionatedays extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_staff_compassionatedays';
	protected $pk        = 'natures_laboratory_staff_compassionatedayID';
	protected $singular_classname = 'Natures_Laboratory_Staff_Member_Compassionateday';
	
	protected $default_sort_column = 'date';
	
	public $static_fields = array('natures_laboratory_staff_compassionatedayID,','staffID','date');	
	
	public function getDate($staffID,$date){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_staff_compassionatedays WHERE staffID="'.$staffID.'" AND date="'.$date.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getForYear($staffID,$start,$end){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_staff_compassionatedays WHERE staffID="'.$staffID.'" AND (date>="'.$start.'" AND date<="'.$end.'")';
		$data = $this->db->get_rows($sql);
		return count($data);
		
	}
	
	public function getDays($staffID){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_staff_compassionatedays WHERE staffID="'.$staffID.'" ORDER BY date DESC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
}