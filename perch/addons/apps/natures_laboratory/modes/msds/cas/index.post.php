 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'MSDS > CAS',
    'button'  => [
            'text' => $Lang->get('CAS'),
            'link' => $API->app_nav().'/msds/cas/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'MSDS',
	    'link'  => $API->app_nav().'/msds/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Templates',
	    'link'  => $API->app_nav().'/msds/templates/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'CAS',
	    'link'  => $API->app_nav().'/msds/cas/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    ?>

    <table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>CAS</th>
                <th>Edit</th>
                <th class="last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($products as $Product) {
?>
        <tr>
            <td><?php echo $Product['STOCK_CODE']; ?></td>
            <td><?php echo $Product['CAS']; ?></td>
            <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/msds/cas/edit/?id=<?php echo $HTML->encode(urlencode($Product['casID'])); ?>" class="button button-small action-info"><?php echo 'Edit'; ?></a></td>
            <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/msds/cas/delete/?id=<?php echo $HTML->encode(urlencode($Product['casID'])); ?>" class="button button-small action-alert"><?php echo 'Delete'; ?></a></td>
        </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    
    echo $HTML->main_panel_end();