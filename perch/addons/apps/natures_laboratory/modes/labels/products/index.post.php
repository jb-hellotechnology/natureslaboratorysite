 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Products',
    'button'  => [
            'text' => $Lang->get('Product'),
            'link' => $API->app_nav().'/labels/products/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Labels',
	    'link'  => $API->app_nav().'/labels/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Products',
	    'link'  => $API->app_nav().'/labels/products/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    ?>

    <table class="d">
        <thead>
            <tr>
	            <th class="first">Product Code</th>
                <th>Product Name</th>
                <th>Product Type</th>
                <th>Notes</th>   
                <th>Edit</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($products as $Product) {
?>
            <tr>
	            <td><?php echo $Product->productCode(); ?></td>
	            <td><?php echo $Product->productName(); ?></td>
	            <td><?php echo $Product->productType(); ?></td>
	            <td><?php echo $Product->notes(); ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/labels/products/edit/?id=<?php echo $HTML->encode(urlencode($Product->natures_laboratory_labels_productID())); ?>" class="button button-small action-info"><?php echo 'Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/labels/products/delete/?id=<?php echo $HTML->encode(urlencode($Product->natures_laboratory_labels_productID())); ?>" class="button button-small action-alert"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    
    echo $HTML->main_panel_end();