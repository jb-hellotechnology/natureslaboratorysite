<?php	

echo $HTML->title_panel([
'heading' => $SupplierData['NAME']
], $CurrentUser);

$Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

$Smartbar->add_item([
    'active' => false,
    'title' => '&larr; Suppliers',
    'link'  => $API->app_nav().'/suppliers/',
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'Manage',
    'link'  => $API->app_nav().'/suppliers/manage/?id='.$_GET['id'],
]);

$Smartbar->add_item([
    'active' => true,
    'title' => 'COA',
    'link'  => $API->app_nav().'/suppliers/manage/coa/?id='.$_GET['id'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'PO',
    'link'  => $API->app_nav().'/suppliers/manage/po/?id='.$_GET['id'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'Contracts',
    'link'  => $API->app_nav().'/suppliers/manage/contracts/?id='.$_GET['id'],
]);

$Smartbar->add_item([
    'active' => false,
    'title' => 'Supplier Questionnaire',
    'link'  => $API->app_nav().'/suppliers/manage/questionnaire/?id='.$_GET['id'],
]);

echo $Smartbar->render();

echo $HTML->main_panel_start();

echo "<h2>Awaiting Goods In COA Completion</h2>";

echo $HTML->main_panel_end();

?>