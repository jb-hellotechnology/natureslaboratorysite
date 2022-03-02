<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo 'clock';
*/
?>
<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<?php
	//log timemoto event	
	$json = file_get_contents('php://input');
	$data = json_decode($json,true);
	
	$str = implode("|",$data);
	mail('jack@natureslaboratory.co.uk','data',$str);
	
	
	if($data['event']=='attendance.inserted'){
		
		$name = $data['data']['userFullName'];
		$timeLoggedRounded = $data['data']['timeLoggedRounded'];
		$attendanceStatus = $data['data']['attendanceStatusId'];
		
		if($attendanceStatus == 0){
			$attendanceStatus = 'clock in';
		}elseif($attendanceStatus == 1){
			$attendanceStatus = 'clock out';
		}
		
		timemoto_log($name,$timeLoggedRounded,$attendanceStatus,addslashes($json));
			
	}
?>