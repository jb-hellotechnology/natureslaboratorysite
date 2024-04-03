<?php

class Natures_Laboratory_Tasks extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_tasks';
	protected $pk        = 'natures_laboratory_taskID';
	protected $singular_classname = 'Natures_Laboratory_Task';
	
	protected $default_sort_column = 'natures_laboratory_taskID';
	
	public $static_fields = array('natures_laboratory_taskID', 'date', 'title', 'dueBy', 'createdBy', 'assignedTo', 'status', 'natures_laboratory_tasksDynamicFields');	
	
	public function getTasks($q){
		
		if($q){
			$sql = 'SELECT * FROM perch3_natures_laboratory_tasks WHERE title LIKE "%'.$q.'%" ORDER BY date DESC LIMIT 200';
		}else{
			$sql = 'SELECT * FROM perch3_natures_laboratory_tasks ORDER BY date DESC LIMIT 200';
		}
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
}