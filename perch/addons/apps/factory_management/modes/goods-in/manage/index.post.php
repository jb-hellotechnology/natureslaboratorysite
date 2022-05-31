<?php	

echo $HTML->title_panel([
'heading' => 'Goods In'
], $CurrentUser);

$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => false,
    'title' => '&larr; Goods In',
    'link'  => $API->app_nav().'/goods-in/',
]);

$Smartbar->add_item([
    'active' => true,
    'title' => 'Manage',
    'link'  => $API->app_nav().'/goods-in/manage/?id='.$_GET['id'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'Labels',
    'link'  => $API->app_nav().'/goods-in/manage/labels/?id='.$_GET['id'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'Sage Update',
    'link'  => $API->app_nav().'/goods-in/manage/sage/?id='.$_GET['id'],
]);

echo $Smartbar->render();

echo $HTML->main_panel_start();

?>	
<?php
if (isset($message)){ 
    echo $message;   
    echo "<br />";
}

if(!$_GET['item']){
?>

<h2>Purchase Order</h2>

<table class="d">
    <thead>
        <tr>
            <th class="first">Key</th>
            <th class="last">Value</th>
        </tr>
    </thead>
    <tbody>
	    <tr>
		    <td>Order Number</td><td><?php echo $po['ORDER_NUMBER']; ?></td>
	    </tr>
	    <tr>
		    <td>Order Date</td><td><?php echo $po['ORDER_DATE']; ?></td>
	    </tr>
	    <tr>
		    <td>Delivery Date</td><td><?php echo $po['DELIVERY_DATE']; ?></td>
		</tr>
		<tr>
		    <td>Order Status</td><td><?php echo $po['ORDER_STATUS']; ?></td>
		</tr>
		<tr>
		    <td>Delivery Status</td><td><?php echo $po['DELIVERY_STATUS']; ?></td>
		</tr>
		<tr>
		    <td>Taken By</td><td><?php echo $po['TAKEN_BY']; ?></td>
		</tr>
		<tr>
		    <td>Gross Value</td><td>&pound;<?php echo $po['ITEMS_GROSS']; ?></td>
		</tr>
    </tbody>
</table>

<h2>Items</h2>

<?php
	echo $Form->form_start();
?>

<table class="d">
    <thead>
        <tr>
            <th class="first">Description</th>
            <th>SKU</th>
            <th>Status</th>
            <th>QTY Ordered</th>
            <th>QTY Delivered</th>
            <th>QA Pass</th>
            <th>2nd Check</th>
            <th>No COA Required</th>
            <th class="last">COA</th>
        </tr>
    </thead>
    <tbody>
<?php
	
	$poData = $FactoryManagementSuppliersPOData->po($_GET['id']);
	$poData = json_decode($poData['QAC'],true);
	
	$QAC = json_decode($details['QAC'],true);
	$i = 0;
    foreach($posItems as $POITEM) {

	    if($QAC['QA_'.$i]==1){
		    $qValue = 1;
	    }else{
	    	$qValue = false;
	    }
	    
	    if($QAC['C_'.$i]==1){
		    $cValue = 1;
	    }else{
	    	$cValue = false;
	    }
	    
	    if($QAC['COA_'.$i]==1){
		    $coaValue = 1;
	    }else{
	    	$coaValue = false;
	    }
	    
	    $goodsInCheck = false;
	    $qaCheckDisabled = false;
	    $cCheckDisabled = false;
	    
	    $goodsInCheckData = $FactoryManagementGoodsIn->getGoodsIn($_GET['id'],$POITEM['ITEM_NUMBER']);
	    
	    if($goodsInCheckData){
		
			if($goodsInCheckData AND ($goodsInCheckData->staff()==$_SESSION['userID']) OR ($QAC['QA_'.$i]==1 AND $QAC['Staff_QA_'.$i]!==$_SESSION['userID'])){
				$qaCheckDisabled = true;
			}
	
			if($goodsInCheckData->staff()==$_SESSION['userID'] OR $QAC['Staff_QA_'.$i]==$_SESSION['userID']){
				$cCheckDisabled = true;
			}
		
		}else{
			
			$qaCheckDisabled = true;
			$cCheckDisabled = true;
	    
		}
		
?>
	    <tr>
	        <td><a class="primary" href="/perch/addons/apps/factory_management/goods-in/manage/?id=<?= $_GET['id'] ?>&item=<?= $POITEM['ITEM_NUMBER']+1 ?>"><?php echo $POITEM['DESCRIPTION'] ?></a></td>
	        <td><?php echo $POITEM['STOCK_CODE'] ?></td>
	        <td><?php 
		        if($goodsInCheckData){
			        echo '<p class="notification notification-success">Booked In</p>';
			    }else{
				    echo '<p class="notification notification-warning">Awaiting Booking In</p>';
				}
				?>
			</td>
	        <td><?php echo $POITEM['QTY_ORDER']; ?></td>
	        <td><?php echo $POITEM['QTY_DELIVERED']; ?></td>
	        <td><?php 
		        if($qaCheckDisabled){
			        echo $Form->checkbox_field('QA_'.$POITEM['ITEM_NUMBER'],"","1",$qValue,'disabled');
			        $userID = $QAC['Staff_QA_'.$i];
			    }else{
				    echo $Form->checkbox_field('QA_'.$POITEM['ITEM_NUMBER'],"","1",$qValue);
				    $userID = $_SESSION['userID'];
				} 
				echo $Form->hidden('Staff_QA_'.$POITEM['ITEM_NUMBER'],$userID);
				?>
			</td>
	        <td><?php 
		        if($cCheckDisabled OR !$QAC['QA_'.$i]){
			        echo $Form->checkbox_field('C_'.$POITEM['ITEM_NUMBER'],"","1",$cValue,'disabled'); 
			        $userID = $QAC['Staff_C_'.$i];
			    }else{
				    echo $Form->checkbox_field('C_'.$POITEM['ITEM_NUMBER'],"","1",$cValue);
				    $userID = $_SESSION['userID'];
				}
				echo $Form->hidden('Staff_C_'.$POITEM['ITEM_NUMBER'],$userID);
			    ?>
			</td>
	        <td><?php echo $Form->checkbox_field('COA_'.$POITEM['ITEM_NUMBER'],"","1",$coaValue); ?></td>
	        <td><?php
		        if($coaExists){
			        echo '<a class="button button-small" href="">Edit COA</a>';
			    }else{
				    echo '<a class="button button-small" href="">Create COA</a>';
				}
				?>
			</td>
	    </tr>
<?php
		$i++;
	}
?>
    </tbody>
</table>

<style>
	.field-wrap.checkbox-single{
		padding:0;
		margin:0;
	}
	.field-wrap.checkbox-single label{
		display:none;
	}
	.form-simple .field-wrap:last-of-type{
		padding-bottom:0;
		margin-bottom:0;
	}
	.check.disabled,.button.disabled{
		pointer-events: none;
		opacity:0.3;
	}
	td p.notification{
		margin:0;
		padding:10px 10px;
	}
</style>

<h2>Notes &amp; Files</h2>

<?php	
		
	$details = json_decode($details['poDynamicFields'],true);

	$details['notes'] = $details['notes']['processed'];
	echo $Form->fields_from_template($Template, $details, $FactoryManagementSuppliersData->static_fields);
	    
	echo $Form->submit_field('btnSubmit', 'Update', $API->app_path());
	
	echo $Form->form_end();
	
}else{

	if($goodsInData){
		if($goodsInData->staff()!==NULL AND $goodsInData->staff()!==$_SESSION['userID']){
			echo $HTML->warning_message('You did not book this item in, any changes you make will not be saved')."<br />";
		}
	}

?>

	<h2><?= $itemData['DESCRIPTION'] ?> | <?= $itemData['STOCK_CODE'] ?> | <?= $po['NAME'] ?></h2>	
	
<?php
	
	echo $Form->form_start();
	
	if($goodsInData){
		$goodsInData = $goodsInData->to_array();
	}
	
	$countryList[] = array('label'=>'Please Select', 'value'=>0);
	foreach($countries as $Country){
		$countryList[] = array('label'=>$Country->country(), 'value'=>$Country->country());
	}
	echo $Form->select_field("countryOfOrigin","Country Of Origin",$countryList,$goodsInData['countryOfOrigin']);
	
	echo $Form->text_field("qty","Total Quantity",$goodsInData['qty']);
	
	$units[] = array('label'=>"KG", 'value'=>'KG');
	$units[] = array('label'=>"G", 'value'=>'G');
	$units[] = array('label'=>"L", 'value'=>'L');
	$units[] = array('label'=>"ML", 'value'=>'ML');
	$units[] = array('label'=>"1000 CAPSULES", 'value'=>'1000 CAPSULES');
	echo $Form->select_field('unit','Unit',$units,$goodsInData['unit']);
	
	echo $Form->fields_from_template($Template, $goodsInData, $FactoryManagementGoodsIn->static_fields);
	
	echo $Form->text_field("suppliersBatch","Supplier's Batch",$goodsInData['suppliersBatch']);
	
	echo $Form->date_field("bbe","BBE",$goodsInData['bbe']);
	echo $Form->checkbox_field("noBBE","No BBE",'1',$goodsInData['noBBE']);

	echo $Form->submit_field('btnSubmit', 'Submit', $API->app_path());
	
	echo $Form->hidden('po',$_GET['id']);
	echo $Form->hidden('poItem',$_GET['item']-1);
	echo $Form->hidden('dateIn', date('Y-m-d'));
	if($goodsInData['staff']){
		echo $Form->hidden('staff',$goodsInData['staff']);
	}else{
		echo $Form->hidden('staff',$_SESSION['userID']);
	}
	
	echo $Form->form_end();
	
	$goodsInData = $FactoryManagementGoodsIn->getGoodsIn($_GET['id'],$_get['item']);
	
}

?>

<style>
	.check.disabled,.button.disabled{
		pointer-events: none;
		opacity:0.3;
	}
</style>

<?php
	
echo $HTML->main_panel_end();

?>