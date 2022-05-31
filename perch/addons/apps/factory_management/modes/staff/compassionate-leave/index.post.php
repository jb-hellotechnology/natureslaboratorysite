 <?php
    echo $HTML->side_panel_start();

    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $details['name'].' - Compassionate Leave',
    'button'  => [
            'text' => $Lang->get('Compassionate Leave'),
            'link' => $API->app_nav().'/staff/compassionate-leave/add?id='.$_GET['id'],
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Profile',
	    'link'  => $API->app_nav().'/staff/edit/?id='.$staffID,
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Hours',
	    'link'  => $API->app_nav().'/staff/hours/?id='.$staffID,
	]);
	
	$Smartbar->add_item([
    'active' => false,
    'title' => 'Holidays',
    'link'  => $API->app_nav().'/staff/holidays/?id='.$staffID,
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Sick Days',
	    'link'  => $API->app_nav().'/staff/sick-days/?id='.$staffID,
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Compassionate Leave',
	    'link'  => $API->app_nav().'/staff/compassionate-leave/?id='.$staffID,
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Volunteer Days',
	    'link'  => $API->app_nav().'/staff/volunteer-days/?id='.$staffID,
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    ?>

	<table class="d">
        <thead>
            <tr>
                <th>Date</th> 
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($compassionatedays as $Day) {

?>
            <tr>
                <td><?php echo $Day['date']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/staff/compassionate-leave/delete/?id=<?php echo $_GET['id']; ?>&compassionateID=<?php echo $HTML->encode(urlencode($Day['natures_laboratory_staff_compassionatedayID'])); ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
        </tbody>
	</table>

<?php 

    echo $HTML->main_panel_end();