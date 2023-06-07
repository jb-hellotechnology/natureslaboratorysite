<?php

class Natures_Laboratory_Productions extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_production';
	protected $pk        = 'natures_laboratory_productionID';
	protected $singular_classname = 'Natures_Laboratory_Production';
	
	protected $default_sort_column = 'natures_laboratory_productionID';
	
	public $static_fields = array('perch3_natures_laboratory_productionID','sku','units','specification','packaging','labelling','date','datePressed','dateSageUpdated','sageUpdatedBy','barrel','status','productionDynamicFields');	
	
	public function getShortfall(){
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE QTY_IN_STOCK<=QTY_REORDER_LEVEL AND QTY_REORDER_LEVEL>0 ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getIngredient($STOCK_CODE,$i){
		
		$sql = 'SELECT COMPONENT_CODE_'.$i.' FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$STOCK_CODE.'"';
		$data = $this->db->get_row($sql);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$data['COMPONENT_CODE_'.$i].'"';
		$ingredient = $this->db->get_row($sql);
		if($ingredient){
			return $ingredient;
		}elseif($data['COMPONENT_CODE_'.$i]=='WATER' OR $data['COMPONENT_CODE_'.$i]=='AQUA'){
			$water = array("STOCK_CODE"=>'WATER',"QTY_IN_STOCK"=>'');
			return $water;
		}
		
	}
	
	public function getScheduled(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_production WHERE status="scheduled"';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getProduction(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_production WHERE status="in production"';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getProcess($id){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_production WHERE natures_laboratory_productionID="'.$id.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	
	public function getBatches($productCode){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_goods_in WHERE productCode="'.$productCode.'" ORDER BY dateIn DESC LIMIT 5';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function saveIngredientBatch($productionID,$ingredient,$batch){
		
		$sql = 'DELETE FROM perch3_natures_laboratory_production_batches WHERE perch3_natures_laboratory_productionID="'.$productionID.'" AND productCode="'.$ingredient.'"';
		$data = $this->db->execute($sql);
		
		$sql = 'INSERT INTO perch3_natures_laboratory_production_batches (perch3_natures_laboratory_productionID, productCode, batchCode) VALUES ("'.$productionID.'", "'.$ingredient.'", "'.$batch.'")';
		$data = $this->db->execute($sql);
		
	}
	
	public function getBatchData($productionID,$productCode){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_production_batches WHERE perch3_natures_laboratory_productionID="'.$productionID.'" AND productCode="'.$productCode.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getProcesses(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_production WHERE status="on" OR status="paused" ORDER BY startTime ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getCompletedProcesses(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_production WHERE status="completed" ORDER BY startTime ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getLabelData($batch){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_labels WHERE natures_laboratory_labelID="'.$batch.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function products(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_labels_products ORDER BY productCode ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getProducts(){
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE NOT LIKE "%/%" ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getProduct($productID){
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$productID.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function deleteLabel($labelID){
		
		$sql = 'DELETE FROM perch3_natures_laboratory_labels WHERE natures_laboratory_labelID="'.$labelID.'"';
		$data = $this->db->execute($sql);
		
	}
	
}