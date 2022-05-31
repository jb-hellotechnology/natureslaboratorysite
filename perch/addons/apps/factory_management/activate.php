<?php

	include('../../../core/inc/api.php');
	
	$API = new PerchAPI(1.0, 'factory_management');
	
	$UserPrivileges = $API->get('UserPrivileges');
    $UserPrivileges->create_privilege('factory_management', 'Access Factory Management');
    $UserPrivileges->create_privilege('factory_management.suppliers', 'Access Suppliers');
    $UserPrivileges->create_privilege('factory_management.staff', 'Access Staff');
    $UserPrivileges->create_privilege('factory_management.goodsin', 'Access Goods In');
    $UserPrivileges->create_privilege('factory_management.production', 'Access Production');
    $UserPrivileges->create_privilege('factory_management.goodsout', 'Access Goods Out');
    $UserPrivileges->create_privilege('factory_management.dispatch', 'Access Dispatch');
    