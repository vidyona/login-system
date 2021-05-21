$(() => {
	$.post("php/retrieveUserData.php", "", responseHandler);

	$(".loginButton").click(login);
	$(".signupb").click(() => location.href = "signup.html");

	$("#password").focus(() => $("#password").removeAttr("readonly"));

	$("#username").on("input", (event) => $("#usernameAlert").text(""));
	$("#password").on("input", () => $("#passwordAlert").text(""));
});

function login(){
	var n = $("#username").val();
	var p = $("#password").val();
	var rL = $("#rememberLogin")[0].checked;

	if(n && p){
		$.post("php/login.php",
			"username=" + n + "&password=" + p + "&rememberLogin=" + rL,
			responseHandler);
	}

	if(!n){
		$("#usernameAlert").text("Please enter a username.");
	}

	if(!p){
		$("#passwordAlert").text("Please enter a password.");
	}
}

function messageHandler(response){
	switch (response.message) {
		case "logged in": location.href = "userdata.html";
			break;
		case "usernotfound": $("#usernameAlert").text("User not found");
			break;
		case "incorrectpass": $("#passwordAlert").text("Incorrect password");
			break;
		default: console.log(response);
			break;
	}
}
