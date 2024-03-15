 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA Oils',
    'button'  => [
            'text' => $Lang->get('COA'),
            'link' => $API->app_nav().'/coa-oils/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa-oils/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Spec',
	    'link'  => $API->app_nav().'/coa-oils/spec/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Countries',
	    'link'  => $API->app_nav().'/coa-oils/countries/',
	]);
	
	$Smartbar->add_item([
        'active' => false,
        'type'   => 'search',
        'data'   => [
            'search' => 'coa',
        ],
        'title'  => 'Search',
        'arg'    => 'q',
        'icon'   => 'core/search',
        'position' => 'end',
    ]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    echo $Form->form_start();
    ?>

    <table class="d">
        <thead>
            <tr>
	            <th class="first">Select</th>
                <th>Date Entered</th>
                <th>Our Batch</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>View/Edit</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($coa as $COA) {
	    
	    $specData = $NaturesLaboratoryCOASpec->byCode($COA['spec']);
?>
            <tr>
	            <td><?php echo $Form->radio("coa_".$COA['natures_laboratory_coa_oilsID'],'coa',$COA['natures_laboratory_coa_oilsID'],''); ?></td>
                <td><?php echo $COA['dateEntered'] ?></td>
                <td><?php echo $COA['ourBatch']; ?></td>
                <td><?php echo $specData['productCode']; ?></td>
                <td><?php echo $specData['commonName']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/coa-oils/edit/?id=<?php echo $HTML->encode(urlencode($COA['natures_laboratory_coa_oilsID'])); ?>" class="button button-small action-info"><?php echo 'View/Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/coa-oils/delete/?id=<?php echo $HTML->encode(urlencode($COA['natures_laboratory_coa_oilsID'])); ?>" class="button button-small action-alert"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    
	echo $Form->submit_field('btnSubmit', 'Generate Certificate', $API->app_path());	
	echo $Form->form_end();
    echo $HTML->main_panel_end();