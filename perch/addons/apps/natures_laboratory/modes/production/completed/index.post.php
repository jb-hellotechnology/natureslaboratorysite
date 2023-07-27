 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Production',
    'button'  => [
            'text' => $Lang->get('Production'),
            'link' => $API->app_nav().'/production/?add=true',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Shortfall',
	    'link'  => $API->app_nav().'/production/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Scheduled',
	    'link'  => $API->app_nav().'/production/scheduled/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'In Production',
	    'link'  => $API->app_nav().'/production/in-production/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Completed',
	    'link'  => $API->app_nav().'/production/completed/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if($_GET['id']){
	    
	    $process = $NaturesLaboratoryProduction->getProcess($_GET['id']);
		$product = $NaturesLaboratoryProduction->getProduct($process['sku']);
	
		echo '<h2>P'.str_pad($process['natures_laboratory_productionID'], 6, '0', STR_PAD_LEFT).' | '.$process['sku'].' - '.$product['DESCRIPTION'].'</h2>';
		
		echo '<br /><p>Works Production Order</p>
		
		<table class="d">
			<tbody>
				<tr>
					<td><strong>Date Scheduled</strong></td>
					<td>'.$process['scheduledOn'].'</td>
				</tr>
				<tr>
					<td><strong>Scheduled By</strong></td>
					<td>'.$process['scheduledBy'].'</td>
				</tr>
				<tr>
					<td><strong>WPO Number</strong></td>
					<td>P'.str_pad($process['natures_laboratory_productionID'], 6, '0', STR_PAD_LEFT).'</td>
				</tr>
			</tbody>
		</table>';
		
		echo '<br /><p>Order Details</p>
		
		<table class="d">
			<tbody>
				<tr>
					<td><strong>Product Code</strong></td>
					<td>'.$process['sku'].'</td>
				</tr>
				<tr>
					<td><strong>Description</strong></td>
					<td>'.$product['DESCRIPTION'].'</td>
				</tr>
				<tr>
					<td><strong>Specification</strong></td>
					<td>'.$process['specification'].'</td>
				</tr>
				<tr>
					<td><strong>Packaging</strong></td>
					<td>'.$process['packaging'].'</td>
				</tr>
				<tr>
					<td><strong>Labelling</strong></td>
					<td>'.$process['labelling'].'</td>
				</tr>
				<tr>
					<td><strong>Quantity Required</strong></td>
					<td>'.$process['units'].'</td>
				</tr>
			</tbody>
		</table>';
		
		echo '<br /><p>Stock Breakdown</p>
		
		<p><small>To be deducted from Sage as soon as you put in production</small></p>
		
		<table class="d">
	        <thead>
	            <tr>
		            <th class="first">Code</th>
		            <th>Product</th>
	                <th>Batch</th> 
	                <th>BBE</th>
	                <th>Quantity</th>
	            </tr>
	        </thead>
	        <tbody>';
			
			$i = 1;
			$units = 100000000;
			while($i<=50){
				$iQty = $NaturesLaboratoryProduction->getIngredient($process['sku'],$i);
				$required = round($product['COMPONENT_QTY_'.$i]*$process['units'],2);
				
				$iBatches = $NaturesLaboratoryProduction->getBatches($iQty['STOCK_CODE']);
				$b = false;
				
				$batches = array();
				
				
				if($iQty){
					$batchData = $NaturesLaboratoryProduction->getBatchData($_GET['id'],$iQty['STOCK_CODE']);
					$batchData2 = $NaturesLaboratoryProduction->getBatchBBE($batchData['batchCode']);
					$batchData3 = $NaturesLaboratoryProduction->getBatchBBE($batchData['batchCodeAlt']);
					echo '<tr>
							<td><strong>'.$iQty['STOCK_CODE'].'</strong></td>
							<td>'.$iQty['DESCRIPTION'].'</td>
							<td>'.$batchData['batchCode']; if($batchData['batchCodeAlt']){echo "<br />".$batchData['batchCodeAlt']; } echo '</td>
							<td>'.$batchData2['bbe']; if($batchData['batchCodeAlt']){echo "<br />".$batchData3['bbe']; } echo '</td>
							<td>'.$required.'</td>
						</tr>';
					$i++;
				}else{
					break;
				}
			}
			
			$i--;
			
			echo '</tbody>
			</table>
		
		<p><small>When deducting component stock from Sage please enter reference in the following format: INITIAL/WPO NO/FINISHED BATCH NO</small></p>
		
		<p><small>Check stock on Sage and raw material on shelves then deduct if correct.</small></p>';
		
		if($product['STOCK_CAT']=='2' OR $product['STOCK_CAT']=='4'){
		
			echo '<br /><p>Product Information</p>
			
			<table class="d">
				<tbody>
					<tr>
						<td><strong>Barrel</strong></td>
						<td>'.$process['barrel'].'</td>
					</tr>
					<tr>
						<td><strong>Date Into Production</strong></td>
						<td>'.$process['date'].'</td>
					</tr>
					<tr>
						<td><strong>Date Sage Updated</strong></td>
						<td>'.$process['dateSageUpdated'].'</td>
					</tr>
					<tr>
						<td><strong>Sage Updated By</strong></td>
						<td>'.$process['sageUpdatedBy'].'</td>
					</tr>
					<tr>
						<td><strong>Date Due To Press</strong></td>
						<td>'.$process['datePressed'].'</td>
					</tr>
					<tr>
						<td><strong>Date Completed</strong></td>
						<td>'.$process['completedDate'].'</td>
					</tr>
					<tr>
						<td><strong>Quantity Made</strong></td>
						<td>'.$process['unitsMade'].'</td>
					</tr>
					<tr>
						<td><strong>Batch Number Allocated</strong></td>
						<td>'.$process['batchPrefix'].''.$process['finishedBatch'].'</td>
					</tr>
				</tbody>
			</table>';
			
			echo '<br /><p>Bottling</p>
			
			<table class="d">
				<tbody>
					<tr>
						<td><strong>250ml</strong></td>
						<td>'.$process['250ml'].'</td>
					</tr>
					<tr>
						<td><strong>500ml</strong></td>
						<td>'.$process['500ml'].'</td>
					</tr>
					<tr>
						<td><strong>1000ml</strong></td>
						<td>'.$process['1000ml'].'</td>
					</tr>
					<tr>
						<td><strong>5l</strong></td>
						<td>'.$process['5l'].'</td>
					</tr>
					<tr>
						<td><strong>25l</strong></td>
						<td>'.$process['25l'].'</td>
					</tr>
					<tr>
						<td><strong>Other</strong></td>
						<td>'.$process['other'].'</td>
					</tr>
				</tbody>
			</table>';
		
		}else{
			
			echo '<br /><p>Product Information</p>
		
			<table class="d">
				<tbody>
					<tr>
						<td><strong>Date Into Production</strong></td>
						<td>'.$process['dateProduced'].'</td>
					</tr>
					<tr>
						<td><strong>Date Sage Updated</strong></td>
						<td>'.$process['dateSageUpdated'].'</td>
					</tr>
					<tr>
						<td><strong>Sage Updated By</strong></td>
						<td>'.$process['sageUpdatedBy'].'</td>
					</tr>
					<tr>
						<td><strong>Date Completed</strong></td>
						<td>'.$process['completedDate'].'</td>
					</tr>
					<tr>
						<td><strong>Quantity Made</strong></td>
						<td>'.$process['unitsMade'].'</td>
					</tr>
					<tr>
						<td><strong>Batch Number Allocated</strong></td>
						<td>'.$process['batchAllocated'].'</td>
					</tr>
				</tbody>
			</table>';
		
		}
		
		echo "<h2>Sign Off</h2>";
		
		echo $Form->form_start();
		
		$names[] = array('label'=>'Please Select', 'value'=>'');
		$names[] = array('label'=>'Andy', 'value'=>'Andy');
		$names[] = array('label'=>'Sean', 'value'=>'Sean');
		$names[] = array('label'=>'Tom', 'value'=>'Tom');
		$names[] = array('label'=>'Shankar', 'value'=>'Shankar');
		
		echo $Form->select_field("labelCheck","Labels Checked By",$names,$process['labelCheck']);
		echo $Form->select_field("qcCheck","QC Check By",$names,$process['qcCheck']);
		echo $Form->select_field("addedToSageBy","Added to Sage By",$names,$process['addedToSageBy']);
		echo $Form->date_field("dateAddedToSage","Date Added to Sage",$process['dateAddedToSage']);
		
	    echo $Form->submit_field('btnSubmit', 'Update', $API->app_path());
		echo $Form->form_end();
		
	}else{

		echo $Form->form_start();
	?>
	
	<table class="d">
        <thead>
            <tr>
	            <th class="first">Batch #</th>
	            <th>Download Production Record</th>
	            <th>Download Labels</th>
	            <th>SKU</th>
	            <th>Description</th>
                <th>Units</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>QC Check</th>
                <th class="action">View</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($production as $Production) {
	    $stock = $NaturesLaboratoryProduction->getProduct($Production['sku']);
	    $sParts = explode("-", $Production['date']);
	    $startDate = "$sParts[2]/$sParts[1]/$sParts[0]";
	    $eParts = explode("-", $Production['datePressed']);
	    $endDate = "$eParts[2]/$eParts[1]/$eParts[0]";
?>
            <tr>
	            <td>P<?php echo str_pad($Production['natures_laboratory_productionID'], 6, '0', STR_PAD_LEFT); ?></td>
	            <td><?php echo $Form->radio("download",'download','wpo_'.$Production['natures_laboratory_productionID'],''); ?></td>
	            <td><?php echo $Form->radio("download",'download','labels_'.$Production['natures_laboratory_productionID'],''); ?></td>
	            <td><?php echo $Production['sku']; ?>
                <td><?php echo $stock['DESCRIPTION'] ?></td>
                <td><?php echo $Production['units']; ?></td>
                <td><?php echo $startDate; ?></td>
                <td><?php echo $endDate; ?></td>
                <td>
	                <span<?php if($Production['qcCheck']==''){echo " class='notification notification-warning'";}elseif($Production['qcCheck']=='Shankar'){echo " class='notification notification-success'";}elseif($Goods['qa']=='TRUE'){echo " class='notification notification-success'";}?>>
	                	<?php 
		                	if($Production['qcCheck']=='Shankar'){
			                	echo 'COMPLETE';
			                }else{
				                echo 'INCOMPLETE';
				            } 
				        ?>
	                </span>
	            </td>
                <td><a class="button button-small action-info" href="<?php echo $HTML->encode($API->app_path()); ?>/production/completed/?id=<?php echo $HTML->encode(urlencode($Production['natures_laboratory_productionID'])); ?>"><?php echo 'View'; ?></a></td>
			</tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php
	$numbers[] = array('label'=>'1', 'value'=>'1');
		$numbers[] = array('label'=>'2', 'value'=>'2');
		$numbers[] = array('label'=>'3', 'value'=>'3');
		$numbers[] = array('label'=>'4', 'value'=>'4');
		$numbers[] = array('label'=>'5', 'value'=>'5');
		$numbers[] = array('label'=>'6', 'value'=>'6');
		$numbers[] = array('label'=>'7', 'value'=>'7');
		$numbers[] = array('label'=>'8', 'value'=>'8');
		
		echo $Form->select_field("start","Start Label",$numbers);
		echo $Form->submit_field('btnSubmit', 'Download', $API->app_path());
		echo $Form->form_end();
	}
	