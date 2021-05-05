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
            'page' => 'natures_laboratory/website_traffic',
            'label'=> 'Website Traffic'
        ],
        [
            'page' => 'natures_laboratory/sales',
            'label'=> 'Sales'
        ],
        [
            'page' => 'natures_laboratory/manufacturing',
            'label'=> 'Manufacturing'
        ],
        [
            'page' => 'natures_laboratory/dispatch',
            'label'=> 'Dispatch'
        ]
    ], $CurrentUser);
