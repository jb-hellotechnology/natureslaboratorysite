<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	//log timemoto event	
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);
	
	if($data->event=='attendance.inserted'){
		
		mail('jack@jackbarber.co.uk','test',$data);
		
		$name = $data->data->userFullName;
		$timeLoggedRounded = $data->data->timeLoggedRounded;
		$attendanceStatus = $data->data->attendanceStatusId;
		
		if($attendanceStatus == 0){
			$attendanceStatus = 'clocked out';
		}elseif($attendanceStatus == 1){
			$attendanceStatus = 'clocked in';
		}
		
		timemoto_log($name,$timeLoggedRounded,$attendanceStatus,$data);
			
	}
?>