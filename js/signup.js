$(() => {
	$.post("php/retrieveUserData.php", "", responseHandler);
	
	$(".signUpButton").click(signup);
	$(".loginb").click(() => location.href = "login.html");

	$(".password > input").focus(() => $(".password > input").removeAttr("readonly"));
	
	$(".username > input").on("input", () => validate("username"));
	$(".password > input").on("input", () => validate("password"));
});

function signup(){
	var n = $(".username > input").val();
	var p = $(".password > input").val();
	var rL = $("#rememberLogin")[0].checked;
		
	if(n && p && validate("username") && validate("password")){
		$.post("php/signup.php",
			"username=" + n + "&password=" + p + "&rememberLogin=" + rL,
			responseHandler);
	}

	if(!n){
		$(".username > div").text("Please enter a username.");
	}
	
	if(!p){
		$(".password > div").text("Please enter a password.");
	}
}

function messageHandler(response){
	switch (response.message) {
		case "logged in": location.href = "userdata.html";
			break;
		case "userExists": $(".username > div").text("Username already exists");
			break;
		case "signed up": location.href = "userdata.html";
			break;
		default: console.log(response);
			break;
	}
}