 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Goods In',
    'button'  => [
            'text' => $Lang->get('Goods In'),
            'link' => $API->app_nav().'/goods-in/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Goods In',
	    'link'  => $API->app_nav().'/goods-in/',
	]);
	
/*
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Stock',
	    'link'  => $API->app_nav().'/goods-in/stock/',
	]);
*/
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Suppliers',
	    'link'  => $API->app_nav().'/goods-in/suppliers/',
	]);
	
	$Smartbar->add_item([
        'active' => false,
        'type'   => 'search',
        'data'   => [
            'search' => 'goods',
        ],
        'title'  => 'Search',
        'arg'    => 'q',
        'icon'   => 'core/search',
        'position' => 'end',
    ]);
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if($message){
	    echo $message;
    }else{
    
    echo $Form->form_start();
    ?>

    <table class="d">
        <thead>
            <tr>
	            <th class="first">Select</th>
                <th>Staff</th>
                <th>Product Code</th> 
                <th>Product Description</th>  
                <th>Date In</th>
                <th>Supplier</th>
                <th>Quantity</th>
                <th>Supplier's Batch</th>
                <th>Country</th>
                <th>Our Batch</th>
                <th>BBE</th>
                <th>QA Check</th>
                <th>COA</th>
                <th>Edit</th>
                <th class="action last">Delete</th>
            </tr>
        </thead>
        <tbody>
<?php
    foreach($goodsIn as $Goods) {
	    
	    $COA = $NaturesLaboratoryGoodsIn->coaExists($Goods['ourBatch']);
	    //$DESCRIPTION = $NaturesLaboratoryGoodsIn->getDescription($Goods['productCode']);

?>
            <tr>
	            <td><?php echo $Form->checkbox("batch_".$Goods['ourBatch'],'on',''); ?></td>
                <td><?php echo $Goods['staff'] ?></td>
                <td><?php echo $Goods['productCode']; ?></td>
                <td><?php echo $Goods['DESCRIPTION']; echo $Goods['productDescription']; ?></td>
                <td><?php 
	                $parts = explode("-", $Goods['dateIn']);
		            echo "$parts[2]/$parts[1]/$parts[0]";
	                ?>
	            </td>
                <td>
	                <?php
		                if($Goods['supplier']){
			                $Supplier = $NaturesLaboratoryGoodsSuppliers->find($Goods['supplier'], true);
			                if($Supplier){
								echo $Supplier->name();
							}
		                }
		            ?>
	            </td>
                <td><?php echo $Goods['qty']; ?></td>
                <td><?php echo $Goods['suppliersBatch']; ?></td>
                <td><?php echo $Goods['countryOfOrigin']; ?></td>
                <td><?php echo $Goods['ourBatch']; ?></td>
                <td><?php 
	                if($Goods['bbe']<>'1970-01-01'){
		                $parts = explode("-", $Goods['bbe']);
		                echo "$parts[2]/$parts[1]/$parts[0]";
	                }
	                ?>
	            </td>
                <td>
	                <span<?php if($Goods['qa']=='FALSE'){echo " class='notification notification-warning'";}elseif($Goods['qa']=='NOT REQUIRED'){echo " class='notification notification-success'";}elseif($Goods['qa']=='TRUE'){echo " class='notification notification-success'";}?>>
	                	<?php 
		                	if($Goods['qa']=='TRUE'){
			                	echo 'COMPLETE';
			                }else{
				                echo 'INCOMPLETE';
				            } 
				        ?>
	                </span>
	            </td>
                <td>
	                <?php
		                if($Goods['noCOA']==TRUE){
			                echo '<span class="notification notification-success">NOT REQUIRED</span>';
		                }else{
			                if($COA=='TRUE'){
				                echo '<span class="notification notification-success">COMPLETE</span>';
			                }else{
				                echo '<span class="notification notification-alert">INCOMPLETE</span>';
			                }
			            }
	                ?>
	            </td>
                <td><a class="button button-small action-info" href="<?php echo $HTML->encode($API->app_path()); ?>/goods-in/edit/?id=<?php echo $HTML->encode(urlencode($Goods['natures_laboratory_goods_inID'])); ?>" class="button button-small action-info"><?php echo 'Edit'; ?></a></td>
                <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/goods-in/delete/?id=<?php echo $HTML->encode(urlencode($Goods['natures_laboratory_goods_inID'])); ?>" class="button button-small action-alert"><?php echo 'Delete'; ?></a></td>
            </tr>
<?php
	}
?>
	    </tbody>
    </table>
<style>
	span{
	width:auto !important;
	display:block !important;
	text-align: center !important;
}</style>
<?php    
	echo $Form->submit_field('btnSubmit', 'Generate Labels', $API->app_path());	
	echo $Form->form_end();
	}
    echo $HTML->main_panel_end();