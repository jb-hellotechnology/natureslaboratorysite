<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<h1><a href="/dispatch/">Dispatch</a></h1>
<?php
	if($_GET['order']){
		// ORDER EXISTS
		$orderDetails = orderDetails($_GET['order']);
		echo "<p>Order items:</p><ul>";
		foreach($orderDetails as $item){
			echo "<li>".$item['SKU']." x ".$item['quantity']."</li>";
		}
		echo "</ul>";
	}else{
		// SHOW LIST OF ORDERS
		$orders = pendingOrders();
		echo "<p>Select an order:</p><ul>";
		$orderNumber = "";
		foreach($orders as $Order){
			if($orderNumber<>$Order['orderNumber']){
				echo "<li><a href=\"/dispatch/?order=".$Order['orderNumber']."\">".$Order['orderNumber']."</a></li>";
				$orderNumber = $Order['orderNumber'];
			}
		}
		echo "</ul>";
	}
?>

<div id="video-container">
    <video id="qr-video"></video>
</div>
<b>Detected QR code: </b>
<span id="cam-qr-result">None</span>
<br>
<b>Last detected at: </b>
<span id="cam-qr-result-timestamp"></span>

<script type="module">
    import QrScanner from "../assets/js/qr-scanner.min.js";

    const video = document.getElementById('qr-video');
    const videoContainer = document.getElementById('video-container');
    const camHasCamera = document.getElementById('cam-has-camera');
    const camList = document.getElementById('cam-list');
    const camHasFlash = document.getElementById('cam-has-flash');
    const flashToggle = document.getElementById('flash-toggle');
    const flashState = document.getElementById('flash-state');
    const camQrResult = document.getElementById('cam-qr-result');
    const camQrResultTimestamp = document.getElementById('cam-qr-result-timestamp');
    const fileSelector = document.getElementById('file-selector');
    const fileQrResult = document.getElementById('file-qr-result');

    function setResult(label, result) {
        console.log(result.data);
        label.textContent = result.data;
        camQrResultTimestamp.textContent = new Date().toString();
        label.style.color = 'teal';
        clearTimeout(label.highlightTimeout);
        label.highlightTimeout = setTimeout(() => label.style.color = 'inherit', 100);
        
        // PARSE URL
        const urlParams = new URLSearchParams(result.data);
        
        const id = urlParams.get('id')
		console.log(id);
		const size = urlParams.get('size')
		console.log(size);
		const bbe = urlParams.get('bbe')
		console.log(bbe);
		alert(id + ' - ' + size + ' - ' + bbe);

    }

    // ####### Web Cam Scanning #######

    const scanner = new QrScanner(video, result => setResult(camQrResult, result), {
        onDecodeError: error => {
            camQrResult.textContent = error;
            camQrResult.style.color = 'inherit';
        },
        highlightScanRegion: true,
        highlightCodeOutline: true,
    });

    scanner.start().then(() => {
        updateFlashAvailability();
        // List cameras after the scanner started to avoid listCamera's stream and the scanner's stream being requested
        // at the same time which can result in listCamera's unconstrained stream also being offered to the scanner.
        // Note that we can also start the scanner after listCameras, we just have it this way around in the demo to
        // start the scanner earlier.
        QrScanner.listCameras(true).then(cameras => cameras.forEach(camera => {
            const option = document.createElement('option');
            option.value = camera.id;
            option.text = camera.label;
            camList.add(option);
        }));
    });

    QrScanner.hasCamera().then(hasCamera => camHasCamera.textContent = hasCamera);

    // for debugging
    window.scanner = scanner;

    // ####### File Scanning #######

    fileSelector.addEventListener('change', event => {
        const file = fileSelector.files[0];
        if (!file) {
            return;
        }
        QrScanner.scanImage(file, { returnDetailedScanResult: true })
            .then(result => setResult(fileQrResult, result))
            .catch(e => setResult(fileQrResult, { data: e || 'No QR code found.' }));
    });
</script>