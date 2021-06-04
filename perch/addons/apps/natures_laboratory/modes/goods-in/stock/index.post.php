 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Stock',
    'button'  => [
            'text' => $Lang->get('Stock'),
            'link' => $API->app_nav().'/goods-in/stock/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

		
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Goods In',
	    'link'  => $API->app_nav().'/goods-in/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
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
                <th class="first">Stock Code</th>
                <th>Description</th>
                <th>C1</th>
                <th>C2</th>
                <th>C3</th>
                <th>C4</th>
                <th>C5</th>
                <th>C6</th>
                <th>Q1</th>
                <th>Q2</th>
                <th>Q3</th>
                <th>Q4</th>
                <th>Q5</th>
                <th>Q6</th>
                <th>View/Edit</th>
	            <th>Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($stock as $Stock) {

?>
            <tr>
                <td><?php echo $Stock->stockCode(); ?></td>
                <td><?php echo $Stock->description(); ?></td>
                <td><?php echo $Stock->component1(); ?></td>
                <td><?php echo $Stock->component2(); ?></td>
                <td><?php echo $Stock->component3(); ?></td>
                <td><?php echo $Stock->component4(); ?></td>
                <td><?php echo $Stock->component5(); ?></td>
                <td><?php echo $Stock->component6(); ?></td>
                <td><?php echo $Stock->qty1(); ?></td>
                <td><?php echo $Stock->qty2(); ?></td>
                <td><?php echo $Stock->qty3(); ?></td>
                <td><?php echo $Stock->qty4(); ?></td>
                <td><?php echo $Stock->qty5(); ?></td>
                <td><?php echo $Stock->qty6(); ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/goods-in/stock/edit/?id=<?php echo $HTML->encode(urlencode($Stock->natures_laboratory_goods_stockID())); ?>" class="delete inline-delete"><?php echo 'View/Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/goods-in/stock/delete/?id=<?php echo $HTML->encode(urlencode($Stock->natures_laboratory_goods_stockID())); ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php		

    echo $HTML->main_panel_end();