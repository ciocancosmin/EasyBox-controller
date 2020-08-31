function login_user( username , password, login_error_div )
{
	args_string = username + "/*/*/*/" + password;
	
	$.ajax({
	  url: 'api/api.php',
	  type:'POST',
	  data:{cmd:"jRr2Yl9vNeer5JnMyBjf",args:args_string},
	  success:function(data){

			if(data == "user_not_found")
			{
				$("#"+login_error_div).html("The username that you entered is not registered in our database!");
				console.log("The username that you entered is not registered in our database!");
			}
			else if(data == "wrong_password_supplied")
			{
				$("#"+login_error_div).html("The password that you entered is wrong!");
				console.log("The password that you entered is wrong!");
			}
			else if(data == "user_not_active")
			{
				$("#"+login_error_div).html("The user is no longer active!");
				console.log("The user is no longer active!");
			}
			else if(data == "login_success")
			{
				window.location.replace("index.html");
			}

	  }
	});

}

function logout()
{

	$.ajax({
	  url: 'api/api.php',
	  type:'POST',
	  data:{cmd:"86rCmTsMeueW7RAAKCLJ"},
	  success:function(data){

			window.location.replace("login.html");

	  }
	});

}

function check_enter(event)
{
	key_code = event.keyCode;
	if(key_code == 13)
	{
		console.log("enter");
		login();
	}
}

function login()
{
	username_input_val = $("#username_inp").val();
	password_input_val = $("#password_inp").val();
	//console.log( username_input_val + " " + password_input_val );
	login_user( username_input_val , password_input_val , "login_error_div" );
}

$(document).ready(function(){
	//login_user('gicu','mamaaremere');
});