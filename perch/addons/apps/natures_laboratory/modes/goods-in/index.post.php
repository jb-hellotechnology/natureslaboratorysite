 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Goods In',
    'button'  => [
            'text' => $Lang->get('Goods In'),
            'link' => $API->app_nav().'/goods-in/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Goods In',
	    'link'  => $API->app_nav().'/goods-in/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Stock',
	    'link'  => $API->app_nav().'/goods-in/stock/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Suppliers',
	    'link'  => $API->app_nav().'/goods-in/suppliers/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    ?>

    <table class="d">
        <thead>
            <tr>
                <th class="first">Staff</th>
                <th>Product Code</th> 
                <th>Product Description</th>  
                <th>Date In</th>
                <th>Supplier</th>
                <th>Quantity</th>
                <th>Supplier's Batch</th>
                <th>Our Batch</th>
                <th>BBE</th>
                <th>QA Check</th>
                <th>View/Edit</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($goodsIn as $Goods) {
?>
            <tr>
                <td><?php echo $Goods->staff(); ?></td>
                <td><?php echo $Goods->productCode(); ?></td>
                <td><?php echo $Goods->productDescription(); ?></td>
                <td><?php echo $Goods->dateIn(); ?></td>
                <td><?php echo $Goods->supplier(); ?></td>
                <td><?php echo $Goods->qty(); ?></td>
                <td><?php echo $Goods->suppliersBatch(); ?></td>
                <td><?php echo $Goods->ourBatch(); ?></td>
                <td><?php echo $Goods->bbe(); ?></td>
                <td><?php echo $Goods->qa(); ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/goods-in/edit/?id=<?php echo $HTML->encode(urlencode($Goods->natures_laboratory_goods_inID())); ?>"><?php echo 'View/Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/goods-in/delete/?id=<?php echo $HTML->encode(urlencode($Goods->natures_laboratory_goods_inID())); ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    

    echo $HTML->main_panel_end();