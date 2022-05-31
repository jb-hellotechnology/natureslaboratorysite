<?php	

echo $HTML->title_panel([
'heading' => $SupplierData['NAME'],
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
    'active' => false,
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
    'active' => true,
    'title' => 'Supplier Questionnaire',
    'link'  => $API->app_nav().'/suppliers/manage/questionnaire/?id='.$_GET['id'],
]);

echo $Smartbar->render();

echo $HTML->main_panel_start();

if(count($questionnaires)>0 AND !$_GET['questionnaire']){
	
?>

<h2>Completed Questionnaires</h2>

<table class="d">
    <thead>
        <tr>
            <th class="first">Date Completed</th>
            <th class="action last">View</th>
        </tr>
    </thead>
    <tbody>
<?php
    foreach($questionnaires as $Questionnaire) {
?>
	    <tr>
	        <td><?php echo $Questionnaire['timestamp']; ?></td>
	        <td><a href="<?php echo $HTML->encode($API->app_path()); ?>/suppliers/manage/questionnaire/?id=<?= $_GET['id'] ?>&questionnaire=<?php echo $HTML->encode(urlencode($Questionnaire['questionnaireID'])); ?>" class="button button-small">View</a></td>
	    </tr>
<?php
	}
?>
    </tbody>
</table>

<?php

}elseif($_GET['questionnaire']){

	echo "<h2>Questionnaire Answers</h2>";

	echo '<table class="d">
    <thead>
        <tr>
            <th class="first">Question</th>
            <th class="last">Answers</th>
        </tr>
    </thead>
    <tbody>
    <tr><td>Date Of Completion</td><td>'.$questionnaire['timestamp']."</td></tr>";
	
	$answers = json_decode($questionnaire['answers'],true);
	foreach($answers as $key => $value){
		echo '<tr><td>'.ucwords(str_replace("_", " ",$key)).'?</td><td>'.$value.'</td></tr>';
	}
	
	echo '</tbody></table>';
	
}else{
	echo $HTML->warning_message('Sorry, no questionnaires');	
}

?>

<br /><p><a class="button button button-simple" href="mailto:<?= $SupplierData['E_MAIL'] ?>?subject=Please Complete Supplier Questionnaire&body=Dear <?= $SupplierData['CONTACT_NAME'] ?>%0D%0A%0D%0AAs part of our yearly audit of suppliers we require the following questionnaire to be completed:%0D%0A%0D%0Ahttps://natureslaboratory.co.uk/supplier/?id=<?= $SupplierData['ACCOUNT_REF'] ?>%0D%0A%0D%0AIf you need to supply any supporting documentation please email the files to me directly. Or, if the documentation can be accessed via your website, please let me know where I can find the the documentation online.%0D%0A%0D%0AMany thanks for your help in this matter,%0D%0A%0D%0AShankar Katekhaye%0D%0A%0D%0AQuality Manager%0D%0ANature's Laboratory Ltd%0D%0A%0D%0AUnit 3B, Enterprise Way, Whitby, North Yorkshire, YO22 4HN%0D%0A%0D%0AThis email and any attachments to it may be confidential and are intended solely for the use of the individual to whom it is addressed. Any views or opinions expressed are solely those of the author and do not necessarily represent those of Nature’s Laboratory Limited. If you are notthe intended recipient of this email, you must neither take any action based upon its contents, nor copy or show it to anyone. Please contact the sender if you believe you have received this email in error.">Request Questionnaire Completion</a></p>

<?php

echo $HTML->main_panel_end();

?>