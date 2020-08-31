function register_user( username , password, register_div_error )
{
	args_string = username + "/*/*/*/" + password;

	$.ajax({
	  url: './api/api.php',
	  type:'POST',
	  data:{cmd:"6zW1XoWFtpOWKqPG4OQw",args:args_string},
	  success:function(data){

			if(data == "user_already_exists")
			{
				$("#"+register_div_error).html("The username that you entered is already registered in our database!");
				console.log("The username that you entered is already registered in our database!");
			}
			else if(data == "user_success_registered")
			{
				$("#"+register_div_error).html("The account was successfully registered!");
				console.log("The account was successfully registered!");
			}

	  }
	});
}

function register()
{
	register_div_error = "login_error_div";
	username_input_val = $("#username_inp").val();
	password_input_val = $("#password_inp").val();
	password_check_input_val = $("#password_inp_check").val();
	if( password_input_val == password_check_input_val )
	{
		register_user( username_input_val , password_check_input_val , "login_error_div" );
	}
	else
	{
		$("#"+register_div_error).html("The passwords that you provided are not the same!");
	}

}

$(document).ready(function(){
	register_user( 'danut' , 'tataaremere' );
});