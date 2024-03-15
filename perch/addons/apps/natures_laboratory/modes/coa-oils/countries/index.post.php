 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Countries',
    'button'  => [
            'text' => $Lang->get('Country'),
            'link' => $API->app_nav().'/coa-oils/countries/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

		
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'COA',
	    'link'  => $API->app_nav().'/coa-oils/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Spec',
	    'link'  => $API->app_nav().'/coa-oils/spec/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Countries',
	    'link'  => $API->app_nav().'/coa-oils/countries/',
	]);
	
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 

?>
	<table class="d">
        <thead>
            <tr>
                <th class="first">Country</th>
                <th>View/Edit</th>
	            <th>Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($countries as $Country) {

?>
            <tr>
                <td><?php echo $Country->country(); ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/coa-oils/countries/edit/?id=<?php echo $HTML->encode(urlencode($Country->natures_laboratory_coa_oils_countryID())); ?>" class="button button-small action-info"><?php echo 'View/Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/coa-oils/countries/delete/?id=<?php echo $HTML->encode(urlencode($Country->natures_laboratory_coa_oils_countryID())); ?>" class="button button-small action-alert"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php		

    echo $HTML->main_panel_end();