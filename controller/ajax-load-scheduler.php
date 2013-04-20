<?php
	if(!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
		die('This page is only used by ajax request');
	}
	include_once('../views/post-schedule-construct-scheduler.php');
	get_scheduler();
?>
