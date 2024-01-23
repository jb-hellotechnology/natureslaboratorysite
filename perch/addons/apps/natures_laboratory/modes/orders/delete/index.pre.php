<?php
	
	if (!$CurrentUser->has_priv('natures_laboratory.labels')) exit;
	
	$NaturesLaboratoryOrders = new Natures_Laboratory_Orders($API);    
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $Order = array();

    if($Form->submitted()) {
    
        $orderID = (int) $_GET['id'];  
		$Order = $NaturesLaboratoryOrders->find($orderID, true);
		
		$Order->delete();
		$deleted = true;
		
		$message = $HTML->success_message('Order has been successfully deleted. Return to %sOrders%s', '<a href="'.$API->app_path().'/orders/">', '</a>'); 
        
    }else{
	    $deleted = false;
	    $message = $HTML->warning_message('Are you sure you want to delete this order?', '', ''); 
    }