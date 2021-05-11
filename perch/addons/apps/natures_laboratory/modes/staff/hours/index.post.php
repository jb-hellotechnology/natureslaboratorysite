 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    if($staffID){
    
	    echo $HTML->title_panel([
	    'heading' => $details['name'].' - Hours Worked',
	    'button'  => [
	            'text' => $Lang->get('Hours'),
	            'link' => $API->app_nav().'/staff/hours/add?id='.$_GET['id'],
	            'icon' => 'core/plus',
	        ],
	    ], $CurrentUser);
    
    }else{
	    
	    echo $HTML->title_panel([
	    'heading' => 'Hours Worked'
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
		    'active' => true,
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
		    'active' => true,
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
    
    $date = $_GET['date'];
    
    if($date<>''){
	    $parts = explode("-",$date);
	    $month = $parts[1];
	    $year = $parts[0];
	    $monthHuman = date("F", mktime(0, 0, 0, $month, 1, $year));
    }else{
    	$month = date('m');
    	$monthHuman = date('F');
    	$year = date('Y');
    }
    
    $nextMonth = $month+1;
    $nextYear = $year;
    if($nextMonth==13){
	    $nextMonth = 12;
	    $nextYear = $year+1;
    }
    
    $prevMonth = $month-1;
    $prevYear = $year;
    if($prevMonth==0){
	    $prevMonth=12;
	    $prevYear = $year-1;
    }
    
    $nextMonth = sprintf("%02d", $nextMonth);
    $prevMonth = sprintf("%02d", $prevMonth);
    
    if($staffID){
    
    ?>
	<h2><?php echo "$monthHuman $year" ?></h2>
	<p><a href="?id=<?php echo $_GET['id']; ?>&date=<?php echo "$prevYear-$prevMonth";?>">&larr; Previous Month</a> | <a href="?id=<?php echo $_GET['id']; ?>&date=<?php echo "$nextYear-$nextMonth";?>">Next Month &rarr;</a></p>
	
	<table class="d">
        <thead>
            <tr>
                <th class="first">Date</th>
                <th>Start Time</th> 
                <th>End Time</th> 
                <th>Hours Worked</th>
            </tr>
        </thead>
        <tbody>
	    <?php
		$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$today = date('Y-m-d');
		$i = 1;
		$totalHours = 0;
		$totalMinutes = 0;
		while($i<=$days){
			$humanDate = date("l jS F Y", mktime(0, 0, 0, $month, $i, $year));
			$queryDate = date("Y-m-d", mktime(0, 0, 0, $month, $i, $year));
			$start = $NaturesLaboratoryStaffTimes->startTime($queryDate,$_GET['id']);
			$end = $NaturesLaboratoryStaffTimes->endTime($queryDate,$_GET['id']);
			$hoursWorked = '00:00';
			if($start['timeStamp']<>'' AND $end['timeStamp']<>''){
				$time1 = $start['timeStamp'];
				$time2 = $end['timeStamp'];
				$diff = abs(strtotime($time1) - strtotime($time2));
				$tmins = $diff/60;
				$hours = floor($tmins/60);
				$mins = $tmins%60;
				$hoursWorked = "$hours:$mins";
				$totalHours = $totalHours+$hours;
				$totalMinutes = $totalMinutes+$mins;
			}
			
			$class = '';
			
			if($start['timeStamp']<>'' AND $end['timeStamp']=='' AND $queryDate<>$today){
				$hoursWorked = 'ERROR';
				$class = 'notification notification-warning';
			}
			
			if($queryDate==$today){
				$hoursWorked = 'TODAY';
				$class = 'notification notification-success';
			}
			
			echo "
			<tr class='$class'>
				<td>".$humanDate."</td>
				<td>";if($start['timeStamp']<>''){echo $start['timeStamp'];} echo "</td>
				<td>";if($end['timeStamp']<>''){echo $end['timeStamp'];} echo "</td>
				<td>$hoursWorked</td>
			</tr>";
			$i++;
		}  
		
		$totalMinutes_h = "00:00";
		if(convertToHoursMins($totalMinutes, '%02d:%02d')<>''){
			$totalMinutes_h = convertToHoursMins($totalMinutes, '%02d:%02d');
		}
		$parts = explode(":",$totalMinutes_h);
		$totalHours = $totalHours+$parts[0];
		$totalMinutes = $parts[1];
		
		echo "<tfoot>
				<tr><td><strong>Total Hours Worked</strong></td>
				<td></td>
				<td></td>
				<td><strong>$totalHours:$totalMinutes</strong></td>
		</tfoot>";
		?>    
        </tbody>
	</table>
	
	<h2>Full Log</h2>
	
    <table class="d">
        <thead>
            <tr>
                <th class="first">Time Type</th>
                <th>Time Stamp</th> 
                <th>View/Edit</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($times as $Time) {
?>
            <tr>
                <td><?php echo ucwords($Time['timeType']); ?></td>
                <td><?php echo $Time['timeStamp']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/staff/hours/edit/?id=<?php echo $HTML->encode(urlencode($Time['natures_laboratory_staff_timeID'])); ?>"><?php echo 'View/Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/staff/hours/delete/?id=<?php echo $HTML->encode(urlencode($Time['natures_laboratory_staff_timeID'])); ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php 

	}else{

?>
	<h2><?php echo "$monthHuman $year" ?></h2>
	<p><a href="?id=<?php echo $_GET['id']; ?>&date=<?php echo "$prevYear-$prevMonth";?>">&larr; Previous Month</a> | <a href="?id=<?php echo $_GET['id']; ?>&date=<?php echo "$nextYear-$nextMonth";?>">Next Month &rarr;</a></p>
	<?php
		$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
	?>
	<table class="d">
        <thead>
            <tr>
                <th class="first">Name</th>
                <?php
	                $i = 1;
	                while($i<=$days){
		                echo "<th>$i</th>";
		                $i++;
	                }
	            ?>
	            <th>Total</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($staff as $Staff) {

	    $dynamicFields = PerchUtil::json_safe_decode($Staff->natures_laboratory_staffDynamicFields(), true);
	    
?>
            <tr>
                <td><?php echo $Staff->name(); ?></td>
                <?php
	                $i = 1;
	                $totalHours = 0;
	                $totalMinutes = 0;
	                while($i<=$days){
		                $hoursWorked = $NaturesLaboratoryStaffTimes->hoursWorked($Staff->natures_laboratory_staffID(),$year,$month,$i);
		                $parts = explode(":",$hoursWorked);
		                $hours = $parts[0];
		                $minutes = $parts[1];
		                
		                $day = date("l", mktime(0, 0, 0, $month, $i, $year));
		                $date = date("Y-m-d", mktime(0, 0, 0, $month, $i, $year));

						$extras = '';
						$earlyFinish = false;

						if($day=='Friday'AND $dynamicFields['earlyWednesday']<>'yes' AND $hours<>''){
							$earlyFinish = $NaturesLaboratoryStaffEarlyFinish->getDate($date);
							if($earlyFinish['natures_laboratory_staff_earlyfinishID']<>1){
								if($earlyFinish['targetHit']=='15000'){
									if($dynamicFields['jobType']=='Part Time'){
										$extras = '30min';
										$minutes = $minutes+30;
									}elseif($dynamicFields['jobType']=='Full Time'){
										$extras = '1hr';
										$hours = $hours+1;
									}
								}elseif($earlyFinish['targetHit']=='20000'){
									if($dynamicFields['jobType']=='Part Time'){
										$extras = '45min';
										$minutes = $minutes+45;
									}elseif($dynamicFields['jobType']=='Full Time'){
										$extras = '1.5hr';
										$hours = $hours+1;
										$minutes = $minutes+30;
									}
								}
								$earlyFinish = true;
							}
						}
						
						if($day=='Wednesday' AND $dynamicFields['earlyWednesday']=='yes' AND $hours<>''){
							$lastFriday = date("Y-m-d", mktime(0, 0, 0, $month, $i-5, $year));
							$earlyFinish = $NaturesLaboratoryStaffEarlyFinish->getDate($lastFriday);
							if($earlyFinish['natures_laboratory_staff_earlyfinishID']<>1){
								if($earlyFinish['targetHit']=='15000'){
									if($dynamicFields['jobType']=='Part Time'){
										$extras = '30min';
										$minutes = $minutes+30;
									}elseif($dynamicFields['jobType']=='Full Time'){
										$extras = '1hr';
										$hours = $hours+1;
									}
								}elseif($earlyFinish['targetHit']=='20000'){
									if($dynamicFields['jobType']=='Part Time'){
										$extras = '45min';
										$minutes = $minutes+45;
									}elseif($dynamicFields['jobType']=='Full Time'){
										$extras = '1.5hr';
										$hours = $hours+1;
										$minutes = $minutes+30;
									}
								}
								$earlyFinish = true;
							}
						}
						
						$bankHoliday = $NaturesLaboratoryStaffBankholiday->getDate($date);
						if($bankHoliday){
							$class = '';
							if($dynamicFields['normalMonday']=='yes'){
								$hoursWorked = '<i>8:30</i>';
								$minutes = $minutes+30;
								$hours = $hours+8;
							}
						}else{
							$class = '';
						}
		                
		                $totalHours = $totalHours+$hours;
		                $totalMinutes = $totalMinutes+$minutes;
		                
		                if($earlyFinish AND $hoursWorked<>''){
		                	echo "<td class='$class'><strong>$hoursWorked + $extras</strong></td>";
		                }else{
			                echo "<td class='$class'>$hoursWorked</td>";
		                }
		                $i++;
	                }
	                
	                $totalMinutes_h = floor($totalMinutes/60);
	                if(convertToHoursMins($totalMinutes, '%02d:%02d')<>''){
						$totalMinutes_h = convertToHoursMins($totalMinutes, '%02d:%02d');
					}
					$parts = explode(":",$totalMinutes_h);
					$totalHours = $totalHours+$parts[0];
					$totalMinutes = $parts[1];
					
					if($totalMinutes==''){
						$totalMinutes='00';
					}
	                
	                echo "<td>$totalHours:$totalMinutes</td>";
	            ?>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>
    
    <p><strong>Bold</strong> = Early Finish</p>
    <p><i>Italic</i> = Holiday Hours</p>

<?php		
		
	}

	function convertToHoursMins($time, $format = '%02d:%02d') {
	    if ($time < 1) {
	        return;
	    }
	    $hours = floor($time / 60);
	    $minutes = ($time % 60);
	    return sprintf($format, $hours, $minutes);
	}

    echo $HTML->main_panel_end();