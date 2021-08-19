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
	.field-wrap.spec{
		padding-top:0px;
		margin-top:-5px;
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
			$('#spec_countryOfOrigin').text(obj.countryOfOrigin);
			$('#spec_colour').text(obj.colour);
			$('#spec_taste').text(obj.taste);
			$('#spec_odour').text(obj.odour);
			$('#spec_foreignMatterAmount').text(obj.foreignMatter);
			$('#spec_lossOnDryingAmount').text(obj.lossOnDrying);
			$('#spec_totalAshAmount').text(obj.totalAsh);
			$('#spec_ashInSolubleAmount').text(obj.ashInsolubleInHCl);
			$('#spec_assayContentAmount').text(obj.assayContent);
			$('#spec_leadAmount').text(obj.leadPb);
			$('#spec_arsenicAmount').text(obj.arsenicAs);
			$('#spec_mercuryAmount').text(obj.mercuryHg);
			$('#spec_totalAerobicAmount').text(obj.totalAerobicMicrobialCount);
			$('#spec_totalCombinedYeastMouldAmount').text(obj.totalCombinedYeastMouldsCount);
			$('#spec_enteroBacteriaAmount').text(obj.enterobacteriaCountIncludingPseudomonas);
			$('#spec_escherichiaAmount').text(obj.escherichiaColi);
			$('#spec_salmonellaAmount').text(obj.salmonella);
			$('#spec_staphylococcusAmount').text(obj.staphylococcusAureus);
			$('#spec_mycotoxinsAmount').text(obj.mycotoxinsAflatoxinsOchratoxinA);
			$('#spec_pesticidesAmount').text(obj.pesticides);
			$('#spec_allergensPresent').text(obj.allergens);
			$('#spec_macroscopic').text(obj.macroscopicCharacters);
			$('#spec_microscopic').text(obj.microscopicCharacters);
		});			
	});
	$('#spec').on('select2:select', function (e) {
		var pCode = $('#spec').val();
		// GET THE SPEC
		$.post( "/perch/addons/apps/natures_laboratory/coa-products/getSpec.php", { code: pCode }).done(function( data ) {
			const obj = JSON.parse(data);
			console.log(obj);
			$('#spec_countryOfOrigin').text(obj.countryOfOrigin);
			$('#spec_colour').text(obj.colour);
			$('#spec_taste').text(obj.taste);
			$('#spec_odour').text(obj.odour);
		});			
	});
</script>