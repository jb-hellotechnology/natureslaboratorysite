<link rel="stylesheet" href="/perch/addons/apps/natures_laboratory/assets/styles.css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.0/fullcalendar.min.css" />
<link rel="stylesheet" href="/perch/addons/apps/natures_laboratory/assets/fullcalendar-scheduler/scheduler.css" />

<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script type="text/javascript" src="/perch/addons/apps/natures_laboratory/assets/moment.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.0/fullcalendar.min.js"></script>
<script src='/perch/addons/apps/natures_laboratory/assets/fullcalendar-scheduler/scheduler.js'></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script src="/perch/addons/apps/natures_laboratory/html5-qrcode.min.js"></script>

<script>
$(document).ready(function() {
    $('select[name!=countryOfOrigin]').select2({
	    width:'resolve'
    });
});
</script>

<style>
	.select2-container{
		min-width:120px !important;
	}
</style>

<!--
<script>
	function onScanSuccess(qrCodeMessage) {
		alert(qrCodeMessage);
	}

	var html5QrcodeScanner = new Html5QrcodeScanner(
		"reader", { fps: 10, qrbox: 250 });
	html5QrcodeScanner.render(onScanSuccess);
</script>
-->

<script>
	$('#productCode_new').on('select2:select', function (e) {
		var pCode = $('#productCode_new').val();
		// GET THE SPEC
		$.post( "/perch/addons/apps/natures_laboratory/coa/getSpec.php", { code: pCode }).done(function( data ) {
			const obj = JSON.parse(data);
			console.log(obj);
			$('#countryOfOrigin').val(obj.countryOfOrigin);
			$('#colour').val(obj.colour);
			$('#taste').val(obj.taste);
			$('#foreignMatterAmount').val(obj.foreignMatter);
			$('#lossOnDryingAmount').val(obj.lossOnDrying);
			$('#totalAshAmount').val(obj.totalAsh);
			$('#ashInSolubleAmount').val(obj.ashInsolubleInHCl);
			$('#assayContentAmount').val(obj.assayContent);
			$('#leadAmount').val(obj.leadPb);
			$('#arsenicAmount').val(obj.arsenicAs);
			$('#mercuryAmount').val(obj.mercuryHg);
			$('#totalAerobicAmount').val(obj.totalAerobicMicrobialCount);
			$('#totalCombinedYeastMouldAmount').val(obj.totalCombinedYeastMouldsCount);
			$('#enteroBacteriaAmount').val(obj.enterobacteriaCountIncludingPseudomonas);
			$('#escherichiaAmount').val(obj.escherichiaColi);
			$('#salmonellaAmount').val(obj.salmonella);
			$('#staphylococcusAmount').val(obj.staphylococcusAureus);
			$('#mycotoxinsAmount').val(obj.mycotoxinsAflatoxinsOchratoxinA);
			$('#pesticidesAmount').val(obj.pesticides);
			$('#allergensPresent').val(obj.allergens);
			$('#macroscopic').val(obj.macroscopicCharacters);
			$('#microscopic').val(obj.microscopicCharacters);
		});			
	});
</script>