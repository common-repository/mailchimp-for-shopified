<?php

	// SET SUBSCRIBE OR UNSUBSCRIBE IN OUR SESSION

	session_start();
	$_SESSION['newsletter'] = $_GET['newsletter'];

?>