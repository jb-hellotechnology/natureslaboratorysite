<?php	

echo $HTML->title_panel([
'heading' => 'Goods In'
], $CurrentUser);

$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => true,
    'title' => 'Goods In',
    'link'  => $API->app_nav().'/goods-in/',
]);

echo $Smartbar->render();

echo $HTML->main_panel_start();

if(count($pos)>0){
	
	$Listing = new PerchAdminListing($CurrentUser, $HTML, $Lang, $Paging);
	
	$Listing->add_col([
	    'title' => 'PO',
	    'value' => 'ORDER_NUMBER',
	    'edit_link' => 'manage',
	]);
	
	$Listing->add_col([
	    'title' => 'Supplier',
	    'value' => 'NAME'
	]);
	
	$Listing->add_col([
	    'title' => 'Date',
	    'value' => 'ORDER_DATE'  
	]);
	
	$Listing->add_col([
	    'title' => 'Order Status',
	    'value' => 'ORDER_STATUS'  
	]);
	
	$Listing->add_col([
	    'title' => 'Delivery Status',
	    'value' => 'DELIVERY_STATUS'  
	]);
	
	$Listing->add_col([
	    'title' => 'Order Items', 
	]);
	
	$Listing->add_col([
	    'title' => 'QTY', 
	]);
	
	$Listing->add_col([
	    'title' => 'Supplier\'s Batch', 
	]);
	
	$Listing->add_col([
	    'title' => 'Our Batch', 
	]);
	
	$Listing->add_col([
	    'title' => 'BBE', 
	]);
	
	$Listing->add_col([
	    'title' => 'Country Of Origin', 
	]);
	
	$Listing->add_col([
	    'title' => 'QA', 
	]);
	
	$Listing->add_col([
	    'title' => 'COA', 
	]);
	
	echo $Listing->render($pos);
	

}elseif($_GET['po']){

?>	

<h2>Purchase Order</h2>

<table class="d">
    <thead>
        <tr>
            <th class="first">Key</th>
            <th class="last">Value</th>
        </tr>
    </thead>
    <tbody>
	    <tr>
		    <td>Order Number</td><td><?php echo $po['ORDER_NUMBER']; ?></td>
	    </tr>
	    <tr>
		    <td>Order Date</td><td><?php echo $po['ORDER_DATE']; ?></td>
	    </tr>
	    <tr>
		    <td>Delivery Date</td><td><?php echo $po['DELIVERY_DATE']; ?></td>
		</tr>
		<tr>
		    <td>Order Status</td><td><?php echo $po['ORDER_STATUS']; ?></td>
		</tr>
		<tr>
		    <td>Delivery Status</td><td><?php echo $po['DELIVERY_STATUS']; ?></td>
		</tr>
		<tr>
		    <td>Taken By</td><td><?php echo $po['TAKEN_BY']; ?></td>
		</tr>
		<tr>
		    <td>Gross Value</td><td>&pound;<?php echo $po['ITEMS_GROSS']; ?></td>
		</tr>
    </tbody>
</table>

<h2>Items</h2>

<table class="d">
    <thead>
        <tr>
            <th class="first">Description</th>
            <th>SKU</th>
            <th>QTY Ordered</th>
            <th class="last">QTY Delivered</th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach($posItems as $POITEM) {
?>
	    <tr>
	        <td><?php echo $POITEM['DESCRIPTION'] ?></td>
	        <td><?php echo $POITEM['STOCK_CODE'] ?></td>
	        <td><?php echo $POITEM['QTY_ORDER']; ?></td>
	        <td><?php echo $POITEM['QTY_DELIVERED']; ?></td>
	    </tr>
<?php
	}
?>
    </tbody>
</table>

<h2>Notes &amp; Files</h2>

<?php	
	
	if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		$details = json_decode($details['poDynamicFields'],true);
	
		$details['notes'] = $details['notes']['processed'];
		echo $Form->fields_from_template($Template, $details, $FactoryManagementSuppliersData->static_fields);
		    
		echo $Form->submit_field('btnSubmit', 'Update', $API->app_path());
		
		echo $Form->form_end();
	
	}
	
}else{
	echo $HTML->warning_message('Sorry, no purchase orders');	
}

echo $HTML->main_panel_end();

?>

<script>
$(document).ready(function(){
	$('.primary').each(function() { 
		
		var orderID = $(this).text();
		$(this).parent().parent().find('td[data-label="Order Items"]').html('Loading...').addClass('order_' + orderID + '_items');
		$(this).parent().parent().find('td[data-label="QTY"]').html('Loading...').addClass('order_' + orderID + '_qty');
		$(this).parent().parent().find('td[data-label="Supplier\'s Batch"]').html('Loading...').addClass('order_' + orderID + '_suppliersbatch');
		$(this).parent().parent().find('td[data-label="Our Batch"]').html('Loading...').addClass('order_' + orderID + '_ourbatch');
		$(this).parent().parent().find('td[data-label="BBE"]').html('Loading...').addClass('order_' + orderID + '_bbe');
		$(this).parent().parent().find('td[data-label="Country Of Origin"]').html('Loading...').addClass('order_' + orderID + '_country');
		$(this).parent().parent().find('td[data-label="QA"]').html('Loading...').addClass('order_' + orderID + '_qa');
		$(this).parent().parent().find('td[data-label="COA"]').html('Loading...').addClass('order_' + orderID + '_coa');
		
		$.post( "getOrder.php", { ORDER_NUMBER: orderID }).done(function( data ) {
			var obj = jQuery.parseJSON(data);
		    $('.order_' + orderID + '_items').html(obj.items);
			$('.order_' + orderID + '_qty').html(obj.qty);
			$('.order_' + orderID + '_suppliersbatch').html(obj.suppliers);
			$('.order_' + orderID + '_ourbatch').html(obj.ourbatch);
			$('.order_' + orderID + '_bbe').html(obj.bbe);
			$('.order_' + orderID + '_country').html(obj.country);
			$('.order_' + orderID + '_qa').html(obj.qa);
			$('.order_' + orderID + '_coa').html(obj.coa);
		});

	});	
});
</script>