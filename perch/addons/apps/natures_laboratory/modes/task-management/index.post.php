 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Task Management',
    'button'  => [
            'text' => $Lang->get('Add Task'),
            'link' => $API->app_nav().'/task-management/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    echo $HTML->main_panel_start();
    ?>

    <table class="d">
        <thead>
            <tr>
	            <th class="first">Item 1</th>
                <th>Item 2</th>
                <th>Item 3</th> 
                <th>Item 4</th>
                <th>View/Edit</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($tasks as $Task) {
	    $data = PerchUtil::json_safe_decode($Task->natures_laboratory_taskDynamicFields(), true);
?>
            <tr>
	            <td><?php echo $data['item1']; ?></td>
                <td><?php echo $data['item2']; ?></td>
                <td><?php echo $data['item3']; ?></td>
                <td><?php echo $data['item4']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/task-management/edit/?id=<?php echo $HTML->encode(urlencode($Task->natures_laboratory_taskID())); ?>"><?php echo 'View/Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/task-management/delete/?id=<?php echo $HTML->encode(urlencode($Task->natures_laboratory_taskID())); ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    
    echo $HTML->main_panel_end();