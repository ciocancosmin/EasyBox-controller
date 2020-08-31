function toggle_logout_div()
{
	$("#userDropdown_div").css("display","block");
	$("#userDropdown").attr("onclick","untoggle_logout_div();");
}

function untoggle_logout_div()
{
	$("#userDropdown_div").css("display","none");
	$("#userDropdown").attr("onclick","toggle_logout_div();");	
}