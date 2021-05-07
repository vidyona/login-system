$(() => {
	$.post("php/retrieveUserData.php", "", responseHandler);
	
	$(".signupb").click(() => location.href = "signup.html");
	
	$(".loginButton").click(login);
	
	$(".password > input").focus(() => $(".password > input").removeAttr("readonly"));
	
	$(".username > input").on("input", validate);
	
	$(".password > input").on("input", () => $(".password > div").text(""));
});

function validate(){
	const usernameAlertDOM = $(".username > div");
	
	var n = $(".username > input").val();
	
	var inValPos = n.search(/[^A-Za-z0-9]/g);
	
	if(inValPos >= 0){
		usernameAlertDOM.text("Only A-Z a-z and 0-9 are valid.");
		return false;
	} else {
		usernameAlertDOM.text("");
		return true;
	}
}

function login(){
	const usernameAlertDOM = $(".username > div");

	var n = $(".username > input").val();
	var p = $(".password > input").val();
	var rL = $("#rememberLogin")[0].checked;

	if(n && p && validate()){
		$.post("php/login.php",
			"username=" + n + "&password=" + p + "&rememberLogin=" + rL,
			responseHandler);
	}
	
	if(!n){
		usernameAlertDOM.text("Please enter a username.");
	}
	
	if(!p){
		$(".password > div").text("Please enter a password.");
	}
}

function responseHandler(data, status){
	console.log(data, status);
	
	var responses = extractJSON(data);
	
	for(let response of responses){
		if(typeof response == "object" && response.message){
			messageHandler(response);
		}
	}
}

function messageHandler(response){
	switch (response.message) {
		case "logged in": location.href = "userdata.html";
			break;
			case "usernotfound": $(".username > div").text("User not found");
			break;
			case "incorrectpass": $(".password > div").text("Incorrect password");
			break;
		default: console.log(response);
			break;
	}
}