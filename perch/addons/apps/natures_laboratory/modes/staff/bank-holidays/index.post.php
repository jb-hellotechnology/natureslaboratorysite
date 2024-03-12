 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Bank Holidays',
    'button'  => [
            'text' => $Lang->get('Bank Holiday'),
            'link' => $API->app_nav().'/staff/bank-holidays/add',
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
	    'active' => true,
	    'title' => 'Bank Holidays',
	    'link'  => $API->app_nav().'/staff/bank-holidays/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Early Finishes',
	    'link'  => $API->app_nav().'/staff/early-finishes/',
	]);
	
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 

?>
	<table class="d">
        <thead>
            <tr>
                <th class="first">Date</th>
	            <th>Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($bankholidays as $BankHoliday) {
?>
            <tr>
	            <td>
	                <?php 
		                $parts = explode("-", $BankHoliday->date());
	                	echo "$parts[2]/$parts[1]/$parts[0]"; 
	                ?>
	            </td>
                <td><a class="button button-small action-alert" href="<?php echo $HTML->encode($API->app_path()); ?>/staff/bank-holidays/delete/?id=<?php echo $HTML->encode(urlencode($BankHoliday->natures_laboratory_staff_bankholidayID())); ?>"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php		

    echo $HTML->main_panel_end();