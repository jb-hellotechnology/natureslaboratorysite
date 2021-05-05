<?php

class Natures_Laboratorys extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory';
	protected $pk        = 'natures_laboratoryID';
	protected $singular_classname = 'Natures_Laboratory';
	
	protected $default_sort_column = 'natures_laboratoryID';
	
	public $static_fields   = array();	
	
}