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
    
    print_r($shortfall);

    ?>

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
    foreach($shortfall as $Shortfall) {
?>
            <tr>
	            <td><?php echo $Shortfall['STOCK_CODE']; ?>
                <td><?php echo $Shortfall['DESCRIPTION'] ?></td>
                <td><?php echo $Shortfall['QTY_IN_STOCK']; ?></td>
                <td><?php echo $Shortfall['QTY_REORDER_LEVEL']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/production/schedule/?id=<?php echo $HTML->encode(urlencode($Shortfall['STOCK_CODE'])); ?>" class="delete inline-delete"><?php echo 'Go'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>


<!--
    <table class="d">
        <thead>
            <tr>
	            <th class="first">Vessel</th>
	            <th>Batch</th>
                <th>Start Time</th>
                <th>Description</th> 
                <th>Status</th>  
                <th>Flow</th>
                <th>Programme</th>
                <th class="action last">Edit</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($processes as $Process) {
?>
            <tr>
	            <td><?php echo $Process['vessel']; ?>
                <td><?php echo $Process['batch'] ?></td>
                <td><?php echo $Process['startTime']; ?></td>
                <td><?php echo $Process['description']; ?></td>
                <td><?php echo $Process['status']; ?></td>
                <td><?php echo $Process['flow']; ?></td>
                <td><?php echo $Process['programme']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/production/edit/?id=<?php echo $HTML->encode(urlencode($Process['natures_laboratory_productionID'])); ?>" class="delete inline-delete"><?php echo 'Edit'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>
-->