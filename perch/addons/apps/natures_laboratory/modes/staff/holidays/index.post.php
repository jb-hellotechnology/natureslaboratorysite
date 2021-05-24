 <?php
	 
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    if($staffID){
    
	    echo $HTML->title_panel([
	    'heading' => $details['name'].' - Holidays',
	    'button'  => [
	            'text' => $Lang->get('Holidays'),
	            'link' => $API->app_nav().'/staff/holidays/add?id='.$_GET['id'],
	            'icon' => 'core/plus',
	        ],
	    ], $CurrentUser);
    
    }else{
	    
	    echo $HTML->title_panel([
	    'heading' => 'Holidays'
	    ], $CurrentUser);
	    
    }

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);
	
	if($staffID){
		
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
	    'active' => true,
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
		    'active' => false,
		    'title' => 'Volunteer Days',
		    'link'  => $API->app_nav().'/staff/volunteer-days/?id='.$staffID,
		]);
	
	}else{
		
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
		    'active' => true,
		    'title' => 'Holidays',
		    'link'  => $API->app_nav().'/staff/holidays/',
		]);
		
		$Smartbar->add_item([
		    'active' => false,
		    'title' => 'Bank Holidays',
		    'link'  => $API->app_nav().'/staff/bank-holidays/',
		]);
		
		$Smartbar->add_item([
		    'active' => false,
		    'title' => 'Early Finishes',
		    'link'  => $API->app_nav().'/staff/early-finishes/',
		]);
		
		$Smartbar->add_item([
		    'active' => false,
		    'title' => 'Skills Matrix',
		    'link'  => $API->app_nav().'/staff/skills-matrix/',
		]);
		
	}
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 
    
    if($staffID){
	    
	    $json = json_decode($details['natures_laboratory_staffDynamicFields'],true);
	    $totalAllowance = $json['holidayEntitlement'] + $json['boughtForward'] + $json['totalAccrued'];
	    
	    $today = date('Y-m-d');
		
		if($today>date('Y').'-01-01' AND $today<=date('Y').'-04-05'){
			$startYear = date('Y')-1;
			$endYear = date('Y');
		}elseif($today>date('Y').'-04-05'){
			$startYear = date('Y');
			$endYear = date('Y')+1;
		}else{
			$startYear = date('Y');
			$endYear = date('Y')+1;
		}
		
		$start = "$startYear-04-06";
		$end = "$endYear-04-05";
	    
	    $bankHolidays = $NaturesLaboratoryStaffBankholiday->getForYear($start,$end);
	    $compassionate = $NaturesLaboratoryStaffCompassionate->getForYear($_GET['id'],$start,$end);
	    $sick = $NaturesLaboratoryStaffSickdays->getForYear($_GET['id'],$start,$end);
	    $volunteer = $NaturesLaboratoryStaffVolunteerdays->getForYear($_GET['id'],$start,$end);
	    $holiday = $NaturesLaboratoryStaffHolidays->getForYear($_GET['id'],$start,$end);
	    
	    $compassionate = $json['compassionateDays'] - $compassionate;
	    $sick = $json['sickDays'] - $sick;
	    $volunteer = $json['volunteerDays'] - $volunteer;
	    
	    $bankHolidaysTaken = 0;
	    
	    foreach($bankHolidays as $bankHoliday){
		    print_r($bankHoliday);
		    $dayofweek = date('l', strtotime($bankHoliday['date']));
		    echo $dayofweek;
		    if($dayofweek=='Monday' AND $json['normalMonday']=='yes'){
			    $bankHolidaysTaken++;
		    }
		    if($dayofweek=='Tuesday' AND $json['normalTuesday']=='yes'){
			    $bankHolidaysTaken++;
		    }
	    }
	    
	    $remaining = $totalAllowance - $bankHolidaysTaken - $holiday;
	 
	?>  
    
    	<h2>Holiday Allowance</h2>
    	<table class="d">
	        <thead>
	            <tr>
		            <th>2021/22 Allowance</th>
		            <th>Days Bought Forward From 2020/21</th>
		            <th>Extra Days Accrued To Date</th>
		            <th>Total Entitlement</th>
		            <th>Bank Holidays Taken</th>
		            <th>Holidays Taken</th>
		            <th>Holidays Remaining</th>
		            <th>Paid Sick Leave Remaining</th>
		            <th>Compassionate Leave Remaining</th>
		            <th>Volunteer Day Remaining</th>
	            </tr>
	        </thead>
	        <tbody>
		        <tr>
			        <td><?php echo $json['holidayEntitlement']; ?></td>
			        <td><?php echo $json['boughtForward']; ?></td>
			        <td><?php echo $json['totalAccrued']; ?></td>
			        <td><?php echo $totalAllowance; ?></td>
			        <td><?php echo $bankHolidaysTaken; ?></td>
			        <td><?php echo $holiday; ?></td>
			        <td><?php echo $remaining; ?></td>
			        <td><?php echo $sick; ?></td>
			        <td><?php echo $compassionate; ?></td>
			        <td><?php echo $volunteer; ?></td>
		        </tr>
	        </tbody>
    	</table>

	<h2>Holiday Record</h2>
	<table class="d">
        <thead>
            <tr>
                <th>Date</th> 
                <th>Length</th> 
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
	    <?php
		    foreach($holidays as $holiday){
		?>
		<tr>
                <td><?php echo $holiday['date']; ?></td>
                <td><?php echo $holiday['length']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/staff/holidays/delete/?staffID=<?php echo $holiday['staffID'];?>&id=<?php echo $holiday['natures_laboratory_staff_holidayID']; ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
		<?php
		    }
		    
		?>
        </tbody>
	</table>

<?php 

	}else{

?>
	<h2>Holidays</h2>
	<p>Schedule here</p>
	
<?php		
		
	}

    echo $HTML->main_panel_end();