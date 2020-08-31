<?php

	include_once("api/api.php");

	$user_details = get_logged_in_user_details();

	$user_level = "normal_user";
	$user_level_number = $user_details['level'];

	$last_login_array = $user_details['last_login'];
	$last_login_array = explode(";", $last_login_array);

	$last_login_hour = $last_login_array[1];
	$last_login_day = $last_login_array[0];
	$last_login_ip = $last_login_array[2];

	$username = $user_details['username'];

	if( $user_details['level'] == 1 ) $user_level = "admin";
	else if( $user_details['level'] == 2 ) $user_level = "tech";

	$path = $_SERVER['REQUEST_URI'];

	$path = explode("/", $path);

	$path = $path[ count($path) - 1 ];

?>

<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<meta name="description" content="" />
<meta name="author" content="" />
<title>Dashboard - SB Admin</title>
<link href="css/styles.css" rel="stylesheet" />
<link href="css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/config_boxes.css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/navbar.js"></script>
<script type="text/javascript" src="js/login.js"></script>
<script type="text/javascript" src="js/config_boxes.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

