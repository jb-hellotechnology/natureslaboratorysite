<?php

class Natures_Laboratory_Staff_Member_Times extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_staff_time';
	protected $pk        = 'natures_laboratory_staff_timeID';
	protected $singular_classname = 'Natures_Laboratory_Staff_Member_Time';
	
	protected $default_sort_column = 'timeStamp';
	
	public $static_fields = array('natures_laboratory_staff_timeID,','staffID','timeType','timeStamp','timemotoData','natures_laboratory_staff_timeDynamicFields');	
	
	public function timemoto_log($name,$timeLoggedRounded,$attendanceStatus,$timemotoData){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_staff WHERE name="'.$name.'" ORDER BY name ASC LIMIT 1';
		$data = $this->db->get_row($sql);
		
		$time = array();
	    $time['staffID'] = $data['natures_laboratory_staffID'];
	    $time['timeType'] = $attendanceStatus;
	    $time['timeStamp'] = str_replace("T", " ", $timeLoggedRounded);
	    $time['timemotoData'] = $timemotoData;

	    $insert = $this->db->insert('perch3_natures_laboratory_staff_time', $time);
		
	}
	
}