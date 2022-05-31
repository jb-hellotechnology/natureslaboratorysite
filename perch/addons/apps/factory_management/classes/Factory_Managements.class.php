<?php

class Factory_Managements extends PerchAPI_Factory
{
    protected $table     = 'factory_management';
	protected $pk        = 'factory_managementID';
	protected $singular_classname = 'Factory_Management';
	
	protected $default_sort_column = 'factory_managementID';
	
	public $static_fields   = array();	

}