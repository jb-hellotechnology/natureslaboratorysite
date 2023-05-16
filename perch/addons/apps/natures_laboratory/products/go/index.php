<?php
	$batchCode = $_GET['id'];
	if($batchCode<>''){
		header("location:https://herbalapothecaryuk.com/pages/download-certificate-of-analysis-files/?batch=".$batchCode);
	}
?>