<?php
include ('dbconfig.php');
date_default_timezone_set("Asia/Karachi");

/////////////////// JavaScript Redirect to other page function /////////////////
function jsredirecturl($url)
{
	return "<script> window.location.href = '".$url."';</script>";
}


?>