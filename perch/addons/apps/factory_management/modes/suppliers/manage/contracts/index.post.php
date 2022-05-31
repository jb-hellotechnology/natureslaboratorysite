<?php	

if(!$_GET['add']){
	echo $HTML->title_panel([
	'heading' => $SupplierData['NAME'],
	'button'  => [
	        'text' => $Lang->get('Contract'),
	        'link' => $API->app_nav().'/suppliers/manage/contracts/?id='.$_GET['id'].'&add=true',
	        'icon' => 'core/plus',
	    ],
	], $CurrentUser);
}else{
	echo $HTML->title_panel([
	'heading' => $SupplierData['NAME'],
	], $CurrentUser);	
}

$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => false,
    'title' => '&larr; Suppliers',
    'link'  => $API->app_nav().'/suppliers/',
]);

$Smartbar->add_item([
    'active' => false,
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
    'active' => true,
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

if($contracts AND (!$_GET['add'] AND !$_GET['edit'] AND !$_GET['delete'])){
	
?>

<table class="d">
    <thead>
        <tr>
            <th class="first">Product</th>
            <th>Quantity</th>
            <th>Received To Date</th>
            <th>Price/KG</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Edit</th>
            <th class="action last">Delete</th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach($contracts as $Contract) {
?>
	    <tr>
	        <td><?php echo $Contract->product(); ?></td>
	        <td><?php echo $Contract->quantity(); ?>KG</td>
	        <td>0KG</td>
	        <td>&pound;<?php echo $Contract->price(); ?></td>
	        <td><?php echo $Contract->startDate(); ?></td>
	        <td><?php echo $Contract->endDate(); ?></td>
	        <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/suppliers/manage/contracts/?id=<?= $_GET['id'] ?>&edit=true&contract=<?php echo $HTML->encode(urlencode($Contract->contractID())); ?>" class="button button-small"><?php echo 'Edit'; ?></a></td>
	        <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/suppliers/manage/contracts/?id=<?= $_GET['id'] ?>&delete=true&contract=<?php echo $HTML->encode(urlencode($Contract->contractID())); ?>" class="button button-small"><?php echo 'Delete'; ?></a></td>
	    </tr>
<?php
	}
?>
    </tbody>
</table>

<?php

}elseif($_GET['add']){
	
	if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo "<h2>Add a Contract</h2>";
		
		echo $Form->form_start();
		
		echo $Form->text_field("product","Product",'');
		
		echo $Form->text_field("quantity","Quantity",'');
		
		echo $Form->text_field("price","Price",'');
		
		echo $Form->date_field("startDate","Start Date",'');
		
		echo $Form->date_field("endDate","End Date",'');
		
		echo $Form->hidden("ACCOUNT_REF",$SupplierData['ACCOUNT_REF']);
		    
		echo $Form->submit_field('btnSubmit', 'Add Contract', $API->app_path());
		
		echo $Form->form_end();
	
	}

}elseif($_GET['contract'] AND $_GET['edit']){

	echo "<h2>Edit a Contract</h2>";
	
	if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		echo $Form->text_field("product","Product",$contract->product());
		
		echo $Form->text_field("quantity","Quantity",$contract->quantity());
		
		echo $Form->text_field("price","Price",$contract->price());
		
		echo $Form->date_field("startDate","Start Date",$contract->startDate());
		
		echo $Form->date_field("endDate","End Date",$contract->endDate());
		
		echo $Form->hidden("ACCOUNT_REF",$SupplierData['ACCOUNT_REF']);
		    
		echo $Form->submit_field('btnSubmit', 'Update Contract', $API->app_path());
		
		echo $Form->form_end();
	
	}
	

}elseif($_GET['contract'] AND $_GET['delete']){
	
	if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
	
		echo "<h2>Delete a Contract</h2>";
		
		echo $Form->form_start();
		    
		echo $Form->submit_field('btnSubmit', 'Delete Contract', $API->app_path());
		
		echo $Form->form_end();
		
	}
	
}else{
	echo $HTML->warning_message('Sorry, no contracts');	
}

echo $HTML->main_panel_end();

?>