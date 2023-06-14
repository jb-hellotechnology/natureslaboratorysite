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
	    'active' => true,
	    'title' => 'In Production',
	    'link'  => $API->app_nav().'/production/in-production/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Completed',
	    'link'  => $API->app_nav().'/production/completed/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if($_GET['id']){
	    
	    if (isset($message)){ 
	    
		    echo $message;
		    
		}else{
	    
		    $scheduled = $NaturesLaboratoryProduction->getProcess($_GET['id']);
			$product = $NaturesLaboratoryProduction->getProduct($scheduled['sku']);
			
			echo $Form->form_start();
			
			echo "<h2>$product[STOCK_CODE] | $product[DESCRIPTION]</h2>";

			echo "<br /><p>How Much Do You Want To Make?</p>";
			
			echo $Form->text_field("units","Units",$scheduled['units']);
			
			echo "<br /><p>Additional Requirements</p>";
	        
	        echo $Form->text_field("specification","Specification",$scheduled['specification']);
			echo $Form->text_field("packaging","Packaging Requirements",$scheduled['packaging']);
			echo $Form->text_field("labelling","Labelling Requirements",$scheduled['labelling']);
	        
	        echo "<br /><p>Manufacturing Details</p>";
	        
	        echo $Form->date_field("date","Date Into Production",$scheduled['date']);
	        echo $Form->date_field("datePressed","Date Due To Press",$scheduled['datePressed']);
	        echo $Form->date_field("dateSageUpdated","Date Sage Updated",$scheduled['dateSageUpdated']);
	        
	        $names[] = array('label'=>'Please Select', 'value'=>'');
			$names[] = array('label'=>'Andy', 'value'=>'Andy');
			$names[] = array('label'=>'Sean', 'value'=>'Sean');
			$names[] = array('label'=>'Tom', 'value'=>'Tom');
			echo $Form->select_field("sageUpdatedBy","Sage Updated By",$names,$scheduled['sageUpdatedBy']);
	        
	        $alphas[] = array('label'=>'Please Select', 'value'=>'');
			$alphas[] = array('label'=>'A', 'value'=>'A');
			$alphas[] = array('label'=>'B', 'value'=>'B');
			$alphas[] = array('label'=>'C', 'value'=>'C');
			$alphas[] = array('label'=>'D', 'value'=>'D');
			$alphas[] = array('label'=>'E', 'value'=>'E');
			$alphas[] = array('label'=>'F', 'value'=>'F');
			$alphas[] = array('label'=>'G', 'value'=>'G');
			$alphas[] = array('label'=>'H', 'value'=>'H');
			$alphas[] = array('label'=>'I', 'value'=>'I');
			$alphas[] = array('label'=>'J', 'value'=>'J');
			$alphas[] = array('label'=>'K', 'value'=>'K');
			$alphas[] = array('label'=>'L', 'value'=>'L');
			$alphas[] = array('label'=>'M', 'value'=>'M');
			$alphas[] = array('label'=>'N', 'value'=>'N');
			$alphas[] = array('label'=>'O', 'value'=>'O');
			$alphas[] = array('label'=>'P', 'value'=>'P');
			$alphas[] = array('label'=>'Q', 'value'=>'Q');
			$alphas[] = array('label'=>'R', 'value'=>'R');
			$alphas[] = array('label'=>'S', 'value'=>'S');
			$alphas[] = array('label'=>'T', 'value'=>'T');
			$alphas[] = array('label'=>'U', 'value'=>'U');
			$alphas[] = array('label'=>'V', 'value'=>'V');
			$alphas[] = array('label'=>'W', 'value'=>'W');
			$alphas[] = array('label'=>'X', 'value'=>'X');
			$alphas[] = array('label'=>'Y', 'value'=>'Y');
			$alphas[] = array('label'=>'Z', 'value'=>'Z');
			$alphas[] = array('label'=>'1', 'value'=>'1');
			$alphas[] = array('label'=>'2', 'value'=>'2');
			$alphas[] = array('label'=>'3', 'value'=>'3');
			$alphas[] = array('label'=>'4', 'value'=>'4');
			$alphas[] = array('label'=>'5', 'value'=>'5');
			$alphas[] = array('label'=>'6', 'value'=>'6');
			$alphas[] = array('label'=>'7', 'value'=>'7');
			$alphas[] = array('label'=>'8', 'value'=>'8');
			$alphas[] = array('label'=>'9', 'value'=>'9');
			$alphas[] = array('label'=>'10', 'value'=>'10');
			echo $Form->select_field("barrel","Barrel #1",$alphas,$scheduled['barrel']);
			echo $Form->select_field("barrel2","Barrel #2",$alphas,$scheduled['barrel2']);
			echo $Form->select_field("barrel3","Barrel #3",$alphas,$scheduled['barrel3']);
			echo $Form->select_field("barrel4","Barrel #4",$alphas,$scheduled['barrel4']);
			echo $Form->select_field("barrel5","Barrel #5",$alphas,$scheduled['barrel5']);
			
			echo $Form->select_field("producedBy","Produced By",$names,$scheduled['producedBy']);
			
			echo '<br /><p>Ingredients</p>
			
			<table class="d">
	        <thead>
	            <tr>
		            <th class="first">#</th>
		            <th>SKU</th>
	                <th>Qty Required</th> 
	                <th>Batch</th>
	            </tr>
	        </thead>
	        <tbody>';
			
			$i = 1;
			$units = 100000000;
			while($i<=50){
				$iQty = $NaturesLaboratoryProduction->getIngredient($scheduled['sku'],$i);
				$required = round($product['COMPONENT_QTY_'.$i]*$scheduled['units'],2);
				if($iQty['STOCK_CODE']=='ALC96'){
					$required = round($required*1.04,2);
				}
				
				$iBatches = $NaturesLaboratoryProduction->getBatches($iQty['STOCK_CODE']);
				$b = false;
				
				$batches = array();
				
				if($iBatches){
					$batches[] = array('label'=>'Please Select', 'value'=>'');
				}
				
				foreach($iBatches as $batch){
					$batches[] = array('label'=>$batch['ourBatch'], 'value'=>$batch['ourBatch']);
					$b = true;
				}
				
				if($iQty){
					$batchData = $NaturesLaboratoryProduction->getBatchData($_GET['id'],$iQty['STOCK_CODE']);
					echo '<tr>
							<td>'.$i.'</td>
							<td>'.$iQty['STOCK_CODE'].'</td>
							<td>'.$required.'</td>
							<td>'; 
								if($b){
									echo $Form->select_field("batch_".$i,"",$batches,$batchData['batchCode']);
									echo $Form->select_field("batch_alt_".$i,"",$batches,$batchData['batchCodeAlt']);
								} 
								echo $Form->hidden("ingredient_".$i,$iQty['STOCK_CODE']); echo '</td>
						</tr>';
					$i++;
				}else{
					break;
				}
			}
			
			$i--;
			
			echo '</tbody>
			</table>';
			
			echo $Form->submit_field('btnSubmit', 'Update', $API->app_path());
			
			echo $Form->hidden("status",'in production');
			echo $Form->hidden("ingredients",$i);
			
			echo $Form->form_end();
			
		}
	    
	}else{

		echo $Form->form_start();
	?>
	
	<table class="d">
        <thead>
            <tr>
	            <th class="first">Batch #</th>
	            <th>Download WPO</th>
	            <th>Download Labels</th>
	            <th>SKU</th>
	            <th>Description</th>
                <th>Units</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th class="action">Edit</th>
                <th class="action last">Complete</th>
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
	            <td><?php echo $Form->radio("download",'download','label_'.$Production['natures_laboratory_productionID'],''); ?></td>
	            <td><?php echo $Production['sku']; ?>
                <td><?php echo $stock['DESCRIPTION'] ?></td>
                <td><?php echo $Production['units']; ?></td>
                <td><?php echo $startDate; ?></td>
                <td><?php echo $endDate; ?></td>
                <td><a class="button button-small action-info" href="<?php echo $HTML->encode($API->app_path()); ?>/production/in-production/?id=<?php echo $HTML->encode(urlencode($Production['natures_laboratory_productionID'])); ?>"><?php echo 'Edit'; ?></a></td>
				<td><a class="button button-small action-success" href="<?php echo $HTML->encode($API->app_path()); ?>/production/complete/?id=<?php echo $HTML->encode(urlencode($Production['natures_laboratory_productionID'])); ?>"><?php echo 'Complete'; ?></a></td>
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
		
		echo $Form->select_field("labels","How Many Labels?",$numbers);
		echo $Form->select_field("start","Start Label",$numbers);
		echo $Form->submit_field('btnSubmit', 'Download', $API->app_path());
		echo $Form->form_end();
	}
	