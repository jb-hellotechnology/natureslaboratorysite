<?php

class Natures_Laboratory_Nonconformances extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_nonconformance';
	protected $pk        = 'natures_laboratory_nonconformanceID';
	protected $singular_classname = 'Natures_Laboratory_Nonconformance';
	
	protected $default_sort_column = 'natures_laboratory_nonconformanceID';
	
	public $static_fields = array('natures_laboratory_nonconformanceID','date','type','title','nonconformanceDynamicFields');	
	
	public function getNonconformances($q){
		
		if($q){
			$sql = 'SELECT * FROM perch3_natures_laboratory_nonconformance WHERE title LIKE "%'.$q.'%" ORDER BY date DESC LIMIT 200';
		}else{
			$sql = 'SELECT * FROM perch3_natures_laboratory_nonconformance ORDER BY date DESC LIMIT 200';
		}
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getCount($month, $type){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_nonconformance WHERE type="'.$type.'" AND LEFT(date,7)="'.$month.'"';
		$data = $this->db->get_rows($sql);
		return count($data);
		
	}
	
}