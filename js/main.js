var redirect_pages = ["index.html","","tech.php","admin.php"];

function redirect()
{
	var current_page = window.location.href.split("/");
	current_page = current_page[ current_page.length - 1 ];

	$.ajax({
	  url: './api/api.php',
	  type:'POST',
	  data:{cmd:"cfa2MneIyeJrqwIrsZgv"},
	  success:function(data){

		if( redirect_pages.includes( current_page ) ){

	  		if(data == "not_logged_in") window.location.replace("login.html");
	  		else
	  		{
	  			user_level = parseInt(data);

	  			if( current_page == "tech.php" && user_level < 2 ) window.location.replace("index.html");
	  			if( current_page == "admin.php" && user_level < 1 ) window.location.replace("index.html");
	  		}

	  	}

	  }
	});

}

function manage_path()
{

	var current_page = window.location.href.split("/");
	current_page = current_page[ current_page.length - 1 ];

	$.ajax({
	  url: './api/api.php',
	  type:'POST',
	  data:{cmd:"cfa2MneIyeJrqwIrsZgv"},
	  success:function(data){


	  	if( current_page == "index.html" || current_page == "" )
	  	{
	  		user_level = parseInt(data);

			if( user_level == 1 ) window.location.replace("admin_users.php?page=0");
			else if( user_level == 2 ) window.location.replace("config.php");
	  	}

	  }
	});

}

$(document).ready(function(){
	redirect();
	manage_path();
});