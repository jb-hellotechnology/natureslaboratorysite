 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA Products',
    'button'  => [
            'text' => $Lang->get('Spec'),
            'link' => $API->app_nav().'/coa-products/spec/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa-products/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Spec',
	    'link'  => $API->app_nav().'/coa-products/spec/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Countries',
	    'link'  => $API->app_nav().'/coa-products/countries/',
	]);
	
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    echo $Form->form_start();

?>
	<table class="d">
        <thead>
            <tr>
	            <th class="first">Select</th>
                <th>Product Code</th>
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
	            <td><?php echo $Form->radio("spec_".$Spec->natures_laboratory_coa_products_specID(),'spec',$Spec->natures_laboratory_coa_products_specID(),''); ?></td>
                <td><?php echo $Spec->productCode(); ?></td>
                <td><?php echo $Spec->commonName(); ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/coa-products/spec/edit/?id=<?php echo $HTML->encode(urlencode($Spec->natures_laboratory_coa_products_specID())); ?>" class="button button-small action-info"><?php echo 'View/Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/coa-products/spec/delete/?id=<?php echo $HTML->encode(urlencode($Spec->natures_laboratory_coa_products_specID())); ?>" class="button button-small action-alert"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php		
  
	echo $Form->submit_field('btnSubmit', 'Generate Spec', $API->app_path());	
	echo $Form->form_end();
    echo $HTML->main_panel_end();