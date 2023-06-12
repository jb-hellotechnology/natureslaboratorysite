<?php

class Natures_Laboratory_Goods_Ins extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_goods_in';
	protected $pk        = 'natures_laboratory_goods_inID';
	protected $singular_classname = 'Natures_Laboratory_Goods_In';
	
	protected $default_sort_column = 'natures_laboratory_goods_inID';
	
	public $static_fields = array('natures_laboratory_goods_inID,','staff','productCode','productDescription','dateIn','supplier','qty','bagsList','suppliersBatch','ourBatch','bbe','qa','goods_inDynamicFields');	
	
	public function getGoodsIn(){
		
		$today = date('Y-m-d');
		$date = strtotime($today.' -2 year');
		$date = date('Y-m-d', $date);
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_goods_in WHERE dateIn>="'.$date.'" ORDER BY ourBatch DESC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getDescription($code){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$code.'"';
		$data = $this->db->get_row($sql);
		return $data['DESCRIPTION'];
	}
	
	public function getRestriction($code){
		$sql = 'SELECT * FROM perch3_natures_laboratory_goods_stock WHERE stockCode="'.$code.'"';
		$data = $this->db->get_row($sql);
		return $data['restriction'];
	}
	
	public function getByCode($code){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$code.'"';
		$data = $this->db->get_row($sql);
		return $data;
	}
	
	public function getStock(){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getBatchData($batch){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_goods_in WHERE ourBatch='.$batch;
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getBatchesData($batch){
		
		$sql = 'SELECT suppliersBatch, ourBatch, productCode FROM perch3_natures_laboratory_goods_in WHERE productCode="'.$batch.'" ORDER BY dateIn DESC';
		$data = $this->db->get_rows($sql);
		$coa = false;
		if($data){
			$html = '<p><strong>Replicate Existing COA Data</strong></p><table><tr><th>Supplier&rsquo;s Batch</th><th>Our Batch</th></tr>';
			foreach($data as $row){
				$sql2 = 'SELECT * FROM perch3_natures_laboratory_coa WHERE productCode="'.$row['productCode'].'" AND ourBatch="'.$row['ourBatch'].'"';
				$data2 = $this->db->get_row($sql2);
				if($data2){
					$coa = true;
					$html .= '<tr><td><a href="javascript:selectCOA(\'coa_'.$data2['natures_laboratory_coaID'].'\')" id="coa_'.$data2['natures_laboratory_coaID'].'" data-coa=\''.str_replace("'","",addslashes(json_encode($data2,true))).'\'>'.$row['suppliersBatch'].'</a></td><td>'.$row['ourBatch'].'</td></tr>';
				}
			}
			$html .= '</tr>';
		}
		if($coa){
			return $html;
		}
	}
	
	public function stockItem($stockCode){
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$stockCode.'"';
		$data = $this->db->get_row($sql);
		return $data;
		
	}
	
	public function getBatchNumber(){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_goods_in ORDER BY ourBatch DESC LIMIT 1';
		$data = $this->db->get_row($sql);
		$batch = $data['ourBatch']+1;
		return $batch;
		
	}
	
	public function coaExists($batch){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_coa WHERE ourBatch="'.$batch.'"';
		$data = $this->db->get_row($sql);
		if($data['dateEntered']<>''){
			return 'TRUE';
		}else{
			return 'FALSE';
		}
		
	}
	
	public function checkCodes($code,$batch){
		
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$code.'"';
		$data = $this->db->get_row($sql);
		if($data['category']=='5' OR $data['category']=='6' OR $data['category']=='7'){
			
			$sql = 'SELECT * FROM perch3_natures_laboratory_goods_in WHERE productCode="'.$code.'" AND ourBatch="'.$batch.'"';
			$data = $this->db->get_row($sql);
			if($data){
				echo true;
			}else{
				echo false;
			}
			
		}else{
			echo true;
		}
		
	}
	
}