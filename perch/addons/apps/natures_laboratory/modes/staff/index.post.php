 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Staff',
    'button'  => [
            'text' => $Lang->get('Staff'),
            'link' => $API->app_nav().'/staff/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
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
	    'title' => 'Sick Pay',
	    'link'  => $API->app_nav().'/staff/sick/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Volunteer Days',
	    'link'  => $API->app_nav().'/staff/volunteer/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Skills Matrix',
	    'link'  => $API->app_nav().'/staff/skills/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    ?>

    <table class="d">
        <thead>
            <tr>
                <th class="first">Name</th>
                <th>Email</th> 
                <th>Phone</th>  
                <th>Address</th>
                <th>Start Date</th>
                <th>View/Edit</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($staff as $Staff) {
?>
            <tr>
                <td><?php echo $Staff->name(); ?></td>
                <td><?php echo $Staff->email(); ?></td>
                <td><?php echo $Staff->phone(); ?></td>
                <td><?php echo $Staff->address(); ?></td>
                <td><?php echo $Staff->startDate(); ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/staff/edit/?id=<?php echo $HTML->encode(urlencode($Staff->natures_laboratory_staffID())); ?>"><?php echo 'View/Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/staff/delete/?id=<?php echo $HTML->encode(urlencode($Staff->natures_laboratory_staffID())); ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    

    echo $HTML->main_panel_end();