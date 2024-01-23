 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Orders',
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Pending',
	    'link'  => $API->app_nav().'/orders/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Dispatched',
	    'link'  => $API->app_nav().'/orders/dispatched/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    ?>

    <table class="d">
        <thead>
            <tr>
	            <th class="first">#</th>
                <th>Customer</th>
                <th>Shipping</th> 
                <th>SKU</th>  
                <th class="last">Qty</th>
            </tr>
        </thead>
        <tbody>
<?php
	$orderNumber = "";
    foreach($orders as $Order) {
	    if($orderNumber<>$Order['orderNumber']){
		    $show = true;
		    $orderNumber = $Order['orderNumber'];
	    }else{
		    $show = false;
	    }
?>
            <tr>
	            <td><?php if($show){echo $Order['orderNumber'];} ?></td>
                <td><?php if($show){echo $Order['customer'];} ?></td>
                <td><?php if($show){echo "$Order[shipping1]<br />$Order[shipping2]<br />$Order[shipping3]<br />$Order[shipping4]<br />$Order[shipping5]<br />$Order[shipping6]";} ?></td>
                <td valign="bottom"><?php echo $Order['SKU']; ?></td>
                <td valign="bottom"><?php echo $Order['quantity']; ?></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    
    echo $HTML->main_panel_end();