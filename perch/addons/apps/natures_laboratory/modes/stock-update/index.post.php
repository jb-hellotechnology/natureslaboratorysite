 <?php
    echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Stock Management',
    ], $CurrentUser);
    
/*
    $Smartbar = new PerchSmartbar($CurrentUser, $HTML, $Lang);

	$Smartbar->add_item([
	    'active' => true,
	    'title' => 'Import CSV',
	    'link'  => $API->app_nav().'/stock-update/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Sync BeeVital',
	    'link'  => $API->app_nav().'/stock-update/bv/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => "Sync Sweet Cecily's",
	    'link'  => $API->app_nav().'/stock-update/sc/',
	]);
	
	$Smartbar->add_item([
	    'active' => false,
	    'title' => 'Sync Herbal Apothecary',
	    'link'  => $API->app_nav().'/stock-update/ha/',
	]);
*/
	
// 	echo $Smartbar->render();

    echo $HTML->main_panel_start();
    
    if($message){
	    echo $message;
	}else{
    
	    echo $Form->form_start();
	    
	    $filename = '../../../../../sagedata/perchstock.csv';
	
		if (file_exists($filename)) {
			
			$filesize = number_format(filesize($filename)/1024/1024,2);
		    echo "<p><strong>Database was last updated:</strong> " . $lastImport . "</p>";
		    echo "<p><strong>Stock CSV was last uploaded:</strong> " . date ("F d Y H:i:s", filemtime($filename))."</p>";
		    echo "<p><strong>File size is:</strong> ".$filesize."MB</p>";
		    if($filesize>4){
				echo $Form->submit_field('btnSubmit', 'Update Database', $API->app_path());				    
			}else{
				echo $HTML->warning_message('File is too small - please wait for next update before attempting import'); 
			}
		    
		}

		echo $Form->form_end();
		
		echo "<br /><br /><h2>Sync Sage Data with Websites</h2>
		<p><a href=\"https://natureslaboratory.co.uk/sync/stock_bv.php\" target=\"_blank\">Sync Stock Levels with beevitalpropolis.com</a></p>
		<p><a href=\"https://natureslaboratory.co.uk/sync/stock_sc.php\" target=\"_blank\">Sync Stock Levels with sweetcecilys.com</a></p>
		<p><a href=\"https://natureslaboratory.co.uk/sync/stock_ha.php\" target=\"_blank\">Download inventory CSV for herbalapothecaryuk.com</a></p>
		<p><a href=\"https://natureslaboratory.co.uk/sync/pricing_ha.php\" target=\"_blank\">Download price update CSV for herbalapothecaryuk.com</a></p>";
	
	}
    echo $HTML->main_panel_end();