<?php

	// Define subnav links and titles
	
	PerchUI::set_subnav([
        [
            'page' => [
            	'natures_laboratory/staff',
            	'natures_laboratory/staff/add',
            	'natures_laboratory/staff/edit',
            	'natures_laboratory/staff/delete',
            ],
            'label'=> 'Staff'
        ],
        [
            'page' => [
            	'natures_laboratory/goods-in',
            	'natures_laboratory/goods-in/add',
            	'natures_laboratory/goods-in/edit',
            	'natures_laboratory/goods-in/delete',
            	'natures_laboratory/goods-in/suppliers',
            	'natures_laboratory/goods-in/suppliers/add',
            	'natures_laboratory/goods-in/suppliers/edit',
            	'natures_laboratory/goods-in/suppliers/delete',
            ],
            'label'=> 'Goods In'
        ],
        [
            'page' => 'natures_laboratory/labels',
            'label'=> 'Labels'
        ],
        [
            'page' => 'natures_laboratory/coa',
            'label'=> 'COA - Herbs'
        ],
        [
            'page' => 'natures_laboratory/coa-capsules',
            'label'=> 'COA - Capsules'
        ],
        [
            'page' => 'natures_laboratory/coa-products',
            'label'=> 'COA - Products'
        ],
        [
            'page' => 'natures_laboratory/msds',
            'label'=> 'MSDS'
        ],
        [
            'page' => 'natures_laboratory/production',
            'label'=> 'Production'
        ],
/*
        [
            'page' => 'natures_laboratory/shopify',
            'label'=> 'Shopify'
        ],
*/
        [
            'page' => 'natures_laboratory/catalogue',
            'label'=> 'Catalogue'
        ],
        [
            'page' => 'natures_laboratory/spreadsheet',
            'label'=> 'Spreadsheet'
        ],
/*
        [
            'page' => 'natures_laboratory/sage',
            'label'=> 'Sage Import'
        ],
*/
        [
            'page' => 'natures_laboratory/stock-update',
            'label'=> 'Herbal Apothecary Stock Update'
        ],
        [
            'page' => 'natures_laboratory/beevital-stock-update',
            'label'=> 'BeeVital Stock Update'
        ],
    ], $CurrentUser);
