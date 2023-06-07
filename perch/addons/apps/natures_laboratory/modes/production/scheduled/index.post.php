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
	        <tbody>
	        <tr>
	        	<td>Specification</td>
	        	<td>'.$scheduled['specification'].'</td>
	        </tr>
	        <tr>
	        	<td>Packaging Requirements</td>
	        	<td>'.$scheduled['packaging'].'</td>
	        </tr>
	        <tr>
	        	<td>Labelling Requirements</td>
	        	<td>'.$scheduled['labelling'].'</td>
	        </tr>
	        <tr>
	        	<td>Quantity Required</td>
	        	<td>'.$scheduled['units'].'</td>
	        </tr>
	        </tbody>
	        </table>';
	        
	        echo $Form->date_field("date","Date Into Production",'');
	        echo $Form->date_field("datePressed","Date Due To Complete",'');
	        echo $Form->date_field("dateSageUpdated","Date Sage Updated",'');
	        
	        $names[] = array('label'=>'Please Select', 'value'=>'');
			$names[] = array('label'=>'Andy', 'value'=>'Andy');
			$names[] = array('label'=>'Sean', 'value'=>'Sean');
			$names[] = array('label'=>'Tom', 'value'=>'Tom');
			echo $Form->select_field("sageUpdatedBy","Sage Updated By",$names,'');
	        
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
			echo $Form->select_field("barrel","Barrel (if Applicable)",$alphas,'');
			
			echo $Form->submit_field('btnSubmit', 'Into Production', $API->app_path());
			
			echo $Form->hidden("status",'in production');
			
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
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/production/scheduled/?id=<?php echo $HTML->encode(urlencode($Scheduled['natures_laboratory_productionID'])); ?>" class="button button-small action-success"><?php echo 'Go'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php
	}
	