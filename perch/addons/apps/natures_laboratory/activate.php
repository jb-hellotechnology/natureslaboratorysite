<?php

	include('../../../core/inc/api.php');
	
	$API = new PerchAPI(1.0, 'natures_laboratory');
	
	$UserPrivileges = $API->get('UserPrivileges');
    $UserPrivileges->create_privilege('natures_laboratory', 'Access Nature\'s Laboratory');
    $UserPrivileges->create_privilege('natures_laboratory.staff', 'Access Staff');
    $UserPrivileges->create_privilege('natures_laboratory.goodsin', 'Access Goods In');
    $UserPrivileges->create_privilege('natures_laboratory.coa', 'Access COA');
    