 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Production',
    'button'  => [
            'text' => $Lang->get('Production'),
            'link' => $API->app_nav().'/production/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Shortfall',
	    'link'  => $API->app_nav().'/production/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Scheduled',
	    'link'  => $API->app_nav().'/production/scheduled/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'In Production',
	    'link'  => $API->app_nav().'/production/in-production/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Completed',
	    'link'  => $API->app_nav().'/production/completed/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if($_GET['id']){
	    
	    $scheduled = $NaturesLaboratoryProduction->getProcess($_GET['id']);
		$product = $NaturesLaboratoryProduction->getProduct($scheduled['sku']);
		
		echo $Form->form_start();
		
		echo "<h2>$product[STOCK_CODE] | $product[DESCRIPTION]</h2>";
		
		echo '<table class="d">
        <tbody>
        <tr>
        	<td>Specification</td>
        	<td>'.$scheduled['specification'].'</td>
        </tr>
        <tr>
        	<td>Packaging Requirements</td>
        	<td>'.$scheduled['packaging'].'</td>
        </tr>
        <tr>
        	<td>Labelling Requirements</td>
        	<td>'.$scheduled['labelling'].'</td>
        </tr>
        <tr>
        	<td>Quantity Required</td>
        	<td>'.$scheduled['units'].'</td>
        </tr>
        </tbody>
        </table>';
		
		echo $Form->submit_field('btnSubmit', 'Produce', $API->app_path());
		
		echo $Form->form_end();
	    
	}else{

	?>
	
	<table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>Description</th>
                <th>Units</th>
                <th class="action last">Produce</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($scheduled as $Scheduled) {
	    $stock = $NaturesLaboratoryProduction->getProduct($Scheduled['sku']);
?>
            <tr>
	            <td><?php echo $Scheduled['sku']; ?>
                <td><?php echo $stock['DESCRIPTION'] ?></td>
                <td><?php echo $Scheduled['units']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/production/scheduled/?id=<?php echo $HTML->encode(urlencode($Scheduled['natures_laboratory_productionID'])); ?>" class="delete inline-delete"><?php echo 'Go'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php
	}
	