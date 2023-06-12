 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Suppliers',
    'button'  => [
            'text' => $Lang->get('Supplier'),
            'link' => $API->app_nav().'/goods-in/suppliers/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

		
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Goods In',
	    'link'  => $API->app_nav().'/goods-in/',
	]);
	
/*
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Stock',
	    'link'  => $API->app_nav().'/goods-in/stock/',
	]);
*/
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Suppliers',
	    'link'  => $API->app_nav().'/goods-in/suppliers/',
	]);
	
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 

?>
	<table class="d">
        <thead>
            <tr>
                <th class="first">Name</th>
                <th>Edit</th>
	            <th>Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($suppliers as $Supplier) {

?>
            <tr>
                <td><?php echo $Supplier->name(); ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/goods-in/suppliers/edit/?id=<?php echo $HTML->encode(urlencode($Supplier->natures_laboratory_goods_suppliersID())); ?>" class="button button-small action-info"><?php echo 'Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/goods-in/suppliers/delete/?id=<?php echo $HTML->encode(urlencode($Supplier->natures_laboratory_goods_suppliersID())); ?>" class="button button-small action-alert"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php		

    echo $HTML->main_panel_end();