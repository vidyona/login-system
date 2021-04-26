$(function(){
	$.post("start.php", "", responseHandler);
	
	$(".signupb").click(() => location.href = "signup.html");
	
	$(".loginButton").click(login);
	
	$(".password > input").focus(() => $(".password > input").removeAttr("readonly"));
	
	$(".username > input").on("input", typing);
	
	$(".password > input").on("input", () => $(".password > div").text(""));
});

function typing(){
	const usernameAlertDOM = $(".username > div");
	
	var n = $(".username > input").val();
	
	var inValPos = n.search(/[^A-Za-z0-9]/g);
	
	if(inValPos >= 0)
		usernameAlertDOM.text("Only A-Z a-z and 0-9 are valid.");
	else
		usernameAlertDOM.text("");
}

function login(){
	var n = $(".username > input").val();
	var p = $(".password > input").val();

	if(n && p){
		$.post("login.php", "username="+n+"&password="+p, responseHandler);
	}
	
	if(!n){
		$(".username > div").text("Please enter a username.");
	}
	
	if(!p){
		$(".password > div").text("Please enter a password.");
	}
}

function responseHandler(data, status){
	console.log(data, status);
	
	try {
		var response = JSON.parse(extractJSON(data));
			
		if(typeof response == "object"){
			switch(response.loginStatus){
				case "logged in": location.href = "userdata.html";
				break;
				case "usernotfound": $(".username > div").text("User not found");
				break;
				case "incorrectpass": $(".password > div").text("Incorrect password");
				break;
				default: console.log(response.loginStatus);
			}
		}
	} catch (error) {
		console.log(error);
	}
}