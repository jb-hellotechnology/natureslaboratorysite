<?php

class Natures_Laboratory_Tasks extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_task';
	protected $pk        = 'natures_laboratory_taskID';
	protected $singular_classname = 'Natures_Laboratory_Task';
	
	protected $default_sort_column = 'natures_laboratory_taskID';
	
	public $static_fields = array('natures_laboratory_taskID,','natures_laboratory_taskDynamicFields');	
	
}