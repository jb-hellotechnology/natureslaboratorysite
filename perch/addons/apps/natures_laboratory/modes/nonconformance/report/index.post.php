 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Non Conformance > Report',
    'button'  => [
            'text' => $Lang->get('Non Conformance'),
            'link' => $API->app_nav().'/nonconformance/add',
            'icon' => 'core/plus',
        ],
    ], $CurrentUser);

    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

		
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Non Conformance',
	    'link'  => $API->app_nav().'/nonconformance/',
	]);
	
	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Report',
	    'link'  => $API->app_nav().'/report/',
	]);
	
	
	echo $Smartbar->render();

    echo $HTML->main_panel_start(); 

?>
	<table class="d">
        <thead>
            <tr>
                <th class="first">Month</th>
                <th>Customer</th>
                <th>Supplier</th>
                <th>Internal</th>
	            <th>Deviation</th>
            </tr>
        </thead>
        <tbody>
<?php
	$max = 23;
	$i = 0;
    while($i<24) {
	    
	    $date = date("Y-m", mktime(0, 0, 0, date('m')-$i, 1, date('Y')));
	    $date2 = date("m/Y", mktime(0, 0, 0, date('m')-$i, 1, date('Y')));
		
		echo "
		<tr>
			<td>".$date2."</td>
			<td>".$NaturesLaboratoryNonconformances->getCount($date, 'Customer')."</td>
			<td>".$NaturesLaboratoryNonconformances->getCount($date, 'Supplier')."</td>
			<td>".$NaturesLaboratoryNonconformances->getCount($date, 'Internal')."</td>
			<td>".$NaturesLaboratoryNonconformances->getCount($date, 'Deviation')."</td>
		</tr>";
		
		$i++;
		
	}
?>
	    </tbody>
    </table>

<?php		

    echo $HTML->main_panel_end();