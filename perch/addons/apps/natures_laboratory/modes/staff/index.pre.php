<?php
    
    if (!$CurrentUser->has_priv('natures_laboratory.staff')) exit;
    
    $NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API);  
    
    $HTML = $API->get('HTML');
    
    $staff = array();
    $staff = $NaturesLaboratoryStaff->all();