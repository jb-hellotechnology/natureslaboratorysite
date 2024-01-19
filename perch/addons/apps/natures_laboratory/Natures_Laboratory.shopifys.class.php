<?php
	
class Natures_Laboratory_Shopifys extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_shopify';
	protected $pk        = 'natures_laboratory_productID';
	protected $singular_classname = 'Natures_Laboratory_Shopify';
	
	protected $default_sort_column = 'natures_laboratory_productID';
	
	public $static_fields = array('perch3_natures_laboratory_productID','SKU','categoryID','name','qty','price','handle','productDynamicFields');	

	
/*
	public function emptyStock(){
		$sql = 'TRUNCATE TABLE perch3_natureslaboratory_stock';
		$this->db->execute($sql);
	}
*/

	public function lastImport(){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock ORDER BY CREATED DESC LIMIT 1';
		$data = $this->db->get_row($sql);
		$parts = explode(" ",$data['CREATED']);
		$dateParts = explode("-",$parts[0]);
		$timeParts = explode(":",$parts[1]);
		return date("F d Y H:i:s", mktime($timeParts[0], $timeParts[1], $timeParts[2], $dateParts[1], $dateParts[2], $dateParts[0]));
	}
	
	public function importStock(){
		
		$fp = file('../../../../../sagedata/perchstock.csv');
		
		$filename = '../../../../../sagedata/perchstock.csv';
		$rowCount = 0;
		
		// Open the file for reading
		$file = fopen($filename, 'r');
		
		// Check if the file was opened successfully
		if ($file) {
		    // Loop through each line in the file
		    while (($line = fgetcsv($file)) !== false) {
		        // Increment the row count for each line
		        $rowCount++;
		    }
		
		    // Close the file
		    fclose($file);
		
		    // Output the total row count
		    //echo "Total rows in $filename: $rowCount<br />";
		} else {
		    // Handle the case where the file couldn't be opened
		    //echo "Error opening file: $filename<br />";
		}
		
		if($rowCount>4000){

			$sql = 'SELECT * FROM perch3_natureslaboratory_stock';
			$data = $this->db->get_rows($sql);
			$rows = count($data);
			if($rows>4000){

				//echo "More than 4000 rows in _stock<br />Truncating _stock_prev<br />";
				
				$sql = 'TRUNCATE TABLE perch3_natureslaboratory_stock_prev';
				$this->db->execute($sql);
				
				//echo "Inserting * from _stock into _stock_prev<br />";
				
				$sql = 'INSERT INTO perch3_natureslaboratory_stock_prev SELECT * FROM perch3_natureslaboratory_stock';
				$this->db->execute($sql);
				
				//echo "Checking rows in _stock_prev<br />";
				
				$sql = 'SELECT * FROM perch3_natureslaboratory_stock_prev';
				$data = $this->db->get_rows($sql);
				$rows = count($data);
				
				if($rows>4000){
				
					//echo "More than 4000 rows in _stock_prev<br />Truncating _stock<br />";
				
					$sql = 'TRUNCATE TABLE perch3_natureslaboratory_stock';
					$this->db->execute($sql);
					
					//echo "Reading .csv file into _stock<br />";
					
					$csvFile = file('../../../../../sagedata/perchstock.csv');
					$i = 0;
				    foreach ($csvFile as $line) {
					    if($i>=1){
					        $data = str_getcsv($line);
					        $str = '';
					        foreach($data as $item){
						       if($item){
							       $str.="'".addslashes($item)."', ";
						       }else{
							       $str .= "0, ";
						       }
					        }
					        
					        $str = substr($str, 0, -2);
			
							$sql = "INSERT INTO 
				perch3_natureslaboratory_stock 
				(ITEM_ID, STOCK_CODE, DESCRIPTION, UNIT_OF_SALE, NOMINAL_CODE, PURCHASE_REF, SUPPLIER_PART_NUMBER, LOCATION, COMMODITY_CODE, SALES_PRICE, WEB_DESCRIPTION, WEB_DETAILS, WEB_CATEGORY_1, WEB_CATEGORY_2, WEB_CATEGORY_3, WEB_IMAGE_FILE, WEB_PUBLISH, WEB_SPECIAL, INTRASTAT_COMM_CODE, INTRASTAT_IMPORT_DUTY_CODE, SUPP_UNIT_QTY, IGNORE_STK_LVL_FLAG, DEPT_NUMBER, DEPT_NAME, TAX_CODE, ASSEMBLY_LEVEL, LINK_LEVEL, STOCK_CAT, STOCK_CAT_NAME, STOCK_TAKE_DATE, LAST_PURCHASE_PRICE, LAST_DISC_PURCHASE_PRICE, AVERAGE_COST_PRICE, QTY_IN_STOCK, QTY_ON_ORDER, QTY_ALLOCATED, QTY_LAST_ORDER, QTY_REORDER, QTY_REORDER_LEVEL, QTY_LAST_STOCK_TAKE, QTY_MAKEUP, LAST_SALE_DATE, LAST_PURCHASE_DATE, UNIT_WEIGHT, HAS_NO_COMPONENT, HAS_BOM, BARCODE, COMPONENT_CODE_1, COMPONENT_CODE_2, COMPONENT_CODE_3, COMPONENT_CODE_4, COMPONENT_CODE_5, COMPONENT_CODE_6, COMPONENT_CODE_7, COMPONENT_CODE_8, COMPONENT_CODE_9, COMPONENT_CODE_10, COMPONENT_CODE_11, COMPONENT_CODE_12, COMPONENT_CODE_13, COMPONENT_CODE_14, COMPONENT_CODE_15, COMPONENT_CODE_16, COMPONENT_CODE_17, COMPONENT_CODE_18, COMPONENT_CODE_19, COMPONENT_CODE_20, COMPONENT_CODE_21, COMPONENT_CODE_22, COMPONENT_CODE_23, COMPONENT_CODE_24, COMPONENT_CODE_25, COMPONENT_CODE_26, COMPONENT_CODE_27, COMPONENT_CODE_28, COMPONENT_CODE_29, COMPONENT_CODE_30, COMPONENT_CODE_31, COMPONENT_CODE_32, COMPONENT_CODE_33, COMPONENT_CODE_34, COMPONENT_CODE_35, COMPONENT_CODE_36, COMPONENT_CODE_37, COMPONENT_CODE_38, COMPONENT_CODE_39, COMPONENT_CODE_40, COMPONENT_CODE_41, COMPONENT_CODE_42, COMPONENT_CODE_43, COMPONENT_CODE_44, COMPONENT_CODE_45, COMPONENT_CODE_46, COMPONENT_CODE_47, COMPONENT_CODE_48, COMPONENT_CODE_49, COMPONENT_CODE_50, COMPONENT_QTY_1, COMPONENT_QTY_2, COMPONENT_QTY_3, COMPONENT_QTY_4, COMPONENT_QTY_5, COMPONENT_QTY_6, COMPONENT_QTY_7, COMPONENT_QTY_8, COMPONENT_QTY_9, COMPONENT_QTY_10, COMPONENT_QTY_11, COMPONENT_QTY_12, COMPONENT_QTY_13, COMPONENT_QTY_14, COMPONENT_QTY_15, COMPONENT_QTY_16, COMPONENT_QTY_17, COMPONENT_QTY_18, COMPONENT_QTY_19, COMPONENT_QTY_20, COMPONENT_QTY_21, COMPONENT_QTY_22, COMPONENT_QTY_23, COMPONENT_QTY_24, COMPONENT_QTY_25, COMPONENT_QTY_26, COMPONENT_QTY_27, COMPONENT_QTY_28, COMPONENT_QTY_29, COMPONENT_QTY_30, COMPONENT_QTY_31, COMPONENT_QTY_32, COMPONENT_QTY_33, COMPONENT_QTY_34, COMPONENT_QTY_35, COMPONENT_QTY_36, COMPONENT_QTY_37, COMPONENT_QTY_38, COMPONENT_QTY_39, COMPONENT_QTY_40, COMPONENT_QTY_41, COMPONENT_QTY_42, COMPONENT_QTY_43, COMPONENT_QTY_44, COMPONENT_QTY_45, COMPONENT_QTY_46, COMPONENT_QTY_47, COMPONENT_QTY_48, COMPONENT_QTY_49, COMPONENT_QTY_50, QTY_SOLD_BF, QTY_SOLD_MTH1, QTY_SOLD_MTH2, QTY_SOLD_MTH3, QTY_SOLD_MTH4, QTY_SOLD_MTH5, QTY_SOLD_MTH6, QTY_SOLD_MTH7, QTY_SOLD_MTH8, QTY_SOLD_MTH9, QTY_SOLD_MTH10, QTY_SOLD_MTH11, QTY_SOLD_MTH12, QTY_SOLD_FUTURE, SALES_BF, SALES_MTH1, SALES_MTH2, SALES_MTH3, SALES_MTH4, SALES_MTH5, SALES_MTH6, SALES_MTH7, SALES_MTH8, SALES_MTH9, SALES_MTH10, SALES_MTH11, SALES_MTH12, SALES_FUTURE, COST_BF, COST_MTH1, COST_MTH2, COST_MTH3, COST_MTH4, COST_MTH5, COST_MTH6, COST_MTH7, COST_MTH8, COST_MTH9, COST_MTH10, COST_MTH11, COST_MTH12, COST_FUTURE, THIS_RECORD, BUDGET_QTY_SOLD_BF, BUDGET_QTY_SOLD_MTH1, BUDGET_QTY_SOLD_MTH2, BUDGET_QTY_SOLD_MTH3, BUDGET_QTY_SOLD_MTH4, BUDGET_QTY_SOLD_MTH5, BUDGET_QTY_SOLD_MTH6, BUDGET_QTY_SOLD_MTH7, BUDGET_QTY_SOLD_MTH8, BUDGET_QTY_SOLD_MTH9, BUDGET_QTY_SOLD_MTH10, BUDGET_QTY_SOLD_MTH11, BUDGET_QTY_SOLD_MTH12, BUDGET_QTY_SOLD_FUTURE, BUDGET_SALES_BF, BUDGET_SALES_MTH1, BUDGET_SALES_MTH2, BUDGET_SALES_MTH3, BUDGET_SALES_MTH4, BUDGET_SALES_MTH5, BUDGET_SALES_MTH6, BUDGET_SALES_MTH7, BUDGET_SALES_MTH8, BUDGET_SALES_MTH9, BUDGET_SALES_MTH10, BUDGET_SALES_MTH11, BUDGET_SALES_MTH12, BUDGET_SALES_FUTURE, PRIOR_YR_QTY_SOLD_BF, PRIOR_YR_QTY_SOLD_MTH1, PRIOR_YR_QTY_SOLD_MTH2, PRIOR_YR_QTY_SOLD_MTH3, PRIOR_YR_QTY_SOLD_MTH4, PRIOR_YR_QTY_SOLD_MTH5, PRIOR_YR_QTY_SOLD_MTH6, PRIOR_YR_QTY_SOLD_MTH7, PRIOR_YR_QTY_SOLD_MTH8, PRIOR_YR_QTY_SOLD_MTH9, PRIOR_YR_QTY_SOLD_MTH10, PRIOR_YR_QTY_SOLD_MTH11, PRIOR_YR_QTY_SOLD_MTH12, PRIOR_YR_QTY_SOLD_FUTURE, PRIOR_YR_SALES_BF, PRIOR_YR_SALES_MTH1, PRIOR_YR_SALES_MTH2, PRIOR_YR_SALES_MTH3, PRIOR_YR_SALES_MTH4, PRIOR_YR_SALES_MTH5, PRIOR_YR_SALES_MTH6, PRIOR_YR_SALES_MTH7, PRIOR_YR_SALES_MTH8, PRIOR_YR_SALES_MTH9, PRIOR_YR_SALES_MTH10, PRIOR_YR_SALES_MTH11, PRIOR_YR_SALES_MTH12, PRIOR_YR_SALES_FUTURE, PRIOR_YR_COST_BF, PRIOR_YR_COST_MTH1, PRIOR_YR_COST_MTH2, PRIOR_YR_COST_MTH3, PRIOR_YR_COST_MTH4, PRIOR_YR_COST_MTH5, PRIOR_YR_COST_MTH6, PRIOR_YR_COST_MTH7, PRIOR_YR_COST_MTH8, PRIOR_YR_COST_MTH9, PRIOR_YR_COST_MTH10, PRIOR_YR_COST_MTH11, PRIOR_YR_COST_MTH12, PRIOR_YR_COST_FUTURE, DISC_A_LEVEL_1_QTY, DISC_A_LEVEL_2_QTY, DISC_A_LEVEL_3_QTY, DISC_A_LEVEL_4_QTY, DISC_A_LEVEL_5_QTY, DISC_A_LEVEL_6_QTY, DISC_A_LEVEL_7_QTY, DISC_A_LEVEL_8_QTY, DISC_A_LEVEL_9_QTY, DISC_A_LEVEL_10_QTY, DISC_A_LEVEL_1_RATE, DISC_A_LEVEL_2_RATE, DISC_A_LEVEL_3_RATE, DISC_A_LEVEL_4_RATE, DISC_A_LEVEL_5_RATE, DISC_A_LEVEL_6_RATE, DISC_A_LEVEL_7_RATE, DISC_A_LEVEL_8_RATE, DISC_A_LEVEL_9_RATE, DISC_A_LEVEL_10_RATE, DISC_B_LEVEL_1_QTY, DISC_B_LEVEL_2_QTY, DISC_B_LEVEL_3_QTY, DISC_B_LEVEL_4_QTY, DISC_B_LEVEL_5_QTY, DISC_B_LEVEL_6_QTY, DISC_B_LEVEL_7_QTY, DISC_B_LEVEL_8_QTY, DISC_B_LEVEL_9_QTY, DISC_B_LEVEL_10_QTY, DISC_B_LEVEL_1_RATE, DISC_B_LEVEL_2_RATE, DISC_B_LEVEL_3_RATE, DISC_B_LEVEL_4_RATE, DISC_B_LEVEL_5_RATE, DISC_B_LEVEL_6_RATE, DISC_B_LEVEL_7_RATE, DISC_B_LEVEL_8_RATE, DISC_B_LEVEL_9_RATE, DISC_B_LEVEL_10_RATE, DISC_C_LEVEL_1_QTY, DISC_C_LEVEL_2_QTY, DISC_C_LEVEL_3_QTY, DISC_C_LEVEL_4_QTY, DISC_C_LEVEL_5_QTY, DISC_C_LEVEL_6_QTY, DISC_C_LEVEL_7_QTY, DISC_C_LEVEL_8_QTY, DISC_C_LEVEL_9_QTY, DISC_C_LEVEL_10_QTY, DISC_C_LEVEL_1_RATE, DISC_C_LEVEL_2_RATE, DISC_C_LEVEL_3_RATE, DISC_C_LEVEL_4_RATE, DISC_C_LEVEL_5_RATE, DISC_C_LEVEL_6_RATE, DISC_C_LEVEL_7_RATE, DISC_C_LEVEL_8_RATE, DISC_C_LEVEL_9_RATE, DISC_C_LEVEL_10_RATE, DISC_D_LEVEL_1_QTY, DISC_D_LEVEL_2_QTY, DISC_D_LEVEL_3_QTY, DISC_D_LEVEL_4_QTY, DISC_D_LEVEL_5_QTY, DISC_D_LEVEL_6_QTY, DISC_D_LEVEL_7_QTY, DISC_D_LEVEL_8_QTY, DISC_D_LEVEL_9_QTY, DISC_D_LEVEL_10_QTY, DISC_D_LEVEL_1_RATE, DISC_D_LEVEL_2_RATE, DISC_D_LEVEL_3_RATE, DISC_D_LEVEL_4_RATE, DISC_D_LEVEL_5_RATE, DISC_D_LEVEL_6_RATE, DISC_D_LEVEL_7_RATE, DISC_D_LEVEL_8_RATE, DISC_D_LEVEL_9_RATE, DISC_D_LEVEL_10_RATE, DISC_E_LEVEL_1_QTY, DISC_E_LEVEL_2_QTY, DISC_E_LEVEL_3_QTY, DISC_E_LEVEL_4_QTY, DISC_E_LEVEL_5_QTY, DISC_E_LEVEL_6_QTY, DISC_E_LEVEL_7_QTY, DISC_E_LEVEL_8_QTY, DISC_E_LEVEL_9_QTY, DISC_E_LEVEL_10_QTY, DISC_E_LEVEL_1_RATE, DISC_E_LEVEL_2_RATE, DISC_E_LEVEL_3_RATE, DISC_E_LEVEL_4_RATE, DISC_E_LEVEL_5_RATE, DISC_E_LEVEL_6_RATE, DISC_E_LEVEL_7_RATE, DISC_E_LEVEL_8_RATE, DISC_E_LEVEL_9_RATE, DISC_E_LEVEL_10_RATE, PURCHASE_NOMINAL_CODE, INACTIVE_FLAG, COUNTRY_CODE_OF_ORIGIN, RECORD_CREATE_DATE, RECORD_MODIFY_DATE, RECORD_DELETED) 
				VALUES 
				(".$str.")";
							$this->db->execute($sql);
						}
						$i++;
					}
					//echo "Done!<br />";
				}else{
					//echo '.csv file is empty #1<br />';
				}
			
			}
		
		}else{
			//echo '.csv file is empty #2';
			mail('jack@natureslaboratory.co.uk','Stock Import Failed', 'HA Stock import failed');
		}
		
		// UPDATE SHOPIFY STOCK LEVELS ON HA
		$sql = "SELECT perch3_natureslaboratory_stock.STOCK_CODE AS STOCKCODE, perch3_natureslaboratory_stock.QTY_IN_STOCK AS NEWSTOCK, perch3_natureslaboratory_stock_prev.QTY_IN_STOCK AS OLDSTOCK FROM perch3_natureslaboratory_stock, perch3_natureslaboratory_stock_prev WHERE (perch3_natureslaboratory_stock.STOCK_CODE = perch3_natureslaboratory_stock_prev.STOCK_CODE) AND perch3_natureslaboratory_stock.QTY_IN_STOCK < perch3_natureslaboratory_stock_prev.QTY_IN_STOCK AND perch3_natureslaboratory_stock.STOCK_CAT=2 AND perch3_natureslaboratory_stock.WEB_PUBLISH=1 ORDER BY perch3_natureslaboratory_stock.STOCK_CODE ASC;";
		
	}

	public function getParents($category,$slash,$stock){
		$stockLevel = '';
		if($stock){
			$stockLevel = 'AND QTY_IN_STOCK>0 ';
		}
		$slashQ = '';
		if($slash){
			$slashQ = 'AND STOCK_CODE NOT LIKE "%/%" ';
		}
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND STOCK_CAT="'.$category.'" '.$slashQ.''.$stockLevel.'ORDER BY DESCRIPTION ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getCapsules(){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND STOCK_CAT="8" AND DESCRIPTION NOT LIKE "%/%" ORDER BY DESCRIPTION ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getBySKU($sku){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND STOCK_CODE="'.$sku.'"';
		$data = $this->db->get_row($sql);
		return $data;
	}
	
	public function getOrganic($sku){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND STOCK_CODE="'.$sku.'" ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_row($sql);
		return $data;
	}
	
	public function getChildren($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND STOCK_CODE LIKE "'.$sku.'/%" AND STOCK_CODE NOT LIKE "%/ORG%" AND DESCRIPTION NOT LIKE "%Discontinued%" ORDER BY STOCK_CODE DESC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getOrganicChildren($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND STOCK_CODE LIKE "'.$sku.'/%" AND DESCRIPTION NOT LIKE "%Discontinued%" ORDER BY STOCK_CODE DESC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getParentsCapsules($stock){
		$stockLevel = '';
		if($stock){
			$stockLevel = 'AND QTY_IN_STOCK>0 ';
		}
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND STOCK_CODE LIKE "%/1000%" AND STOCK_CAT="8" '.$stockLevel.'ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getParentsRetailCapsules($stock){
		$stockLevel = '';
		if($stock){
			$stockLevel = 'AND QTY_IN_STOCK>0 ';
		}
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND LEFT (STOCK_CODE, 1) = "C" AND STOCK_CAT="8" '.$stockLevel.'ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getParentsBiodynamic($stock){
		$stockLevel = '';
		if($stock){
			$stockLevel = 'AND QTY_IN_STOCK>0 ';
		}
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND STOCK_CODE LIKE "B%" AND STOCK_CODE NOT LIKE "/" AND STOCK_CAT="80" '.$stockLevel.'ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getParentsPessaries($stock){
		$stockLevel = '';
		if($stock){
			$stockLevel = 'AND QTY_IN_STOCK>0 ';
		}
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND STOCK_CODE LIKE "PESS/%" AND STOCK_CAT="17" '.$stockLevel.'ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getChildrenCapsules($sku){
		$skuParts = explode("/",$sku);
		$sku = substr($sku, 0, -1);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND STOCK_CODE="'.$sku.'" ORDER BY STOCK_CODE DESC';
		$data = $this->db->get_rows($sql);
		//print_r($data);
		return $data;
	}
	
	public function getCatalogueParents($category){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND (STOCK_CODE NOT LIKE "%/%" AND STOCK_CODE NOT LIKE "%/ORG%") AND STOCK_CAT="'.$category.'" ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getCatalogueParentsCapsules(){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND (STOCK_CODE LIKE "%/1000%") AND STOCK_CAT="8" ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getCatalogueChildrenCapsules($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE WEB_PUBLISH="1" AND STOCK_CODE LIKE "'.$sku.'/%" ORDER BY STOCK_CODE DESC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function productImage($sku){
		$sku = str_replace("_","/",$sku);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE = "'.$sku.'"';
		$data = $this->db->get_row($sql);
		if($data['STOCK_CAT']=='2' OR $data['STOCK_CAT']=='4' OR $data['STOCK_CAT']=='15' OR $data['STOCK_CAT']=='18'){
			//TINCTURE FLUID OR ORGANIC
		    header("Content-type: image/jpeg");
		    $img_path = '../perch/addons/apps/natures_laboratory/assets/images/liquids.jpg';
		    $font_path = realpath("../perch/addons/apps/natures_laboratory/Helvetica.ttf");
		    $jpg_img = imagecreatefromjpeg($img_path);
		    $font_color = imagecolorallocate($jpg_img, 1, 139, 145);
		    $text = $data['DESCRIPTION'];
		    $lines = explode('|', wordwrap($text, 20, '|'));
		    $y = 1120;
		    foreach ($lines as $line)
			{
		    	imagettftext($jpg_img, 40, 0, 680, $y, $font_color, $font_path, $line);
		    	$y += 68;
		    }
		    imagejpeg($jpg_img);
		    imagedestroy($jpg_img);
		}elseif($data['STOCK_CAT']=='5' OR $data['STOCK_CAT']=='6' OR $data['STOCK_CAT']=='7' OR $data['STOCK_CAT']=='8' OR ($data['STOCK_CAT']=='17' AND substr($data['STOCK_CODE'],0,4)<>'PESS')){
			//CUT WHOLE POWDER CAPSULE
			header("Content-type: image/jpeg");
		    $img_path = '../perch/addons/apps/natures_laboratory/assets/images/herbs.jpg';
		    $font_path = realpath("../perch/addons/apps/natures_laboratory/Helvetica.ttf");
		    $jpg_img = imagecreatefromjpeg($img_path);
		    $font_color = imagecolorallocate($jpg_img, 1, 139, 145);
		    $text = $data['DESCRIPTION'];
		    $lines = explode('|', wordwrap($text, 20, '|'));
		    $y = 920;
		    foreach ($lines as $line)
			{
		    	imagettftext($jpg_img, 46, 0, 650, $y, $font_color, $font_path, $line);
		    	$y += 70;
		    }
		    imagejpeg($jpg_img);
		    imagedestroy($jpg_img);
		}elseif($data['STOCK_CAT']=='11' OR ($data['STOCK_CAT']=='17' AND substr($data['STOCK_CODE'],0,4)=='PESS')){
			//CREAMS
			header("Content-type: image/jpeg");
		    $img_path = '../perch/addons/apps/natures_laboratory/assets/images/creams.jpg';
		    $font_path = realpath("../perch/addons/apps/natures_laboratory/Helvetica.ttf");
		    $jpg_img = imagecreatefromjpeg($img_path);
		    $font_color = imagecolorallocate($jpg_img, 1, 139, 145);
		    $text = $data['DESCRIPTION'];
		    $lines = explode('|', wordwrap($text, 20, '|'));
		    $y = 980;
		    foreach ($lines as $line)
			{
		    	imagettftext($jpg_img, 54, 0, 570, $y, $font_color, $font_path, $line);
		    	$y += 78;
		    }
		    imagejpeg($jpg_img);
		    imagedestroy($jpg_img);
		}elseif($data['STOCK_CAT']=='12'){
			//ESSENTIAL OILS
			header("Content-type: image/jpeg");
		    $img_path = '../perch/addons/apps/natures_laboratory/assets/images/essentialoils.jpg';
		    $font_path = realpath("../perch/addons/apps/natures_laboratory/Helvetica.ttf");
		    $jpg_img = imagecreatefromjpeg($img_path);
		    $font_color = imagecolorallocate($jpg_img, 1, 139, 145);
		    $text = $data['DESCRIPTION'];
		    $lines = explode('|', wordwrap($text, 13, '|'));
		    $y = 1330;
		    foreach ($lines as $line)
			{
		    	imagettftext($jpg_img, 54, 0, 710, $y, $font_color, $font_path, $pad.$line);
		    	$y += 76;
		    }
		    imagejpeg($jpg_img);
		    imagedestroy($jpg_img);
		}elseif($data['STOCK_CAT']=='10' OR $data['STOCK_CAT']=='22'){
			//SWEET CECILYS & BEEVITAL
			header("Content-type: image/jpeg");
			$image = imagecreatefromjpeg("../perch/addons/apps/natures_laboratory/assets/images/".$sku.".jpg");
			imagejpeg($image);
		}else{
			//SOMETHING ELSE
			header("Content-type: image/jpeg");
			$image = imagecreatefromjpeg("../perch/addons/apps/natures_laboratory/assets/images/herbal_apothecary_logo.jpg");
			imagejpeg($image);
		}
	}
	
	public function onOffer($sku){
		$sql = 'SELECT * FROM perch3_natures_laboratory_stock_offers WHERE STOCK_CODE="'.$sku.'"';
		$data = $this->db->get_row($sql);
		if($data){
			return true;
		}else{
			return false;
		}
	}
	
	public function offerPrice($sku){
		$sql = 'SELECT * FROM perch3_natures_laboratory_stock_offers WHERE STOCK_CODE="'.$sku.'"';
		$data = $this->db->get_row($sql);
		if($data){
			$price = 'SELECT SALES_PRICE FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$sku.'"';
			$price = $this->db->get_row($price);
			$m = (100-$data['discount'])/100;
			$offerPrice = number_format($price['SALES_PRICE']*$m,2);
			return $offerPrice;
		}
	}
	
	public function syncbv($token){
		
		// Get Stock Levels for BV Products
		$products = "SELECT * FROM perch3_natureslaboratory_stock WHERE LEFT(STOCK_CODE, 2)='BV'";
		$productResults = $this->db->get_rows($products);
		foreach($productResults as $product) {
			
			//print_r($product);
			
			$productSh = "SELECT * FROM perch3_natures_laboratory_shopify_bv WHERE STOCK_CODE='".$product['STOCK_CODE']."'";
			$productSh = $this->db->get_row($productSh);
			
			if(substr($product['STOCK_CODE'], -1)=='T'){
			
				// Get single SKU
				$sku = rtrim($product['STOCK_CODE'], 'T');
				$productSa = "SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE='".$sku."'";
				$productSa = $this->db->get_row($productSa);
				if($productSa){
					
					$qty = floor(($productSa['QTY_IN_STOCK'] - $productSa['QTY_ALLOCATED'])/6);
					if($qty<0){
						$qty = 0;
					}
					
					// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
					$ch = curl_init();
					
					curl_setopt($ch, CURLOPT_URL, 'https://beevital-propolis.myshopify.com/admin/api/2023-10/inventory_levels/set.json');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"location_id\":77880295744,\"inventory_item_id\":$productSh[inventory_item_id],\"available\":$qty}");
					
					$headers = array();
					$headers[] = 'X-Shopify-Access-Token: '.$token;
					$headers[] = 'Content-Type: application/json';
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					
					$result = curl_exec($ch);
					if (curl_errno($ch)) {
					    echo 'Error:' . curl_error($ch);
					}
					curl_close($ch);	
					
					sleep(0.5);
					
				}
			
			}elseif(substr($product['STOCK_CODE'], -3)=='T/G'){
			
				// Get single SKU
				$productSa = "SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE='BV42/G'";
				$productSa = $this->db->get_row($productSa);
				if($productSa){
					
					$qty = floor(($productSa['QTY_IN_STOCK'] - $productSa['QTY_ALLOCATED'])/6);
					if($qty<0){
						$qty = 0;
					}
					
					// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
					$ch = curl_init();
					
					curl_setopt($ch, CURLOPT_URL, 'https://beevital-propolis.myshopify.com/admin/api/2023-10/inventory_levels/set.json');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"location_id\":77880295744,\"inventory_item_id\":$productSh[inventory_item_id],\"available\":$qty}");
					
					$headers = array();
					$headers[] = 'X-Shopify-Access-Token: '.$token;
					$headers[] = 'Content-Type: application/json';
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					
					$result = curl_exec($ch);
					if (curl_errno($ch)) {
					    echo 'Error:' . curl_error($ch);
					}
					curl_close($ch);	
					
					sleep(0.5);
					
				}
			
			}elseif(substr($product['STOCK_CODE'], -2)=='/2'){
			
				// Get single SKU
				$sku = rtrim($product['STOCK_CODE'], '/2');
				$productSa = "SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE='".$sku."'";
				$productSa = $this->db->get_row($productSa);
				if($productSa){
					
					$qty = floor(($productSa['QTY_IN_STOCK'] - $productSa['QTY_ALLOCATED'])/2);
					if($qty<0){
						$qty = 0;
					}
					
					// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
					$ch = curl_init();
					
					curl_setopt($ch, CURLOPT_URL, 'https://beevital-propolis.myshopify.com/admin/api/2023-10/inventory_levels/set.json');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"location_id\":77880295744,\"inventory_item_id\":$productSh[inventory_item_id],\"available\":$qty}");
					
					$headers = array();
					$headers[] = 'X-Shopify-Access-Token: '.$token;
					$headers[] = 'Content-Type: application/json';
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					
					$result = curl_exec($ch);
					if (curl_errno($ch)) {
					    echo 'Error:' . curl_error($ch);
					}
					curl_close($ch);	
					
					sleep(0.5);
					
				}
				
			}elseif(substr($product['STOCK_CODE'], -2)=='/3'){
			
				// Get single SKU
				$sku = rtrim($product['STOCK_CODE'], '/3');
				$productSa = "SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE='".$sku."'";
				$productSa = $this->db->get_row($productSa);
				if($productSa){
					
					$qty = floor(($productSa['QTY_IN_STOCK'] - $productSa['QTY_ALLOCATED'])/3);
					if($qty<0){
						$qty = 0;
					}
					
					// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
					$ch = curl_init();
					
					curl_setopt($ch, CURLOPT_URL, 'https://beevital-propolis.myshopify.com/admin/api/2023-10/inventory_levels/set.json');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"location_id\":77880295744,\"inventory_item_id\":$productSh[inventory_item_id],\"available\":$qty}");
					
					$headers = array();
					$headers[] = 'X-Shopify-Access-Token: '.$token;
					$headers[] = 'Content-Type: application/json';
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					
					$result = curl_exec($ch);
					if (curl_errno($ch)) {
					    echo 'Error:' . curl_error($ch);
					}
					curl_close($ch);	
					
					sleep(0.5);
					
				}
				
			}else{
				
				$productS = "SELECT * FROM perch3_natures_laboratory_shopify_bv WHERE STOCK_CODE='".$product['STOCK_CODE']."'";
				$productS = $this->db->get_row($productS);
				if($productS){
					
					$qty = $product['QTY_IN_STOCK'] - $product['QTY_ALLOCATED'];
					if($qty<0){
						$qty = 0;
					}
					// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
					$ch = curl_init();
					
					curl_setopt($ch, CURLOPT_URL, 'https://beevital-propolis.myshopify.com/admin/api/2023-10/inventory_levels/set.json');
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"location_id\":77880295744,\"inventory_item_id\":$productS[inventory_item_id],\"available\":$qty}");
					
					$headers = array();
					$headers[] = 'X-Shopify-Access-Token: '.$token;
					$headers[] = 'Content-Type: application/json';
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					
					$result = curl_exec($ch);
					if (curl_errno($ch)) {
					    echo 'Error:' . curl_error($ch);
					}
					curl_close($ch);	
					
					sleep(0.5);
					
				}
			
			}
		
		}
		
	}
	
	public function syncsc($token){
		
		$products = "SELECT * FROM perch3_natureslaboratory_stock WHERE LEFT(STOCK_CODE, 2)='SC'";
		$products = $this->db->get_rows($products);
		foreach($products as $product) {
			
			$productS = "SELECT * FROM perch3_natures_laboratory_shopify_sc WHERE STOCK_CODE='".$product['STOCK_CODE']."'";
			$productS = $this->db->get_row($productS);
			if($productS){
				
				$qty = $product['QTY_IN_STOCK'] - $product['QTY_ALLOCATED'];
				if($qty<0){
					$qty = 0;
				}
				// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
				$ch = curl_init();
				
				curl_setopt($ch, CURLOPT_URL, 'https://sweet-cecilys.myshopify.com/admin/api/2023-10/inventory_levels/set.json');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"location_id\":77875183890,\"inventory_item_id\":$productS[inventory_item_id],\"available\":$qty}");
				
				$headers = array();
				$headers[] = 'X-Shopify-Access-Token: '.$token;
				$headers[] = 'Content-Type: application/json';
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				
				$result = curl_exec($ch);
				if (curl_errno($ch)) {
				    echo 'Error:' . curl_error($ch);
				}
				curl_close($ch);	
				
				//print_r($result);
				
				sleep(0.5);
				
			}
			
		}
		
	}
	
	public function syncha($token){
		
		$output = "";
		
		// CATEGORY 1, 11, 12, 13, 14 & 15 - Chemicals, Creams, Essential Oils, Fixed Oils, Packaging, Waxes/Gums
		
		$products = "SELECT perch3_natureslaboratory_stock.STOCK_CODE AS STOCKCODE, (perch3_natureslaboratory_stock.QTY_IN_STOCK - perch3_natureslaboratory_stock.QTY_ALLOCATED) AS NEWSTOCK, (perch3_natureslaboratory_stock_prev.QTY_IN_STOCK - perch3_natureslaboratory_stock_prev.QTY_ALLOCATED) AS OLDSTOCK FROM perch3_natureslaboratory_stock, perch3_natureslaboratory_stock_prev WHERE (perch3_natureslaboratory_stock.STOCK_CODE = perch3_natureslaboratory_stock_prev.STOCK_CODE) AND ((perch3_natureslaboratory_stock.QTY_IN_STOCK != perch3_natureslaboratory_stock_prev.QTY_IN_STOCK) OR (perch3_natureslaboratory_stock.QTY_ALLOCATED != perch3_natureslaboratory_stock_prev.QTY_ALLOCATED)) AND (perch3_natureslaboratory_stock.STOCK_CAT=1 OR perch3_natureslaboratory_stock.STOCK_CAT=11 OR perch3_natureslaboratory_stock.STOCK_CAT=12 OR perch3_natureslaboratory_stock.STOCK_CAT=13 OR perch3_natureslaboratory_stock.STOCK_CAT=14 OR perch3_natureslaboratory_stock.STOCK_CAT=15) AND perch3_natureslaboratory_stock.WEB_PUBLISH=1 ORDER BY perch3_natureslaboratory_stock.STOCK_CODE ASC";
		$products = $this->db->get_rows($products);
		foreach($products as $product) {
			
			$productS = "SELECT * FROM perch3_natures_laboratory_shopify_ha WHERE STOCK_CODE='".$product['STOCKCODE']."'";
			$productS = $this->db->get_row($productS);
			if($productS){
				
				$output .= "$product[STOCKCODE] from $product[OLDSTOCK] -> $product[NEWSTOCK]<br />";
				$this->shopifyInventory('herbal-apothecary-uk.myshopify.com','78941028643',$productS['inventory_item_id'],number_format($product['NEWSTOCK'],0),$token);
				sleep(0.5);
				
			}
			
		}
		
		// CATEGORY 2 & 4 - Tinctures and Fluid Extracts
		
		$products = "SELECT perch3_natureslaboratory_stock.STOCK_CODE AS STOCKCODE, (perch3_natureslaboratory_stock.QTY_IN_STOCK - perch3_natureslaboratory_stock.QTY_ALLOCATED) AS NEWSTOCK, (perch3_natureslaboratory_stock_prev.QTY_IN_STOCK - perch3_natureslaboratory_stock_prev.QTY_ALLOCATED) AS OLDSTOCK FROM perch3_natureslaboratory_stock, perch3_natureslaboratory_stock_prev WHERE (perch3_natureslaboratory_stock.STOCK_CODE = perch3_natureslaboratory_stock_prev.STOCK_CODE) AND ((perch3_natureslaboratory_stock.QTY_IN_STOCK != perch3_natureslaboratory_stock_prev.QTY_IN_STOCK) OR (perch3_natureslaboratory_stock.QTY_ALLOCATED != perch3_natureslaboratory_stock_prev.QTY_ALLOCATED)) AND (perch3_natureslaboratory_stock.STOCK_CAT=2 OR perch3_natureslaboratory_stock.STOCK_CAT=4) AND perch3_natureslaboratory_stock.WEB_PUBLISH=1 ORDER BY perch3_natureslaboratory_stock.STOCK_CODE ASC";
		$products = $this->db->get_rows($products);
		foreach($products as $product) {
			
			$productS = "SELECT * FROM perch3_natures_laboratory_shopify_ha WHERE STOCK_CODE='".$product['STOCKCODE']."'";
			$productS = $this->db->get_row($productS);
			if($productS){
				
				$output .= "$product[STOCKCODE] from $product[OLDSTOCK] -> $product[NEWSTOCK]<br />";
				$this->shopifyInventory('herbal-apothecary-uk.myshopify.com','78941028643',$productS['inventory_item_id'],number_format($product['NEWSTOCK'],0),$token);
				sleep(0.5);
				
				//if single litre, update 5, 10 and 25 litres
				if (!strpos($product['STOCKCODE'], '/')) {
					//5000
					$output .= "$product[STOCKCODE]/5000 from $product[OLDSTOCK] -> ".floor($product['NEWSTOCK']/5)."<br />";
					$this->shopifyInventory('herbal-apothecary-uk.myshopify.com','78941028643',$productS['inventory_item_id'],number_format(floor($product['NEWSTOCK']/5),0),$token);
					sleep(0.5);
					
					//10000
					$output .= "$product[STOCKCODE]/10000 from $product[OLDSTOCK] -> ".floor($product['NEWSTOCK']/10)."<br />";
					$this->shopifyInventory('herbal-apothecary-uk.myshopify.com','78941028643',$productS['inventory_item_id'],number_format(floor($product['NEWSTOCK']/10),0),$token);
					sleep(0.5);
					
					//25000
					$output .= "$product[STOCKCODE]/25000 from $product[OLDSTOCK] -> ".floor($product['NEWSTOCK']/25)."<br />";
					$this->shopifyInventory('herbal-apothecary-uk.myshopify.com','78941028643',$productS['inventory_item_id'],number_format(floor($product['NEWSTOCK']/25),0),$token);
					sleep(0.5);
				}
				
			}
			
		}
		
		// CATEGORY 5, 6, 7 & 17 - Cuts, Wholes, Powders & Powder Blends
		
		$products = "SELECT perch3_natureslaboratory_stock.STOCK_CODE AS STOCKCODE, (perch3_natureslaboratory_stock.QTY_IN_STOCK - perch3_natureslaboratory_stock.QTY_ALLOCATED) AS NEWSTOCK, (perch3_natureslaboratory_stock_prev.QTY_IN_STOCK - perch3_natureslaboratory_stock_prev.QTY_ALLOCATED) AS OLDSTOCK FROM perch3_natureslaboratory_stock, perch3_natureslaboratory_stock_prev WHERE (perch3_natureslaboratory_stock.STOCK_CODE = perch3_natureslaboratory_stock_prev.STOCK_CODE) AND ((perch3_natureslaboratory_stock.QTY_IN_STOCK != perch3_natureslaboratory_stock_prev.QTY_IN_STOCK) OR (perch3_natureslaboratory_stock.QTY_ALLOCATED != perch3_natureslaboratory_stock_prev.QTY_ALLOCATED)) AND (perch3_natureslaboratory_stock.STOCK_CAT=5 OR perch3_natureslaboratory_stock.STOCK_CAT=6 OR perch3_natureslaboratory_stock.STOCK_CAT=7 OR perch3_natureslaboratory_stock.STOCK_CAT=17) AND perch3_natureslaboratory_stock.WEB_PUBLISH=1 AND perch3_natureslaboratory_stock.STOCK_CODE NOT LIKE '%/%' ORDER BY perch3_natureslaboratory_stock.STOCK_CODE ASC";
		$products = $this->db->get_rows($products);
		foreach($products as $product) {
			
			$productS = "SELECT * FROM perch3_natures_laboratory_shopify_ha WHERE STOCK_CODE='".$product['STOCKCODE']."'";
			$productS = $this->db->get_row($productS);
			if($productS){
				
				if($product['NEWSTOCK']<1){
					$product['NEWSTOCK'] = 0;
				}
				
				//KG
				$output .= "$product[STOCKCODE] from $product[OLDSTOCK] -> $product[NEWSTOCK]<br />";
				$this->shopifyInventory('herbal-apothecary-uk.myshopify.com','78941028643',$productS['inventory_item_id'],number_format($product['NEWSTOCK'],0),$token);
				sleep(0.5);
				
				//500g
				$output .= "$product[STOCKCODE]/500 from $product[OLDSTOCK] -> ".floor($product['NEWSTOCK']*2)."<br />";
				$this->shopifyInventory('herbal-apothecary-uk.myshopify.com','78941028643',$productS['inventory_item_id'],number_format(floor($product['NEWSTOCK']*2),0),$token);
				sleep(0.5);
				
				//250g
				$output .= "$product[STOCKCODE]/250 from $product[OLDSTOCK] -> ".floor($product['NEWSTOCK']*4)."<br />";
				$this->shopifyInventory('herbal-apothecary-uk.myshopify.com','78941028643',$productS['inventory_item_id'],number_format(floor($product['NEWSTOCK']*4),0),$token);
				sleep(0.5);
				
				//5kg
				$output .= "$product[STOCKCODE]/5000 from $product[OLDSTOCK] -> ".floor($product['NEWSTOCK']/5)."<br />";
				$this->shopifyInventory('herbal-apothecary-uk.myshopify.com','78941028643',$productS['inventory_item_id'],number_format(floor($product['NEWSTOCK']/5),0),$token);
				sleep(0.5);
				
				//10kg
				$output .= "$product[STOCKCODE]/10000 from $product[OLDSTOCK] -> ".floor($product['NEWSTOCK']/10)."<br />";
				$this->shopifyInventory('herbal-apothecary-uk.myshopify.com','78941028643',$productS['inventory_item_id'],number_format(floor($product['NEWSTOCK']/10),0),$token);
				sleep(0.5);
				
				//25kg
				$output .= "$product[STOCKCODE]/25000 from $product[OLDSTOCK] -> ".floor($product['NEWSTOCK']/25)."<br />";
				$this->shopifyInventory('herbal-apothecary-uk.myshopify.com','78941028643',$productS['inventory_item_id'],number_format(floor($product['NEWSTOCK']/25),0),$token);
				sleep(0.5);
			}
			
		}
		
		return $output;
		
	}
	
	public function shopifyInventory($url,$location,$product,$qty,$token){
		
		//echo "$url $location $product $qty $token<br />";
				
		// Generated by curl-to-PHP: http://incarnate.github.io/curl-to-php/
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, 'https://' . $url. '/admin/api/2023-10/inventory_levels/set.json');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"location_id\":$location,\"inventory_item_id\":$product,\"available\":$qty}");
		
		$headers = array();
		$headers[] = 'X-Shopify-Access-Token: '.$token;
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		
		echo "{\"location_id\":$location,\"inventory_item_id\":$product,\"available\":$qty}<br />";
		print_r($result);
		echo "<br />";
		
	}
	
}