$(() => {
	$.post("php/retrieveUserData.php", "", responseHandler);

	$(".loginButton").click(login);
	$(".signupb").click(() => location.href = "signup.html");

	$(".password > input").focus(() => $(".password > input").removeAttr("readonly"));

	$(".username > input").on("input", (event) => $(".username > div").text(""));
	$(".password > input").on("input", () => $(".password > div").text(""));
});

function login(){
	var n = $(".username > input").val();
	var p = $(".password > input").val();
	var rL = $("#rememberLogin")[0].checked;

	if(n && p){
		$.post("php/login.php",
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
		case "usernotfound": $(".username > div").text("User not found");
			break;
		case "incorrectpass": $(".password > div").text("Incorrect password");
			break;
		default: console.log(response);
			break;
	}
}
