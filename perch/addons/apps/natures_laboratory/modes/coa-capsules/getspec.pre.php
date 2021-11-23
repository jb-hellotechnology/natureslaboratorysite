<?php
    
    $NaturesLaboratoryCOASpec = new Natures_Laboratory_COA_Products_Specs($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $coa = array();
    $coa = $NaturesLaboratoryCOASpec->getSpec($_POST['code']);

    echo $coa;