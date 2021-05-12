 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Early Finishes',
    'button'  => [
            'text' => $Lang->get('Early Finish'),
            'link' => $API->app_nav().'/staff/early-finishes/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

		
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Staff',
	    'link'  => $API->app_nav().'/staff/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Hours',
	    'link'  => $API->app_nav().'/staff/hours/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Holidays',
	    'link'  => $API->app_nav().'/staff/holidays/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Bank Holidays',
	    'link'  => $API->app_nav().'/staff/bank-holidays/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Early Finishes',
	    'link'  => $API->app_nav().'/staff/early-finishes/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Skills Matrix',
	    'link'  => $API->app_nav().'/staff/skills-matrix/',
	]);
	
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 

?>
	<table class="d">
        <thead>
            <tr>
                <th class="first">Date</th>
                <th>Value</th>
	            <th>Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($earlyfinishes as $EarlyFinish) {

?>
            <tr>
                <td><?php echo $EarlyFinish->date(); ?></td>
                <td><?php echo $EarlyFinish->targetHit(); ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/staff/early-finishes/delete/?id=<?php echo $HTML->encode(urlencode($EarlyFinish->natures_laboratory_staff_earlyfinishID())); ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php		

    echo $HTML->main_panel_end();