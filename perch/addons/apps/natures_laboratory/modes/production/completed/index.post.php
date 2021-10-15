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
	    'title' => 'Processes',
	    'link'  => $API->app_nav().'/production/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Completed',
	    'link'  => $API->app_nav().'/production/completed/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();

    ?>

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