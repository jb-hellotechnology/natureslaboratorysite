 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Non Conformance',
    'button'  => [
            'text' => $Lang->get('Non Conformance'),
            'link' => $API->app_nav().'/nonconformance/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Non Conformance',
	    'link'  => $API->app_nav().'/nonconformance/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Overview',
	    'link'  => $API->app_nav().'/nonconformance/overview/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Report',
	    'link'  => $API->app_nav().'/nonconformance/report/',
	]);
	
	$Smartbar->add_item([
        'active' => false,
        'type'   => 'search',
        'data'   => [
            'search' => 'nonconformance',
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
                <th>Date</th>
                <th>Title</th> 
                <th>Type</th> 
                <th>Status</th>  
                <th>Edit</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($nonconformances as $Nonconformance) {
		$fields = json_decode($Nonconformance['natures_laboratory_nonconformanceDynamicFields'], true);
?>
            <tr>
	            <td><?php echo $Form->radio("download", 'download', $Nonconformance['natures_laboratory_nonconformanceID'],'on',''); ?></td>
	            <td><?php 
	                $parts = explode("-", $Nonconformance['date']);
		            echo "$parts[2]/$parts[1]/$parts[0]";
	                ?>
	            </td>
                <td><?php echo $Nonconformance['title'] ?></td>
                <td><?php echo $Nonconformance['type']; ?></td>
                <td>
		            <?php if($fields['reviewPerson']==''){echo "<span class='notification notification-alert'>Pending</span>";}elseif($fields['reviewPerson']!==''){echo "<span class='notification notification-success'>Complete</span>";}?>
		        </td>
                <td><a class="button button-small action-info" href="<?php echo $HTML->encode($API->app_path()); ?>/nonconformance/edit/?id=<?php echo $HTML->encode(urlencode($Nonconformance['natures_laboratory_nonconformanceID'])); ?>" class="button button-small action-info"><?php echo 'Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/nonconformance/delete/?id=<?php echo $HTML->encode(urlencode($Nonconformance['natures_laboratory_nonconformanceID'])); ?>" class="button button-small action-alert"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>
<?php    
	echo $Form->submit_field('btnSubmit', 'Download PDF', $API->app_path());	
	echo $Form->form_end();
    echo $HTML->main_panel_end();