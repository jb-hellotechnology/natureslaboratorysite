 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Production',
    'button'  => [
            'text' => $Lang->get('Production'),
            'link' => $API->app_nav().'/production/?add=true',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Shortfall',
	    'link'  => $API->app_nav().'/production/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
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
    
    if($_GET['add']){
	    
	    echo '<form method="get" action="/perch/addons/apps/natures_laboratory/production/schedule/" enctype="multipart/form-data" id="" class="app form-simple">';
	    
	    $products = $NaturesLaboratoryProduction->getProducts();
	    foreach($products as $Product){
    		$productsList[] = array('label'=>"$Product[STOCK_CODE] | $Product[DESCRIPTION]", 'value'=>$Product['STOCK_CODE']);
    	}
		echo $Form->select_field("id","Product",$productsList,'');
	    echo $Form->submit_field('btnSubmit', 'Go', $API->app_path());
	    
	    echo $Form->form_end();
	    
    }else{

    ?>
    
    <h2>Chemicals</h2>

	<table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>Description</th>
                <th>Stock Level</th>
                <th>Re-Order Level</th> 
                <th class="action last">Schedule</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($chemicals as $Product) {
	    if($NaturesLaboratoryProduction->notInProduction($Product['STOCK_CODE'])){
?>
            <tr>
	            <td><?php echo $Product['STOCK_CODE']; ?>
                <td><?php echo $Product['DESCRIPTION'] ?></td>
                <td><?php echo $Product['QTY_IN_STOCK']; ?></td>
                <td><?php echo $Product['QTY_REORDER_LEVEL']; ?></td>
                <td><a class="button button-small action-success" href="<?php echo $HTML->encode($API->app_path()); ?>/production/schedule/?id=<?php echo $HTML->encode(urlencode($Product['STOCK_CODE'])); ?>"><?php echo 'Schedule'; ?></a></td>
            </tr>
<?php
		}
	}
?>
	    </tbody>
    </table>
    
    <h2>Tinctures</h2>

	<table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>Description</th>
                <th>Stock Level</th>
                <th>Re-Order Level</th> 
                <th class="action last">Schedule</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($tinctures as $Product) {
	    if($NaturesLaboratoryProduction->notInProduction($Product['STOCK_CODE'])){
?>
            <tr>
	            <td><?php echo $Product['STOCK_CODE']; ?>
                <td><?php echo $Product['DESCRIPTION'] ?></td>
                <td><?php echo $Product['QTY_IN_STOCK']; ?></td>
                <td><?php echo $Product['QTY_REORDER_LEVEL']; ?></td>
                <td><a class="button button-small action-success" href="<?php echo $HTML->encode($API->app_path()); ?>/production/schedule/?id=<?php echo $HTML->encode(urlencode($Product['STOCK_CODE'])); ?>"><?php echo 'Schedule'; ?></a></td>
            </tr>
<?php
		}
	}
?>
	    </tbody>
    </table>
    
    <h2>Fluid Extracts</h2>

	<table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>Description</th>
                <th>Stock Level</th>
                <th>Re-Order Level</th> 
                <th class="action last">Schedule</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($fluids as $Product) {
	    if($NaturesLaboratoryProduction->notInProduction($Product['STOCK_CODE'])){
?>
            <tr>
	            <td><?php echo $Product['STOCK_CODE']; ?>
                <td><?php echo $Product['DESCRIPTION'] ?></td>
                <td><?php echo $Product['QTY_IN_STOCK']; ?></td>
                <td><?php echo $Product['QTY_REORDER_LEVEL']; ?></td>
                <td><a class="button button-small action-success" href="<?php echo $HTML->encode($API->app_path()); ?>/production/schedule/?id=<?php echo $HTML->encode(urlencode($Product['STOCK_CODE'])); ?>"><?php echo 'Schedule'; ?></a></td>
            </tr>
<?php
		}
	}
?>
	    </tbody>
    </table>
    
    <h2>Capsules</h2>

	<table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>Description</th>
                <th>Stock Level</th>
                <th>Re-Order Level</th> 
                <th class="action last">Schedule</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($capsules as $Product) {
	    if($NaturesLaboratoryProduction->notInProduction($Product['STOCK_CODE'])){
?>
            <tr>
	            <td><?php echo $Product['STOCK_CODE']; ?>
                <td><?php echo $Product['DESCRIPTION'] ?></td>
                <td><?php echo $Product['QTY_IN_STOCK']; ?></td>
                <td><?php echo $Product['QTY_REORDER_LEVEL']; ?></td>
                <td><a class="button button-small action-success" href="<?php echo $HTML->encode($API->app_path()); ?>/production/schedule/?id=<?php echo $HTML->encode(urlencode($Product['STOCK_CODE'])); ?>"><?php echo 'Schedule'; ?></a></td>
            </tr>
<?php
		}
	}
?>
	    </tbody>
    </table>
    
    <h2>Creams</h2>

	<table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>Description</th>
                <th>Stock Level</th>
                <th>Re-Order Level</th> 
                <th class="action last">Schedule</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($creams as $Product) {
	    if($NaturesLaboratoryProduction->notInProduction($Product['STOCK_CODE'])){
?>
            <tr>
	            <td><?php echo $Product['STOCK_CODE']; ?>
                <td><?php echo $Product['DESCRIPTION'] ?></td>
                <td><?php echo $Product['QTY_IN_STOCK']; ?></td>
                <td><?php echo $Product['QTY_REORDER_LEVEL']; ?></td>
                <td><a class="button button-small action-success" href="<?php echo $HTML->encode($API->app_path()); ?>/production/schedule/?id=<?php echo $HTML->encode(urlencode($Product['STOCK_CODE'])); ?>"><?php echo 'Schedule'; ?></a></td>
            </tr>
<?php
		}
	}
?>
	    </tbody>
    </table>
    
    <h2>Essential Oils</h2>

	<table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>Description</th>
                <th>Stock Level</th>
                <th>Re-Order Level</th> 
                <th class="action last">Schedule</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($essentialOils as $Product) {
	    if($NaturesLaboratoryProduction->notInProduction($Product['STOCK_CODE'])){
?>
            <tr>
	            <td><?php echo $Product['STOCK_CODE']; ?>
                <td><?php echo $Product['DESCRIPTION'] ?></td>
                <td><?php echo $Product['QTY_IN_STOCK']; ?></td>
                <td><?php echo $Product['QTY_REORDER_LEVEL']; ?></td>
                <td><a class="button button-small action-success" href="<?php echo $HTML->encode($API->app_path()); ?>/production/schedule/?id=<?php echo $HTML->encode(urlencode($Product['STOCK_CODE'])); ?>"><?php echo 'Schedule'; ?></a></td>
            </tr>
<?php
		}
	}
?>
	    </tbody>
    </table>
    
    <h2>Fixed Oils</h2>

	<table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>Description</th>
                <th>Stock Level</th>
                <th>Re-Order Level</th> 
                <th class="action last">Schedule</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($fixedOils as $Product) {
	    if($NaturesLaboratoryProduction->notInProduction($Product['STOCK_CODE'])){
?>
            <tr>
	            <td><?php echo $Product['STOCK_CODE']; ?>
                <td><?php echo $Product['DESCRIPTION'] ?></td>
                <td><?php echo $Product['QTY_IN_STOCK']; ?></td>
                <td><?php echo $Product['QTY_REORDER_LEVEL']; ?></td>
                <td><a class="button button-small action-success" href="<?php echo $HTML->encode($API->app_path()); ?>/production/schedule/?id=<?php echo $HTML->encode(urlencode($Product['STOCK_CODE'])); ?>"><?php echo 'Schedule'; ?></a></td>
            </tr>
<?php
		}
	}
?>
	    </tbody>
    </table>
    
    <h2>Sweet Cecily's</h2>

	<table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>Description</th>
                <th>Stock Level</th>
                <th>Re-Order Level</th> 
                <th class="action last">Schedule</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($sweetCecilys as $Product) {
	    if($NaturesLaboratoryProduction->notInProduction($Product['STOCK_CODE'])){
?>
            <tr>
	            <td><?php echo $Product['STOCK_CODE']; ?>
                <td><?php echo $Product['DESCRIPTION'] ?></td>
                <td><?php echo $Product['QTY_IN_STOCK']; ?></td>
                <td><?php echo $Product['QTY_REORDER_LEVEL']; ?></td>
                <td><a class="button button-small action-success" href="<?php echo $HTML->encode($API->app_path()); ?>/production/schedule/?id=<?php echo $HTML->encode(urlencode($Product['STOCK_CODE'])); ?>"><?php echo 'Schedule'; ?></a></td>
            </tr>
<?php
		}
	}
?>
	    </tbody>
    </table>
    
    <h2>Contract</h2>

	<table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>Description</th>
                <th>Stock Level</th>
                <th>Re-Order Level</th> 
                <th class="action last">Schedule</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($contract as $Product) {
	    if($NaturesLaboratoryProduction->notInProduction($Product['STOCK_CODE'])){
?>
            <tr>
	            <td><?php echo $Product['STOCK_CODE']; ?>
                <td><?php echo $Product['DESCRIPTION'] ?></td>
                <td><?php echo $Product['QTY_IN_STOCK']; ?></td>
                <td><?php echo $Product['QTY_REORDER_LEVEL']; ?></td>
                <td><a class="button button-small action-success" href="<?php echo $HTML->encode($API->app_path()); ?>/production/schedule/?id=<?php echo $HTML->encode(urlencode($Product['STOCK_CODE'])); ?>"><?php echo 'Schedule'; ?></a></td>
            </tr>
<?php
		}
	}
?>
	    </tbody>
    </table>

<?php
	}