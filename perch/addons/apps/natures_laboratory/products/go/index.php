<?php
	$batchCode = $_GET['id'];
	if($batchCode<>''){
		header("location:https://herbalapothecaryuk.com/download-coa-files/?batch=".$batchCode);
	}
?>