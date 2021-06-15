<?php

class Natures_Laboratory_COA_Specs extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_coa_spec';
	protected $pk        = 'natures_laboratory_coa_specID';
	protected $singular_classname = 'Natures_Laboratory_COA_Spec';
	
	protected $default_sort_column = 'natures_laboratory_coa_specID';
	
	public $static_fields = array('natures_laboratory_coa_specID,','productCode','commonName','biologicalSource','plantPart','productDescription','countryOfOrigin','colour','odor','taste','macroscopicCharacters','microscopicCharacters','foreignMatter','lossOnDrying','totalAsh','ashInsolubleInHCI','assayContent','leadPb','arsenicAs','mercuryHg','totalAerobicMicrobialContent','totalCombinedYeastMouldsCount','enterobacteriaCountIncludingPsuedomonas','escherhichiaColi','salmonella','staphylococcusAureus','mycotoxinsAflatoxinsOchratoxinA','pesticides','allergens');	
	
	public function getSpec($code){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_coa_spec WHERE productCode="'.$code.'"';
		$data = $this->db->get_row($sql);
		$json = json_encode($data);
		return $json;
		
	}
	
}