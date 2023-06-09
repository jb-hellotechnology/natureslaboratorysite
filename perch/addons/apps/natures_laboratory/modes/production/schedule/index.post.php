 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Production',
    'button'  => [
            'text' => $Lang->get('Production'),
            'link' => $API->app_nav().'/production/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
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
	    'active' => false,
	    'title' => 'Completed',
	    'link'  => $API->app_nav().'/production/completed/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if (isset($message)){ 
	    
	    echo $message;
	    
	}else{
		
		echo $Form->form_start();
		
		$product = $NaturesLaboratoryProduction->getProduct($_GET['id']);
		echo '<h2>'.$_GET['id'].' - '.$product['DESCRIPTION'].'</h2>';
		
		echo '<br /><p>Ingredients</p>
		
		<table class="d">
        <thead>
            <tr>
	            <th class="first">#</th>
	            <th>SKU</th>
                <th>Qty in Stock</th>
                <th>Qty Required/Unit</th> 
            </tr>
        </thead>
        <tbody>';
		
		$i = 1;
		$units = 100000000;
		while($i<=50){
			$iQty = $NaturesLaboratoryProduction->getIngredient($_GET['id'],$i);
			if($iQty){
				echo '<tr>
						<td>'.$i.'</td>
						<td>'.$iQty['STOCK_CODE'].'</td>
						<td>'.$iQty['QTY_IN_STOCK'].'</td>
						<td>'.$product['COMPONENT_QTY_'.$i].'</td>
					</tr>';
				if($iQty['QTY_IN_STOCK']>0){
					$maxUnits = floor((float)$iQty['QTY_IN_STOCK']/(float)$product['COMPONENT_QTY_'.$i]);
					if($maxUnits<$units){
						$units = $maxUnits;
					}
				}
				$i++;
			}else{
				break;
			}
		}
		
		echo '</tbody>
		</table>';
		
		echo "<br /><p>How Much Do You Want To Make?</p>";
		
		echo $Form->hidden("sku",$_GET['id']);
		
		echo $Form->text_field("units","Units",$units);
		
		echo "<br /><p>Additional Requirements</p>";
		
		echo $Form->text_field("specification","Specification",'');
		echo $Form->text_field("packaging","Packaging Requirements",'');
		echo $Form->text_field("labelling","Labelling Requirements",'');
		
		echo "<br /><p>Other</p>";
		
		$names[] = array('label'=>'Please Select', 'value'=>'');
		$names[] = array('label'=>'Andy', 'value'=>'Andy');
		$names[] = array('label'=>'Sean', 'value'=>'Sean');
		$names[] = array('label'=>'Tom', 'value'=>'Tom');
		echo $Form->select_field("scheduledBy","Scheduled By",$names,'');
		
		echo $Form->hidden("status",'scheduled');
		    
		echo $Form->submit_field('btnSubmit', 'Schedule', $API->app_path());
		
		echo $Form->form_end();
	
	}

    echo $HTML->main_panel_end();