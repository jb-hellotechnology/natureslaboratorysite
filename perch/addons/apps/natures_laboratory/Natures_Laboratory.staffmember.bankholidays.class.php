<?php

class Natures_Laboratory_Staff_Member_Bankholidays extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_staff_bankholidays';
	protected $pk        = 'natures_laboratory_staff_bankholidayID';
	protected $singular_classname = 'Natures_Laboratory_Staff_Member_Bankholiday';
	
	protected $default_sort_column = 'date';
	
	public $static_fields = array('natures_laboratory_staff_bankholidayID,','date');
	
}