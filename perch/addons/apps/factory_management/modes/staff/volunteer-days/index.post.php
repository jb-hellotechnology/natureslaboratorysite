 <?php
    echo $HTML->side_panel_start();

    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => $details['name'].' - Volunteer Days',
    'button'  => [
            'text' => $Lang->get('Volunteer Day'),
            'link' => $API->app_nav().'/staff/volunteer-days/add?id='.$_GET['id'],
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
	    'active' => false,
	    'title' => 'Compassionate Leave',
	    'link'  => $API->app_nav().'/staff/compassionate-leave/?id='.$staffID,
	]);
	
	$Smartbar->add_item([
	    'active' => true,
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
    foreach($volunteerdays as $Day) {

?>
            <tr>
                <td><?php echo $Day['date']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/staff/volunteer-days/delete/?id=<?php echo $_GET['id']; ?>&volunteerID=<?php echo $HTML->encode(urlencode($Day['natures_laboratory_staff_volunteerdayID'])); ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
        </tbody>
	</table>

<?php 

    echo $HTML->main_panel_end();