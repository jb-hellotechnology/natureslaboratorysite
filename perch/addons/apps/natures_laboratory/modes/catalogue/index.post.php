 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Shopify',
    ], $CurrentUser);

    echo $HTML->main_panel_start();
    
    
    echo $HTML->main_panel_end();