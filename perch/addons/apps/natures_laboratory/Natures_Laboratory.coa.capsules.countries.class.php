<?php

class Natures_Laboratory_COA_Capsules_Countries extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_coa_capsules_countries';
	protected $pk        = 'natures_laboratory_coa_capsules_countryID';
	protected $singular_classname = 'Natures_Laboratory_COA_Capsules_Country';
	
	protected $default_sort_column = 'country';
	
	public $static_fields = array('natures_laboratory_coa_capsules_countryID,','country');	
	
}