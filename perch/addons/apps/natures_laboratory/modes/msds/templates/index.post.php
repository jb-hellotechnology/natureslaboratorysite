 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'MSDS Templates'
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'MSDS',
	    'link'  => $API->app_nav().'/msds/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Templates',
	    'link'  => $API->app_nav().'/msds/templates/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    ?>

    <table class="d">
        <thead>
            <tr>
	            <th class="first">Product Type</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($msdsTemplates as $MSDSTemplate) {
?>
        <tr>
            <td><?php echo $MSDSTemplate['productType']; ?></td>
            <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/msds/templates/edit/?id=<?php echo $HTML->encode(urlencode($MSDSTemplate['natures_laboratory_msds_templateID'])); ?>"><?php echo 'Edit'; ?></a></td>
        </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    
    echo $HTML->main_panel_end();