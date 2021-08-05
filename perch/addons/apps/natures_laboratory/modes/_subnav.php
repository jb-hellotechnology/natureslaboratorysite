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
            'page' => 'natures_laboratory/goods-in',
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
            'page' => 'natures_laboratory/coa-products',
            'label'=> 'COA - Products'
        ],
        [
            'page' => 'natures_laboratory/task-management',
            'label'=> 'Task Management'
        ],
    ], $CurrentUser);
