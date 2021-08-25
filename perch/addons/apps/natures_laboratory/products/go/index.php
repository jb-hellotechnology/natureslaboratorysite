<?php
	$batchCode = $_GET['id'];
	if($batchCode<>''){
		header("location:https://natureslaboratory.co.uk/herbal-apothecary/get-coa/?batch=".$batchCode);
	}
?>