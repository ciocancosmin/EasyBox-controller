<?php

	include_once("link.php");

	session_start();

	$not_logged_in_string = "//**//";

	if(!isset($_SESSION['logged_in'])) $_SESSION['logged_in'] = $not_logged_in_string;
	
	function get_crypted_password($username,$password)
	{
		$enc_pass = $username."____".$password;
		for ($i=0; $i < 5; $i++) $enc_pass = md5($enc_pass);
		return $enc_pass;
	}

	function generateRandomString($length = 10) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	function generate_csrf_token()
	{
		return generateRandomString(30);
	}

	function find_user_pass_by_username( $username )
	{

		global $users_table,$link;

		$qry = mysqli_query($link,"SELECT password FROM ".$users_table." WHERE username='".$username."' ");

		if( mysqli_num_rows($qry) > 0 )
		{
			$qry = mysqli_fetch_array($qry);
			return $qry['password'];
		}
		else
		{
			return "user_not_found";
		}


	}

	function find_user_by_username( $username )
	{

		global $users_table,$link;

		$qry = mysqli_query($link,"SELECT username FROM ".$users_table." WHERE username='".$username."' ");

		if( mysqli_num_rows($qry) > 0 )
		{
			$qry = mysqli_fetch_array($qry);
			return $qry['username'];
		}
		else
		{
			return "user_not_found";
		}		

	}

	function create_new_user($username,$password)
	{

		global $users_table,$link;

		$new_csrf_token = generate_csrf_token();
		mysqli_query($link,"INSERT INTO ".$users_table." (username,password,csrf_token) VALUES ('".$username."','".$password."','".$new_csrf_token."') ");
		return $new_csrf_token;
	}

	function log_in_user( $username )
	{

		global $users_table,$link;

		$date_today = date("Y-m-d");
		$hour_now = date("H:i");
		$ip_address = $_SERVER["REMOTE_ADDR"];
		$last_login_string = $date_today.";".$hour_now.";".$ip_address;

		$new_csrf_token = generate_csrf_token();
		mysqli_query($link,"UPDATE ".$users_table." SET csrf_token='".$new_csrf_token."',last_login='".$last_login_string."' WHERE username='".$username."' ");
		return $new_csrf_token;
	}

	function get_user_level_by_username( $username )
	{

		global $users_table,$link;

		$qry = mysqli_query($link,"SELECT level FROM ".$users_table." WHERE username='".$username."' ");
		return mysqli_fetch_array($qry)['level'];

	}

	function get_user_level_by_csrf_token( $csrf_token )
	{

		global $users_table,$link;

		$qry = mysqli_query($link,"SELECT level FROM ".$users_table." WHERE csrf_token='".$csrf_token."' ");
		return mysqli_fetch_array($qry)['level'];

	}

	function is_user_active( $username )
	{
		global $users_table,$link;

		$qry = mysqli_query($link,"SELECT active FROM ".$users_table." WHERE username='".$username."' ");
		return mysqli_fetch_array($qry)['active'];
	}

	function is_user_logged_in_admin()
	{
		global $users_table,$link,$not_logged_in_string;

		if($_SESSION['logged_in'] == $not_logged_in_string) return 0;

		$qry = mysqli_query($link,"SELECT level FROM ".$users_table." WHERE csrf_token='".$_SESSION['logged_in']."' ");
		$user_level = mysqli_fetch_array($qry)['level'];

		if($user_level < 1) return 0; 

		return 1;
	}

	function get_user_details( $username )
	{
		global $users_table,$link;

		$qry = mysqli_query($link,"SELECT * FROM ".$users_table." WHERE username='".$username."' ");
		$qry = mysqli_fetch_array($qry);

		$return_array = array(
			"username" => $qry['username'],
			"level" => $qry['level'],
			"active" => $qry['active'],
			"last_login" => $qry['last_login']
		);

		return $return_array;
	}

	function get_logged_in_user_details()
	{
		global $users_table,$link;

		$qry = mysqli_query($link,"SELECT * FROM ".$users_table." WHERE csrf_token='".$_SESSION['logged_in']."' ");
		$qry = mysqli_fetch_array($qry);

		$return_array = array(
			"username" => $qry['username'],
			"level" => $qry['level'],
			"active" => $qry['active'],
			"last_login" => $qry['last_login']
		);

		return $return_array;
	}

	function modify_user_details( $user_id, $username, $password, $active )
	{

		global $users_table,$link;

		$qry = mysqli_query($link,"UPDATE ".$users_table." SET username='".$username."',password='".get_crypted_password($username,$password)."',active=".$active." WHERE id=".$user_id." ");

	}

	function get_users_details($page_nr,$nr_of_users_per_page)
	{

		global $users_table,$link;

		$skip_nr = $page_nr * $nr_of_users_per_page;
		$qry_limit = $nr_of_users_per_page;

		$qry = mysqli_query($link,"SELECT * FROM users WHERE level=0 LIMIT ".$skip_nr.",".$qry_limit." ");

		while ( $row = mysqli_fetch_array($qry) ) {
			echo $row['id']."<--->".$row['username']."<--->".$row['active']."<--->".$row['level']."<--->".$row['last_login']."/*/*/*/";
		}

		$qry = mysqli_query($link,"SELECT COUNT(*) as total FROM users ");

		$qry = mysqli_fetch_array($qry);

		$add = 0;

		if( $qry['total'] % $nr_of_users_per_page > 0 ) $add = 1;

		echo intval( $qry['total'] / $nr_of_users_per_page ) + $add;

	}

	function get_users_details_with_return($page_nr,$nr_of_users_per_page)
	{

		global $users_table,$link;

		$return_str = "";

		$skip_nr = $page_nr * $nr_of_users_per_page;
		$qry_limit = $nr_of_users_per_page;

		$qry = mysqli_query($link,"SELECT * FROM users WHERE level=0 LIMIT ".$skip_nr.",".$qry_limit." ");

		while ( $row = mysqli_fetch_array($qry) ) {
			$return_str .= $row['id']."<--->".$row['username']."<--->".$row['active']."<--->".$row['level']."<--->".$row['last_login']."/*/*/*/";
		}

		$qry = mysqli_query($link,"SELECT COUNT(*) as total FROM users ");

		$qry = mysqli_fetch_array($qry);

		$add = 0;

		if( $qry['total'] % $nr_of_users_per_page > 0 ) $add = 1;

		$return_str .= intval( $qry['total'] / $nr_of_users_per_page ) + $add;

		return $return_str;

	}

	$cmd = "";

	$args = "";

	if(isset($_POST['cmd'])) $cmd = $_POST['cmd'];

	if(isset($_POST['args'])) $args = explode("/*/*/*/", $_POST['args']);

	if($cmd == "jRr2Yl9vNeer5JnMyBjf") //login
	{
		$username = $args[0];
		$password = $args[1];
		$password = get_crypted_password($username,$password);

		$pass_qry = find_user_pass_by_username( $username );

		if($pass_qry == "user_not_found") echo $pass_qry;
		else
		{

			if($pass_qry == $password)
			{
				if( is_user_active($username) )
				{
					//do login , generate csrf_token
					$return_csrf_token = log_in_user($username);
					$_SESSION['logged_in'] = $return_csrf_token;
					echo "login_success";
					//echo $_SESSION['logged_in'];
				}
				else
				{
					echo "user_not_active";
				}
			}
			else
			{
				if($pass_qry == "user_not_found") echo $pass_qry;
				else echo "wrong_password_supplied";
			}

		}

	}
	else if($cmd == "86rCmTsMeueW7RAAKCLJ") //logout
	{
		$_SESSION['logged_in'] = $not_logged_in_string;
	}
	else if($cmd == "6zW1XoWFtpOWKqPG4OQw") //register
	{
		$username = $args[0];
		$password = $args[1];
		$password = get_crypted_password($username,$password);

		$user_qry = find_user_by_username( $username );

		if($user_qry == "user_not_found") //insert into db new user and return csrf_token
		{
			$return_csrf_token = create_new_user($username,$password);
			$_SESSION['logged_in'] = $return_csrf_token;
			echo "user_success_registered";
			//echo $_SESSION['logged_in'];
		}
		else 
		{
			echo "user_already_exists";
		}

	}
	else if($cmd == "w6KEitZXVLhQANH9oV3o") //check if logged in
	{

		if($_SESSION['logged_in'] == $not_logged_in_string) echo "not_logged_in";
		else echo "is_logged_in";

	}
	else if($cmd == "cfa2MneIyeJrqwIrsZgv") //get the user level if logged in
	{

		if($_SESSION['logged_in'] == $not_logged_in_string) echo "not_logged_in";
		else
		{
			echo get_user_level_by_csrf_token( $_SESSION['logged_in'] );
		}

	}
	else if($cmd == "VuRQlLhl0KDmIVzSwHih") //check admin
	{
		echo is_user_logged_in_admin();
	}
	else if($cmd == "BWZW6ymjaFmiAcp63PLf") //get all user details by username
	{
		$username = $args[0];
		if( is_user_logged_in_admin() )
		{
			$target_user_info_array = get_user_details( $username );
			echo $target_user_info_array['username']."/*/*/*/".$target_user_info_array['active']."/*/*/*/".$target_user_info_array['level'];
		}
	}
	else if($cmd == "xpAzM3g7VnzzAoVTPAwW")
	{
		$target_user_id = $args[0];
		$target_user_username = $args[1];
		$target_user_password = $args[2];
		$target_user_active = $args[3];
		if( is_user_logged_in_admin() )
		{
			modify_user_details($target_user_id,$target_user_username,$target_user_password,$target_user_active);
		}
	}
	else if($cmd == "tmcsREauNMVYT5kn8be8") //get users details
	{
		$page_nr = intval($args[0]) - 1;
		$users_per_page = 5;
		if( is_user_logged_in_admin() )
		{
			get_users_details($page_nr,$users_per_page);
		}
	}

?>