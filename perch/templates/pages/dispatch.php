<?php include($_SERVER['DOCUMENT_ROOT'].'/perch/runtime.php'); ?>
<h1><a href="/dispatch/">Dispatch</a></h1>
<?php
	if($_GET['order']){
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			if($_POST['delete']){
				//$message = deleteItem($_POST['itemID']);
			}else{
				$message = logItem($_POST['id'], $_POST['size'], $_POST['bbe'], $_POST['bbe_month'], $_POST['bbe_year'], $_GET['order']);	
			}
		}
		
		if($message){
			echo $message;
		}
		
		// ORDER EXISTS
		$orderDetails = orderDetails($_GET['order']);
		echo "<p>Order items:</p><ul>";
		foreach($orderDetails as $item){
			echo "<li>".$item['SKU']." x ".$item['quantity'];
			// Logged Items Here
			echo "<ul>";
			$orderItems = orderItems($_GET['order'], $item['SKU']);
			foreach($orderItems as $orderItem){
				echo "<li>".$orderItem['SKU']." [".$orderItem['batch']."] [".$orderItem['bbe']."] [".$orderItem['size']."]</li>";
			}	
			echo "</ul>";
			echo "</li>";
		}
		echo "</ul>";
		echo "<p><strong>Log Item:</strong></p>";
		echo "<form method=\"POST\" id=\"log\" action=\"/dispatch/?order=".$_GET['order']."\">";
		echo "<label>Batch Code</label><input type=\"text\" id=\"id\" name=\"id\" />";
		echo "<label>Size</label><input type=\"text\" id=\"size\" name=\"size\" />";
		echo "<label>BBE</label><input type=\"text\" id=\"bbe\" name=\"bbe\" />";
		echo "<select id=\"bbe_month\" name=\"bbe_month\">
				<option>01</option>
				<option>02</option>
				<option>03</option>
				<option>04</option>
				<option>05</option>
				<option>06</option>
				<option>07</option>
				<option>08</option>
				<option>09</option>
				<option>10</option>
				<option>11</option>
				<option>12</option>
			  </select>";
		echo "<select id=\"bbe_year\" name=\"bbe_year\">
				<option>2024</option>
				<option>2025</option>
				<option>2026</option>
				<option>2027</option>
				<option>2028</option>
			  </select>";
		echo "<input type=\"submit\" value=\"Submit\" />";
		echo "</form>";
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
        
        // PARSE URL
        const urlParams = new URLSearchParams(result.data);
        
        var product = getAllUrlParams(result.data).id;
		const size = urlParams.get('size')
		const bbe = urlParams.get('bbe')
		document.getElementById("id").value = product;
		document.getElementById("size").value = size;
		document.getElementById("bbe").value = bbe;
		
		document.getElementById("log").submit(); 

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
    
    function getAllUrlParams(url) {

	  // get query string from url (optional) or window
	  var queryString = url ? url.split('?')[1] : window.location.search.slice(1);
	
	  // we'll store the parameters here
	  var obj = {};
	
	  // if query string exists
	  if (queryString) {
	
	    // stuff after # is not part of query string, so get rid of it
	    queryString = queryString.split('#')[0];
	
	    // split our query string into its component parts
	    var arr = queryString.split('&');
	
	    for (var i = 0; i < arr.length; i++) {
	      // separate the keys and the values
	      var a = arr[i].split('=');
	
	      // set parameter name and value (use 'true' if empty)
	      var paramName = a[0];
	      var paramValue = typeof (a[1]) === 'undefined' ? true : a[1];
	
	      // (optional) keep case consistent
	      paramName = paramName.toLowerCase();
	      if (typeof paramValue === 'string') paramValue = paramValue.toLowerCase();
	
	      // if the paramName ends with square brackets, e.g. colors[] or colors[2]
	      if (paramName.match(/\[(\d+)?\]$/)) {
	
	        // create key if it doesn't exist
	        var key = paramName.replace(/\[(\d+)?\]/, '');
	        if (!obj[key]) obj[key] = [];
	
	        // if it's an indexed array e.g. colors[2]
	        if (paramName.match(/\[\d+\]$/)) {
	          // get the index value and add the entry at the appropriate position
	          var index = /\[(\d+)\]/.exec(paramName)[1];
	          obj[key][index] = paramValue;
	        } else {
	          // otherwise add the value to the end of the array
	          obj[key].push(paramValue);
	        }
	      } else {
	        // we're dealing with a string
	        if (!obj[paramName]) {
	          // if it doesn't exist, create property
	          obj[paramName] = paramValue;
	        } else if (obj[paramName] && typeof obj[paramName] === 'string'){
	          // if property does exist and it's a string, convert it to an array
	          obj[paramName] = [obj[paramName]];
	          obj[paramName].push(paramValue);
	        } else {
	          // otherwise add the property
	          obj[paramName].push(paramValue);
	        }
	      }
	    }
	  }
	
	  return obj;
	}

</script>

<?php
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