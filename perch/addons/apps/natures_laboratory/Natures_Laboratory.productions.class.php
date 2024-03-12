<?php

class Natures_Laboratory_Productions extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_production';
	protected $pk        = 'natures_laboratory_productionID';
	protected $singular_classname = 'Natures_Laboratory_Production';
	
	protected $default_sort_column = 'natures_laboratory_productionID';
	
	public $static_fields = array('perch3_natures_laboratory_productionID','sku','units','specification','packaging','labelling','date','datePressed','dateSageUpdated','sageUpdatedBy','barrel','status','bbe','productionDynamicFields');	
	
	public function getByBatch($batch){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_production WHERE finishedBatch="'.$batch.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getShortfall($category){
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE QTY_IN_STOCK<=QTY_REORDER_LEVEL AND QTY_REORDER_LEVEL>0 AND STOCK_CAT="'.$category.'" ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function notInProduction($sku){
		$sql = 'SELECT * FROM perch3_natures_laboratory_production WHERE sku="'.$sku.'" AND (status="scheduled" OR status="in production")';
		$data = $this->db->get_rows($sql);
		if($data){
			return false;
		}else{
			return true;
		}
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
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_production WHERE status="scheduled" ORDER BY natures_laboratory_productionID ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getProduction(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_production WHERE status="in production" ORDER BY natures_laboratory_productionID ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getCompleted(){
		
		$sql = 'SELECT perch3_natures_laboratory_production.*, perch3_natureslaboratory_stock.DESCRIPTION AS DESCRIPTION FROM perch3_natures_laboratory_production, perch3_natureslaboratory_stock WHERE perch3_natures_laboratory_production.status="completed" ORDER BY perch3_natures_laboratory_production.natures_laboratory_productionID DESC';
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
	
	public function saveIngredientBatch($productionID,$ingredient,$batch,$batchAlt){
		
		$sql = 'DELETE FROM perch3_natures_laboratory_production_batches WHERE perch3_natures_laboratory_productionID="'.$productionID.'" AND productCode="'.$ingredient.'"';
		$data = $this->db->execute($sql);
		
		$sql = 'INSERT INTO perch3_natures_laboratory_production_batches (perch3_natures_laboratory_productionID, productCode, batchCode, batchCodeAlt) VALUES ("'.$productionID.'", "'.$ingredient.'", "'.$batch.'", "'.$batchAlt.'")';
		$data = $this->db->execute($sql);
		
	}
	
	public function getBatchData($productionID,$productCode){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_production_batches WHERE perch3_natures_laboratory_productionID="'.$productionID.'" AND productCode="'.$productCode.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getBatchBBE($batchCode){
		
		$sql = 'SELECT bbe FROM perch3_natures_laboratory_goods_in WHERE ourBatch="'.$batchCode.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getBatchNumber(){
		
		$sql = 'SELECT finishedBatch FROM perch3_natures_laboratory_production ORDER BY finishedBatch DESC LIMIT 1';
		$data = $this->db->get_row($sql);
		if($data['finishedBatch']){
			$number = $data['finishedBatch']+1;
		}else{
			$number = 100000;
		}
		return $number;
		
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
	
	public function getProductsAll(){
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getProduct($productID){
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$productID.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getLabelSpec($productID){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_labels_products WHERE productCode="'.$productID.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function deleteLabel($labelID){
		
		$sql = 'DELETE FROM perch3_natures_laboratory_labels WHERE natures_laboratory_labelID="'.$labelID.'"';
		$data = $this->db->execute($sql);
		
	}
	
	public function storeFormulation($id){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_production WHERE natures_laboratory_productionID="'.$id.'"';
		$productionData = $this->db->get_row($sql);
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$productionData['sku'].'"';
		$productData = $this->db->get_row($sql);
		
		$i = 1;
		$json = '[';
		while($i<=50){
			
			$ingredient = $productData['COMPONENT_CODE_'.$i];
			$qty = $productData['COMPONENT_QTY_'.$i];
			
			$batchQty = $productionData['units']*$qty;
			if($ingredient=='ALC96'){
				$batchQty = round($batchQty*1.04,2);
			}
			
			$json .= '{"'.$ingredient.'":"'.$batchQty.'"},';
			
			$i++;	
		}
		$json = substr($json,0,-1);
		$json .= ']';
		
		$sql = "UPDATE perch3_natures_laboratory_production SET formulationLog='".$json."' WHERE natures_laboratory_productionID='".$id."'";
		$update = $this->db->execute($sql);
		
	}
	
}