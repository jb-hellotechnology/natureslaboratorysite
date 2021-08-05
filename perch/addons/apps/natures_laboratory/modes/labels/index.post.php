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
	            <td><?php echo $Form->checkbox("batch_".$Labels['batch'],'on',''); ?></td>
                <td><?php echo $Label['batch'] ?></td>
                <td><?php echo $Label['productCode']; ?></td>
                <td><?php echo $product['productName']; ?></td>
                <td><?php echo $Label['size']; ?></td>
                <td><?php echo $bbe ?></td>
                <td><?php echo $Label['quantity']; ?></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/labels/delete/?id=<?php echo $HTML->encode(urlencode($Label['natures_laboratory_labelID'])); ?>" class="delete inline-delete"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>

<?php    
	echo $Form->submit_field('btnSubmit', 'Generate Labels', $API->app_path());	
	echo $Form->form_end();
    echo $HTML->main_panel_end();