<?php

	// Define subnav links and titles
	
	PerchUI::set_subnav([
/*
        [
            'page' => [
            	'factory_management/staff',
            	'factory_management/staff/add',
            	'factory_management/staff/edit',
            	'factory_management/staff/delete',
            ],
            'label'=> 'Staff'
        ],
*/
        [
            'page' => [
            	'factory_management/suppliers',
            	'factory_management/suppliers/edit'
            ],
            'label'=> 'Suppliers'
        ],
        [
            'page' => [
            	'factory_management/goods-in'
            ],
            'label'=> 'Goods In'
        ],
/*
        [
            'page' => [
            	'factory_management/production'
            ],
            'label'=> 'Production'
        ],
        [
            'page' => [
            	'factory_management/goods-out'
            ],
            'label'=> 'Goods Out'
        ],
        [
            'page' => [
            	'factory_management/dispatch'
            ],
            'label'=> 'Dispatch'
        ],
*/
    ], $CurrentUser);
