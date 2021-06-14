 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA',
    'button'  => [
            'text' => $Lang->get('Spec'),
            'link' => $API->app_nav().'/coa/spec/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Spec',
	    'link'  => $API->app_nav().'/coa/spec/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Countries',
	    'link'  => $API->app_nav().'/coa/countries/',
	]);
	
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 

?>
	<table class="d">
        <thead>
            <tr>
                <th class="first">Product Code</th>
				<th>Common Name</th>
                <th>View/Edit</th>
	            <th>Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($spec as $Spec) {

?>
            <tr>
                <td><?php echo $Spec->productCode(); ?></td>
                <td><?php echo $Spec->commonName(); ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/coa/spec/edit/?id=<?php echo $HTML->encode(urlencode($Spec->natures_laboratory_coa_specID())); ?>" class="delete inline-delete"><?php echo 'View/Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/coa/spec/delete/?id=<?php echo $HTML->encode(urlencode($Spec->natures_laboratory_coa_specID())); ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php		

    echo $HTML->main_panel_end();