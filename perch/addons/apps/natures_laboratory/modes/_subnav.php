<?php

	// Define subnav links and titles
	
	PerchUI::set_subnav([
		[
            'page' => [
            	'natures_laboratory'
            ],
            'label'=> 'Dashboard'
        ],
        [
            'page' => [
            	'natures_laboratory/staff',
            	'natures_laboratory/staff/add',
            	'natures_laboratory/staff/edit',
            	'natures_laboratory/staff/delete',
            	'natures_laboratory/staff/hours',
            	'natures_laboratory/staff/holidays',
            	'natures_laboratory/staff/holidays/add',
            	'natures_laboratory/staff/holidays/delete',
            	'natures_laboratory/staff/bank-holidays',
            	'natures_laboratory/staff/early-finishes',
            	'natures_laboratory/staff/sick-days',
            	'natures_laboratory/staff/sick-days/delete',
            	'natures_laboratory/staff/compassionate-leave',
            	'natures_laboratory/staff/compassionate-leave/delete',
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
            'page' => [
            	'natures_laboratory/labels',
            	'natures_laboratory/labels/add',
            	'natures_laboratory/labels/delete',
            	'natures_laboratory/labels/products',
            	'natures_laboratory/labels/products/add',
            	'natures_laboratory/labels/products/edit',
            	'natures_laboratory/labels/products/delete',
            ],
            'label'=> 'Labels'
        ],
        [
            'page' => [
            	'natures_laboratory/coa',
            	'natures_laboratory/coa/add',
            	'natures_laboratory/coa/edit',
            	'natures_laboratory/coa/delete',
            	'natures_laboratory/coa/spec',
            	'natures_laboratory/coa/spec/add',
            	'natures_laboratory/coa/spec/edit',
            	'natures_laboratory/coa/spec/delete',
            	'natures_laboratory/coa/countries',
            	'natures_laboratory/coa/countries/add',
            	'natures_laboratory/coa/countries/edit',
            	'natures_laboratory/coa/countries/delete',
            ],
            'label'=> 'COA - Herbs'
        ],
        [
            'page' => [
            	'natures_laboratory/coa-capsules',
            	'natures_laboratory/coa-capsules/add',
            	'natures_laboratory/coa-capsules/edit',
            	'natures_laboratory/coa-capsules/delete',
            	'natures_laboratory/coa-capsules/spec',
            	'natures_laboratory/coa-capsules/spec/add',
            	'natures_laboratory/coa-capsules/spec/edit',
            	'natures_laboratory/coa-capsules/spec/delete',
            	'natures_laboratory/coa-capsules/countries',
            	'natures_laboratory/coa-capsules/countries/add',
            	'natures_laboratory/coa-capsules/countries/edit',
            	'natures_laboratory/coa-capsules/countries/delete',
            ],
            'label'=> 'COA - Capsules'
        ],
        [
            'page' => [
            	'natures_laboratory/coa-products',
            	'natures_laboratory/coa-products/add',
            	'natures_laboratory/coa-products/edit',
            	'natures_laboratory/coa-products/delete',
            	'natures_laboratory/coa-products/spec',
            	'natures_laboratory/coa-products/spec/add',
            	'natures_laboratory/coa-products/spec/edit',
            	'natures_laboratory/coa-products/spec/delete',
            	'natures_laboratory/coa-products/countries',
            	'natures_laboratory/coa-products/countries/add',
            	'natures_laboratory/coa-products/countries/edit',
            	'natures_laboratory/coa-products/countries/delete',
            ],
            'label'=> 'COA - Products'
        ],
        [
            'page' => [
            	'natures_laboratory/coa-oils',
            	'natures_laboratory/coa-oils/add',
            	'natures_laboratory/coa-oils/edit',
            	'natures_laboratory/coa-oils/delete',
            	'natures_laboratory/coa-oils/spec',
            	'natures_laboratory/coa-oils/spec/add',
            	'natures_laboratory/coa-oils/spec/edit',
            	'natures_laboratory/coa-oils/spec/delete',
            	'natures_laboratory/coa-oils/countries',
            	'natures_laboratory/coa-oils/countries/add',
            	'natures_laboratory/coa-oils/countries/edit',
            	'natures_laboratory/coa-oils/countries/delete',
            ],
            'label'=> 'COA - Oils'
        ],
        [
            'page' => [
            	'natures_laboratory/msds',
            	'natures_laboratory/msds/add',
            	'natures_laboratory/msds/edit',
            	'natures_laboratory/msds/delete',
            	'natures_laboratory/msds/templates',
            	'natures_laboratory/msds/templates/edit',
            	'natures_laboratory/msds/cas',
            	'natures_laboratory/msds/cas/add',
            	'natures_laboratory/msds/cas/edit'
            ],
            'label'=> 'MSDS'
        ],
        [
            'page' => [
            	'natures_laboratory/production',
            	'natures_laboratory/production/schedule',
            	'natures_laboratory/production/scheduled',
            	'natures_laboratory/production/in-production',
            	'natures_laboratory/production/complete',
            	'natures_laboratory/production/completed',
            ],
            'label'=> 'Production'
        ],
/*
        [
            'page' => 'natures_laboratory/catalogue',
            'label'=> 'Catalogue'
        ],
        [
            'page' => 'natures_laboratory/spreadsheet',
            'label'=> 'Spreadsheet'
        ],
*/
        [
            'page' => 'natures_laboratory/stock-update',
            'label'=> 'Stock Management'
        ],
        [
            'page' => [
            	'natures_laboratory/nonconformance',
            	'natures_laboratory/nonconformance/add',
            	'natures_laboratory/nonconformance/edit',
            	'natures_laboratory/nonconformance/delete',
            	'natures_laboratory/nonconformance/report',
            ],
            'label'=> 'Non Conformance'
        ],
        [
            'page' => [
            	'natures_laboratory/tasks',
            	'natures_laboratory/tasks/add',
            	'natures_laboratory/tasks/edit',
            	'natures_laboratory/tasks/delete',
            ],
            'label'=> 'Tasks'
        ],
/*
        [
            'page' => 'natures_laboratory/orders',
            'label'=> 'Orders'
        ]
*/
    ], $CurrentUser);
