 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Tasks',
    'button'  => [
            'text' => $Lang->get('Task'),
            'link' => $API->app_nav().'/tasks/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Tasks',
	    'link'  => $API->app_nav().'/tasks/',
	]);
	
	$Smartbar->add_item([
        'active' => false,
        'type'   => 'search',
        'data'   => [
            'search' => 'task',
        ],
        'title'  => 'Search',
        'arg'    => 'q',
        'icon'   => 'core/search',
        'position' => 'end',
    ]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    ?>

    <table class="d">
        <thead>
            <tr>
                <th class="first">Date</th>
                <th>Title</th> 
                <th>Created By</th>
                <th>Assigned To</th> 
                <th>Due By</th> 
                <th>Status</th>
                <th>Edit</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($tasks as $Task) {

?>
            <tr>
	            <td><?php 
	                $parts = explode("-", $Task['date']);
		            echo "$parts[2]/$parts[1]/$parts[0]";
	                ?>
	            </td>
                <td><?php echo $Task['title'] ?></td>
                <td><?php echo $Task['createdBy']; ?></td>
                <td><?php echo $Task['assignedTo']; ?></td>
                <td><?php 
	                $parts = explode("-", $Task['dueBy']);
		            echo "$parts[2]/$parts[1]/$parts[0]";
	                ?>
	            </td>
	            <td>
		            <span<?php if($Task['status']=='Pending'){echo " class='notification notification-alert'";}elseif($Task['status']=='Active'){echo " class='notification notification-warning'";}elseif($Task['status']=='Complete'){echo " class='notification notification-success'";}?>>
		            <?php echo $Task['status'] ?>
		            </span>
		        </td>
                <td><a class="button button-small action-info" href="<?php echo $HTML->encode($API->app_path()); ?>/tasks/edit/?id=<?php echo $HTML->encode(urlencode($Task['natures_laboratory_taskID'])); ?>" class="button button-small action-info"><?php echo 'Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/tasks/delete/?id=<?php echo $HTML->encode(urlencode($Task['natures_laboratory_taskID'])); ?>" class="button button-small action-alert"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>
<?php    
    echo $HTML->main_panel_end();