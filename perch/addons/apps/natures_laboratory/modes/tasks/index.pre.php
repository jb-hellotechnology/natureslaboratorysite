<?php
/*
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
*/   
    if (!$CurrentUser->has_priv('natures_laboratory.goodsin')) exit;
    
    $NaturesLaboratoryTasks = new Natures_Laboratory_Tasks($API); 
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $tasks = array();
    $tasks = $NaturesLaboratoryTasks->getTasks($_GET['q']);