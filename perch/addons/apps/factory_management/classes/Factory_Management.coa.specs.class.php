<?php

class Factory_Management_COA_Specs extends PerchAPI_Factory
{
    protected $table     = 'fm_coa_spec';
	protected $pk        = 'specID';
	protected $singular_classname = 'Factory_Management_COA_Spec';
	
	protected $default_sort_column = 'specID';
	
	public $static_fields = array('specID,','productCode','commonName','biologicalSource','plantPart','productDescription','countryOfOrigin','colour','odor','taste','macroscopicCharacters','microscopicCharacters','foreignMatter','lossOnDrying','totalAsh','ashInsolubleInHCI','assayContent','leadPb','arsenicAs','mercuryHg','totalAerobicMicrobialContent','totalCombinedYeastMouldsCount','enterobacteriaCountIncludingPsuedomonas','escherhichiaColi','salmonella','staphylococcusAureus','mycotoxinsAflatoxinsOchratoxinA','pesticides','allergens');	
	
	public function getSpec($code){
		
		$sql = 'SELECT * FROM perch3_fm_coa_spec WHERE productCode="'.$code.'"';
		$data = $this->db->get_row($sql);
		$json = json_encode($data);
		return $json;
		
	}
	
	public function byCode($code){
		
		$sql = 'SELECT * FROM perch3_fm_coa_spec WHERE productCode="'.$code.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}

}