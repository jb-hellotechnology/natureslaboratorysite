<?php
	echo $HTML->side_panel_start();
    
    echo $HTML->side_panel_end();
    
    echo $HTML->title_panel([
    'heading' => 'Factory Dashboard',
    ], $CurrentUser);
?>
<div id="dashboard" class="dashboard">
	<div class="widget" data-app="content">
		<div class="dash-content">
			<header>Signed In Staff</header>
			<div class="body">
				<ul class="dash-list">
				<?php
			    foreach($staff as $Staff) {
				    echo "<li>$Staff</li>";
				}
				?>
				</ul>
			</div>
		</div>
	</div>
	<div class="widget" data-app="content">
		<div class="dash-content">
			<header>Storage Conditions</header>
			<div class="body">
				<table>
					<tr>
						<th><strong>Area</strong></th>
						<th><strong>Last 7 Days</strong></th>
						<th><strong>Last 30 Days</strong></th>
						<th><strong>Last 90 Days</strong></th>
					</tr>
					<tr>
						<th><strong>Herb Store</strong></th>
						<th><?php $NaturesLaboratoryCOA->storageConditions('herbstorage', '7'); ?></th>
						<th><?php $NaturesLaboratoryCOA->storageConditions('herbstorage', '30'); ?></th>
						<th><?php $NaturesLaboratoryCOA->storageConditions('herbstorage', '90'); ?></th>
					</tr>
					<tr>
						<th><strong>Bottle Store</strong></th>
						<th><?php $NaturesLaboratoryCOA->storageConditions('bottlestore', '7'); ?></th>
						<th><?php $NaturesLaboratoryCOA->storageConditions('bottlestore', '30'); ?></th>
						<th><?php $NaturesLaboratoryCOA->storageConditions('bottlestore', '90'); ?></th>
					</tr>
				</table>
			</div>
			<footer>
				<form method="post" action="/perch/addons/apps/natures_laboratory/">
					<label>Download Environmental Data</label>
					<select name="date">
						<?php
							$i = 1;
							while($i<=12){
								$date = date("Y-m", mktime(0, 0, 0, date('m')-$i, 1, date('Y')));
								echo '<option value="'.$date.'">'.$date.'</option>';
								$i++;
							}	
						?>
					</select>
					<input type="submit" value="Download" />
				</form>
			</footer>
		</div>
	</div>
</div>