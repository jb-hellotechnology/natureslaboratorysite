<?php

class Natures_Laboratory_COA_Oils_Countries extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_coa_oils_countries';
	protected $pk        = 'natures_laboratory_coa_oils_countryID';
	protected $singular_classname = 'Natures_Laboratory_COA_Oils_Country';
	
	protected $default_sort_column = 'country';
	
	public $static_fields = array('natures_laboratory_coa_oils_countryID,','country');	
	
}