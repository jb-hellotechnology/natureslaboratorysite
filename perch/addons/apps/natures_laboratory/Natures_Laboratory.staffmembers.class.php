<?php

class Natures_Laboratory_Staff_Members extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_staff';
	protected $pk        = 'natures_laboratory_staffID';
	protected $singular_classname = 'Natures_Laboratory_Staff_Member';
	
	protected $default_sort_column = 'name';
	
	public $static_fields = array('natures_laboratory_staffID,','name','email','phone','address','startDate','staffDynamicFields');	
	
}