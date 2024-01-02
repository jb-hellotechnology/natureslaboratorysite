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
	    'active' => true,
	    'title' => 'Scheduled',
	    'link'  => $API->app_nav().'/production/scheduled/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
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
			
			echo '<table class="d">
	        <tbody>';
	        if($scheduled['specification']){
	        echo '<tr>
	        	<td>Specification</td>
	        	<td>'.$scheduled['specification'].'</td>
	        </tr>';
	        }
	        if($scheduled['packaging']){
	        echo '<tr>
	        	<td>Packaging Requirements</td>
	        	<td>'.$scheduled['packaging'].'</td>
	        </tr>';
	        }
	        if($scheduled['labelling']){
	        echo '<tr>
	        	<td>Labelling Requirements</td>
	        	<td>'.$scheduled['labelling'].'</td>
	        </tr>';
	        }
	        echo '
	        <tr>
	        	<td>Quantity Required</td>
	        	<td>'.$scheduled['units'].'</td>
	        </tr>';
	        if($product['STOCK_CAT']=='2' OR $product['STOCK_CAT']=='4'){
			$raw = $NaturesLaboratoryProduction->getProduct($product['COMPONENT_CODE_1']);
		    echo '
	        <tr>
	        	<td>Raw Material Available (SKU: '.$raw['STOCK_CODE'].')</td>
	        	<td>'.$raw['QTY_IN_STOCK'].'</td>
	        </tr>';  
	        }
	        echo '
	        </tbody>
	        </table>';
	        
	        echo $Form->date_field("date","Date Into Production",'');
	        
	        $weekToday = date("M-d-Y", mktime(0, 0, 0, date('m'), date('d')+7, date('Y')));
	        echo $Form->date_field("datePressed","Date Due To Complete",$weekToday);
	        
	        $names[] = array('label'=>'Please Select', 'value'=>'');
			$names[] = array('label'=>'Andy', 'value'=>'Andy');
			$names[] = array('label'=>'Ash', 'value'=>'Ash');
			$names[] = array('label'=>'Chris', 'value'=>'Chris');
			$names[] = array('label'=>'Sean', 'value'=>'Sean');
			$names[] = array('label'=>'Tom', 'value'=>'Tom');
	        
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
			echo $Form->select_field("barrel","Barrel #1 (if Applicable)",$alphas,'');
			echo $Form->select_field("barrel2","Barrel #2 (if Applicable)",$alphas,'');
			echo $Form->select_field("barrel3","Barrel #3 (if Applicable)",$alphas,'');
			echo $Form->select_field("barrel4","Barrel #4 (if Applicable)",$alphas,'');
			echo $Form->select_field("barrel5","Barrel #5 (if Applicable)",$alphas,'');
			
			echo $Form->select_field("producedBy","Produced By",$names,'');
			
			echo $Form->submit_field('btnSubmit', 'Into Production', $API->app_path());
			
			echo $Form->hidden("status",'in production');
			
			if($product['STOCK_CAT']=='1'){$batchPrefix = 'A';}
			if($product['STOCK_CAT']=='2'){$batchPrefix = 'N';}
			if($product['STOCK_CAT']=='4'){$batchPrefix = 'N';}
			if($product['STOCK_CAT']=='8'){$batchPrefix = 'C';}
			if($product['STOCK_CAT']=='10'){$batchPrefix = 'B';}
			if($product['STOCK_CAT']=='11'){$batchPrefix = 'R';}
			if($product['STOCK_CAT']=='17'){$batchPrefix = 'C';}
			if($product['STOCK_CAT']=='18'){$batchPrefix = 'ON';}
			if($product['STOCK_CAT']=='40'){$batchPrefix = 'L';}
			
			echo $Form->hidden("batchPrefix",$batchPrefix);
			
			echo $Form->form_end();
			
		}
	    
	}else{

	?>
	
	<table class="d">
        <thead>
            <tr>
	            <th class="first">SKU</th>
	            <th>Description</th>
                <th>Units</th>
                <th class="action last">Produce</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($scheduled as $Scheduled) {
	    $stock = $NaturesLaboratoryProduction->getProduct($Scheduled['sku']);
?>
            <tr>
	            <td><?php echo $Scheduled['sku']; ?>
                <td><?php echo $stock['DESCRIPTION'] ?></td>
                <td><?php echo $Scheduled['units']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/production/scheduled/?id=<?php echo $HTML->encode(urlencode($Scheduled['natures_laboratory_productionID'])); ?>" class="button button-small action-success"><?php echo 'Produce'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php
	}
	