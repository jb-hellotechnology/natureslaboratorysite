<?php	

echo $HTML->title_panel([
'heading' => $SupplierData['NAME']
], $CurrentUser);

$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => false,
    'title' => '&larr; Suppliers',
    'link'  => $API->app_nav().'/suppliers/',
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'Manage',
    'link'  => $API->app_nav().'/suppliers/manage/?id='.$SupplierData['SUPPLIERID'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'COA',
    'link'  => $API->app_nav().'/suppliers/manage/coa/?id='.$SupplierData['SUPPLIERID'],
]);

$Smartbar->add_item([
    'active' => true,
    'title' => 'PO',
    'link'  => $API->app_nav().'/suppliers/manage/po/?id='.$SupplierData['SUPPLIERID'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'Contracts',
    'link'  => $API->app_nav().'/suppliers/manage/contracts/?id='.$SupplierData['SUPPLIERID'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'Supplier Questionnaire',
    'link'  => $API->app_nav().'/suppliers/manage/questionnaire/?id='.$SupplierData['SUPPLIERID'],
]);

echo $Smartbar->render();

echo $HTML->main_panel_start();

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

echo $HTML->main_panel_end();

?>