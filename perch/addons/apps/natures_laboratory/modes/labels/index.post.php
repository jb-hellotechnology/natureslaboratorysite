 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Labels',
    'button'  => [
            'text' => $Lang->get('Labels'),
            'link' => $API->app_nav().'/labels/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);
    
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Labels',
	    'link'  => $API->app_nav().'/labels/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Products',
	    'link'  => $API->app_nav().'/labels/products/',
	]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    echo $Form->form_start();
    ?>

    <table class="d">
        <thead>
            <tr>
	            <th class="first">Select</th>
                <th>Batch</th>
                <th>Product Code</th> 
                <th>Product Description</th>  
                <th>Size</th>
                <th>BBE</th>
                <th>Quantity</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($labels as $Label) {
	    $product = $NaturesLaboratoryLabels->getProduct($Label['productCode']);
	    $dates = explode("-",$Label['bbe']);
	    $bbe = "$dates[1]/$dates[0]";
?>
            <tr>
	            <td><?php echo $Form->checkbox("batch_".$Label['natures_laboratory_labelID'],'on',''); ?></td>
                <td><?php echo $Label['batch'] ?></td>
                <td><?php echo $Label['productCode']; ?></td>
                <td><?php echo $product['productName']; ?></td>
                <td><?php echo $Label['size']; ?></td>
                <td><?php echo $bbe ?></td>
                <td><?php echo $Label['quantity']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/labels/delete/?id=<?php echo $HTML->encode(urlencode($Label['natures_laboratory_labelID'])); ?>" class="button button-small action-alert"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    
	
	$taskList[] = array('label'=>'Generate Labels', 'value'=>'labels');
	$taskList[] = array('label'=>'Delete', 'value'=>'delete');
	echo $Form->select_field("task","Task",$taskList,'');
		
	echo $Form->submit_field('btnSubmit', 'Process', $API->app_path());	
	echo $Form->form_end();
    echo $HTML->main_panel_end();