 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'COA',
    'button'  => [
            'text' => $Lang->get('COA'),
            'link' => $API->app_nav().'/coa/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Spec',
	    'link'  => $API->app_nav().'/coa/spec/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Countries',
	    'link'  => $API->app_nav().'/coa/countries/',
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
                <th>Product Code</th> 
                <th>Product Name</th>
                <th>Our Batch</th>
                <th>View/Edit</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($coa as $COA) {
	    $stockItem = $NaturesLaboratoryGoodsIn->stockItem($COA['productCode']);
	    if($stockItem){
?>
            <tr>
	            <td><?php echo $Form->radio("coa_".$COA['natures_laboratory_coaID'],'coa',$COA['natures_laboratory_coaID'],''); ?></td>
                <td><?php echo $COA['dateEntered'] ?></td>
                <td><?php echo $COA['productCode']; ?></td>
                <td><?php echo $stockItem['DESCRIPTION']; ?></td>
                <td><?php echo $COA['ourBatch']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/coa/edit/?id=<?php echo $HTML->encode(urlencode($COA['natures_laboratory_coaID'])); ?>"><?php echo 'View/Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/coa/delete/?id=<?php echo $HTML->encode(urlencode($COA['natures_laboratory_coaID'])); ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
		}
	}
?>
	    </tbody>
    </table>

<?php    
	echo $Form->submit_field('btnSubmit', 'Generate Certificate', $API->app_path());	
	echo $Form->form_end();
    echo $HTML->main_panel_end();