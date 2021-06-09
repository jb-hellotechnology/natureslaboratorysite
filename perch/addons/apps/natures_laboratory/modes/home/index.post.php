<div style="width: 500px" id="reader"></div>

<script>
	function onScanSuccess(qrCodeMessage) {
	// handle on success condition with the decoded message
}

var html5QrcodeScanner = new Html5QrcodeScanner(
	"reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
</script>