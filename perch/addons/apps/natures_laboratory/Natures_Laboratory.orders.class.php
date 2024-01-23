<?php

class Natures_Laboratory_Orders extends PerchAPI_Factory
{
    protected $table     = 'natures_laboratory_orders';
	protected $pk        = 'natures_laboratory_orderID';
	protected $singular_classname = 'Natures_Laboratory_Order';
	
	protected $default_sort_column = 'natures_laboratory_orderID';
	
	public $static_fields = array('perch3_natures_laboratory_orderID', 'orderNumber', 'customer', 'orderDate', 'billing1', 'billing2', 'billing3', 'billing4', 'billing5', 'billing6', 'billing7', 'billing8', 'shipping1', 'shipping2', 'shipping3', 'shipping4', 'shipping5', 'shipping6', 'shipping7', 'shipping8', 'orderTotal', 'orderShipping', 'orderVat', 'orderGrandTotal', 'SKU', 'quantity', 'description', 'itemCost', 'lineCost', 'orderStatus', 'orderDynamicFields');	
	
	public function importOrders(){
		$dir = '../incoming/*';
		foreach(glob($dir) as $file) 
		{
			$csvFile = file('../incoming/'.$file);

		    foreach ($csvFile as $line) {
		        $data = str_getcsv($line);
		        $dateP = explode("/",$data['4']);
		        $date = "$dateP[2]-$dateP[1]-$dateP[0]";
				$sql = "INSERT INTO 
				perch3_natures_laboratory_orders 
				(orderNumber, customer, orderDate, billing1, billing2, billing3, billing4, billing5, billing6, billing7, billing8, shipping1, shipping2, shipping3, shipping4, shipping5, shipping6, shipping7, shipping8, orderTotal, orderShipping, orderVat, orderGrandTotal, SKU, quantity, description, itemCost, lineCost, orderStatus) 
				VALUES 
				('$data[2]', '$data[8]', '$date', '$data[1]', '$data[3]', '$data[5]', '$data[6]', '$data[7]', '$data[9]', '$data[10]', '$data[11]', '$data[36]', '$data[38]', '$data[40]', '$data[42]', '$data[44]', '$data[45]', '', '', '$data[37]', '$data[39]', '$data[41]', '$data[35]', '$data[13]', '$data[12]', '$data[14]', '$data[15]', '$data[16]', 'pending')";
				echo $sql;
				$this->db->execute($sql);
			}
			
			/** DELETE FILE**/
			unlink('../incoming/'.$file);
		}
	}
	
	public function getOrders($status){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_orders WHERE orderStatus="'.$status.'" ORDER BY orderNumber DESC';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
	public function getOrderDetails($order){
		
		$sql = 'SELECT * FROM perch3_natures_laboratory_orders WHERE orderNumber="'.$order.'"';
		$data = $this->db->get_rows($sql);
		return $data;
		
	}
	
}