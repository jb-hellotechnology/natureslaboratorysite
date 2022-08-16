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
		$.post( "/perch/addons/apps/natures_laboratory/coa/getBatches.php", { code: pCode }).done(function( data ) {
			$('#batches').html(data);
		});			
	});
	$('#batch').blur(function(e){
		var pCode = $('#productCode').val();
		var pBatch = $('#batch').val();
		// GET THE SPEC
		$.post( "/perch/addons/apps/natures_laboratory/goods-in/getCodes.php", { code: pCode, batch: pBatch }).done(function( data ) {
			console.log(data);
			if(data==''){
				$('form').hide();
				$('#error').show();
				$.post( "/perch/addons/apps/natures_laboratory/labels/sendAlert.php", {}).done(function(){
					
				});
			}
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
	$('#cap_spec').on('select2:select', function (e) {
		var pCode = $('#cap_spec').val();
		// GET THE SPEC
		$.post( "/perch/addons/apps/natures_laboratory/coa-capsules/getSpec.php", { code: pCode }).done(function( data ) {
			const obj = JSON.parse(data);
			console.log(obj);
			$('#spec_countryOfOrigin').text(obj.countryOfOrigin);
			$('#spec_colour').text(obj.colour);
			$('#spec_taste').text(obj.taste);
			$('#spec_odour').text(obj.odour);
		});			
	});
	$('#ourBatch').on('select2:select', function (e) {
		var pBatch = $('#ourBatch').val();
		// GET THE SPEC
		$.post( "/perch/addons/apps/natures_laboratory/coa/getBatch.php", { batch: pBatch }).done(function( data ) {
			const obj = JSON.parse(data);
			console.log(obj);
			$('#batch_countryOfOrigin').text(obj.countryOfOrigin);
		});			
	});
	function selectCOA(pCOA){
		var coa = $('#'+pCOA).data('coa');
		console.log(coa.replace(/\\/g, ''));
		const obj = JSON.parse(coa.replace(/\\/g, ''));
		$('#countryOfOrigin').val(obj.countryOfOrigin);
		$('#colour').val(obj.colour);
		$('#taste').val(obj.taste);
		$('#odour').val(obj.odour);
		$('#foreignMatterAmount').val(obj.foreignMatterAmount);
		$('#lossOnDryingAmount').val(obj.lossOnDryingAmount);
		$('#totalAshAmount').val(obj.totalAshAmount);
		$('#ashInSolubleAmount').val(obj.ashInsolubleInHCl);
		$('#assayContentAmount').val(obj.assayContentAmount);
		$('#leadAmount').val(obj.leadAmount);
		$('#arsenicAmount').val(obj.arsenicAmount);
		$('#mercuryAmount').val(obj.mercuryAmount);
		$('#totalAerobicAmount').val(obj.totalAerobicAmount);
		$('#totalCombinedYeastMouldAmount').val(obj.totalCombinedYeastMouldsAmount);
		$('#enteroBacteriaAmount').val(obj.enteroBacteriaAmount);
		$('#escherichiaAmount').val(obj.escherichiaAmount);
		$('#salmonellaAmount').val(obj.salmonellaAmount);
		$('#staphylococcusAmount').val(obj.staphylococcusAmount);
		$('#mycotoxinsAmount').val(obj.mycotoxinsAmount);
		$('#pesticidesAmount').val(obj.pesticidesAmount);
		$('#allergensPresent').val(obj.allergensPresent);
		$('#box1').val(obj.box1);
		$('#box2').val(obj.box2);
		$('#box3').val(obj.box3);
		$('#box4').val(obj.box4);
		$('#macroscopic').val(obj.macroscopic);
		$('#microscopic').val(obj.microscopic);
	}

</script>