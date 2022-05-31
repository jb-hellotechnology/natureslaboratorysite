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
    'active' => true,
    'title' => 'Manage',
    'link'  => $API->app_nav().'/suppliers/manage/?id='.$_GET['id'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'COA',
    'link'  => $API->app_nav().'/suppliers/manage/coa/?id='.$_GET['id'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'PO',
    'link'  => $API->app_nav().'/suppliers/manage/po/?id='.$_GET['id'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'Contracts',
    'link'  => $API->app_nav().'/suppliers/manage/contracts/?id='.$_GET['id'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'Supplier Questionnaire',
    'link'  => $API->app_nav().'/suppliers/manage/questionnaire/?id='.$_GET['id'],
]);

echo $Smartbar->render();

echo $HTML->main_panel_start();
	
?>

<table class="d">
    <thead>
        <tr>
            <th class="first">Key</th>
            <th>Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Name</td><td><?php echo $SupplierData['NAME'] ?></td>
        </tr>
        <tr>
            <td>Reference</td><td><?php echo $SupplierData['ACCOUNT_REF'] ?></td>
        </tr>
        <tr>
            <td>Phone</td><td><?php echo $SupplierData['TELEPHONE'] ?></td>
        </tr>
        <tr>
            <td>Address</td><td><?php echo $SupplierData['ADDRESS_1'] ?>, <?php echo $SupplierData['ADDRESS_2'] ?>, <?php echo $SupplierData['ADDRESS_3'] ?>, <?php echo $SupplierData['ADDRESS_4'] ?>, <?php echo $SupplierData['ADDRESS_5'] ?></td>
        </tr>
	</tbody>
</table>

<h2>Manage</h2>

<?php
	
if (isset($message)){ 
    
    echo $message;
    
}else{
	
	echo $Form->form_start();
	
	$details = json_decode($details['supplierDynamicFields'],true);

	$details['notes'] = $details['notes']['processed'];
	echo $Form->fields_from_template($Template, $details, $FactoryManagementSuppliersData->static_fields);
	
	echo $Form->hidden("ACCOUNT_REF",$SupplierData['ACCOUNT_REF']);
	    
	echo $Form->submit_field('btnSubmit', 'Update', $API->app_path());
	
	echo $Form->form_end();

}

echo $HTML->main_panel_end();

?>