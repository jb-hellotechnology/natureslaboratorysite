<?php
    
    $NaturesLaboratoryCOA = new Natures_Laboratory_COAs($API);
    
    $HTML = $API->get('HTML');
    $Form = $API->get('Form');
    
    $coa = array();
    $coa = $NaturesLaboratoryCOA->getCOAs();