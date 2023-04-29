<?php

class Natures_Laboratory_Shopifys extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_shopify';
	protected $pk        = 'natures_laboratory_productID';
	protected $singular_classname = 'Natures_Laboratory_Shopify';
	
	protected $default_sort_column = 'natures_laboratory_productID';
	
	public $static_fields = array('perch3_natures_laboratory_productID','SKU','categoryID','name','qty','price','handle','productDynamicFields');	
	
	public function emptyStock(){
		$sql = 'TRUNCATE TABLE perch3_natureslaboratory_stock';
		$this->db->execute($sql);
	}
	
	public function importStock(){
		$csvFile = file('uploads/stock.csv');
		$i = 0;
	    foreach ($csvFile as $line) {
		    if($i>=0){
		        $data = str_getcsv($line);
		        $str = '';
		        foreach($data as $item){
			       if($item){
				       $str.="'$item', ";
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
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CAT="'.$category.'" '.$slashQ.''.$stockLevel.'ORDER BY DESCRIPTION ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getOrganic($sku){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE="'.$sku.'" ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_row($sql);
		return $data;
	}
	
	public function getChildren($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE LIKE "'.$sku.'/%" AND STOCK_CODE NOT LIKE "%/ORG%" AND DESCRIPTION NOT LIKE "%Discontinued%" ORDER BY STOCK_CODE DESC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getOrganicChildren($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE LIKE "'.$sku.'/%" AND DESCRIPTION NOT LIKE "%Discontinued%" ORDER BY STOCK_CODE DESC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getParentsCapsules($stock){
		$stockLevel = '';
		if($stock){
			$stockLevel = 'AND QTY_IN_STOCK>0 ';
		}
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE (STOCK_CODE LIKE "%/1000%") AND STOCK_CAT="8" '.$stockLevel.'ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getChildrenCapsules($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE LIKE "'.$sku.'/%" ORDER BY STOCK_CODE DESC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getCatalogueParents($category){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE (STOCK_CODE NOT LIKE "%/%" AND STOCK_CODE NOT LIKE "%/ORG%") AND STOCK_CAT="'.$category.'" ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getCatalogueParentsCapsules(){
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE (STOCK_CODE LIKE "%/1000%") AND STOCK_CAT="8" ORDER BY STOCK_CODE ASC';
		$data = $this->db->get_rows($sql);
		return $data;
	}
	
	public function getCatalogueChildrenCapsules($sku){
		$skuParts = explode("/",$sku);
		$sql = 'SELECT * FROM perch3_natureslaboratory_stock WHERE STOCK_CODE LIKE "'.$sku.'/%" ORDER BY STOCK_CODE DESC';
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
		}elseif($data['STOCK_CAT']=='5' OR $data['STOCK_CAT']=='6' OR $data['STOCK_CAT']=='7' OR $data['STOCK_CAT']=='8' OR $data['STOCK_CAT']=='17'){
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
		}elseif($data['STOCK_CAT']=='11'){
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
	
}