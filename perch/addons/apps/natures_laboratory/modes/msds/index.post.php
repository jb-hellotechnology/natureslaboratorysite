 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'MSDS',
    'button'  => [
            'text' => $Lang->get('MSDS'),
            'link' => $API->app_nav().'/msds/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'MSDS',
	    'link'  => $API->app_nav().'/msds/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Templates',
	    'link'  => $API->app_nav().'/msds/templates/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'CAS',
	    'link'  => $API->app_nav().'/msds/cas/',
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
                <th>MSDS Template</th>
                <th>Product Name</th>
                <th>View/Edit</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($msds as $MSDS) {
	    $stockItem = $NaturesLaboratoryGoodsIn->stockItem($MSDS['productCode']);
	    $msdsTemplate = $NaturesLaboratoryMSDSTemplate->getMSDSTemplate($MSDS['productType']);
	    if($stockItem){
?>
            <tr>
	            <td><?php echo $Form->radio("msds_".$MSDS['natures_laboratory_msdsID'],'msds',$MSDS['natures_laboratory_msdsID'],''); ?></td>
                <td><?php echo $MSDS['productCode']; ?></td>
                <td><?php echo $msdsTemplate['productType']; ?></td>
                <td><?php echo $stockItem['DESCRIPTION']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/msds/edit/?id=<?php echo $HTML->encode(urlencode($MSDS['natures_laboratory_msdsID'])); ?>" class="button button-small action-info"><?php echo 'View/Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/msds/delete/?id=<?php echo $HTML->encode(urlencode($MSDS['natures_laboratory_msdsID'])); ?>" class="button button-small action-alert"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
		}
	}
?>
	    </tbody>
    </table>

<?php    
	echo $Form->submit_field('btnSubmit', 'Generate MSDS', $API->app_path());	
	echo $Form->form_end();
    echo $HTML->main_panel_end();