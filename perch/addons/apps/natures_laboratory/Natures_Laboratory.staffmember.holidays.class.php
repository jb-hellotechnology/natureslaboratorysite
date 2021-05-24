<?php

class Natures_Laboratory_Staff_Member_Holidays extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_staff_holidays';
	protected $pk        = 'natures_laboratory_staff_holidayID';
	protected $singular_classname = 'Natures_Laboratory_Staff_Member_Holiday';
	
	protected $default_sort_column = 'date';
	
	public $static_fields = array('natures_laboratory_staff_holidayID,','date','staffID','length');

	public function getDate($staffID, $date){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_staff_holidays WHERE staffID="'.$staffID.'" AND date="'.$date.'"';
		$data = $this->db->get_rows($sql);

		return($data);
		
	}
	
	public function getForYear($staffID,$start,$end){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_staff_holidays WHERE staffID="'.$staffID.'" AND (date>="'.$start.'" AND date<="'.$end.'")';
		$data = $this->db->get_rows($sql);
		return count($data);
		
	}
	
	public function byStaffID($id){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_staff_holidays WHERE staffID="'.$id.'" ORDER BY date DESC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}	
}