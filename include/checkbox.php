<?php

	// GENERATE CHECKBOX CODE

	session_start();
	
	$checked = ( $_SESSION['newsletter'] == "subscribe" ? "checked" : "");
	$html = '<div class="input_wrapper"><input type="checkbox" id="newsletter" name="newsletter" value="newsletter" '.$checked.'/><span class="terms_condition">Newsletter abonnieren</span></div>';

	$arr = array('html' => $html);
	echo json_encode($arr);

?>