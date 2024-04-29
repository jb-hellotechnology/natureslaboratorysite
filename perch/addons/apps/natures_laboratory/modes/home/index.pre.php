<?php
    
    $HTML = $API->get('HTML');
    
    $NaturesLaboratoryStaff = new Natures_Laboratory_Staff_Members($API);  
    
    $HTML = $API->get('HTML');
    
    $staff = array();
    $staff = $NaturesLaboratoryStaff->signedIn();