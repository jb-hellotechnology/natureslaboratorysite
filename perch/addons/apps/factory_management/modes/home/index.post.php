<?php	

echo $HTML->main_panel_start();

?>

<h1>Factory Management</h1>

<h2>Alerts</h2>

<?php

echo $HTML->failure_message('We could put errors like this %shere%s', '<a href="'.$API->app_path().'/">', '</a>');

?>

<h2 style="margin-top:12px;">Reminders</h2>

<?php

echo $HTML->warning_message('We could put warnings and suggestions for things which need doing %shere%s', '<a href="'.$API->app_path().'/">', '</a>');

?>

<h2 style="margin-top:12px;">Activity</h2>

<?php

echo $HTML->success_message('This could be a log of recent activity');

?>

<?php

echo $HTML->main_panel_end();

?>