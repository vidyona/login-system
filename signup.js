$(function(){
	$.post("start.php", "", responseHandler);
	
	$(".signUpButton").click(signup);
	
	$(".loginb").click(() => location.href = "index.html");

	$(".password").focus(() => $(".password").removeAttr("readonly"));
});

function signup(){
	var n = $(".signup .username").val();
	var p = $(".signup .password").val();
		
	if(n && p){
		$.post("signup.php", "username="+n+"&password="+p, responseHandler);
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
				case "userExists": console.log("Username already exists");
				break;
				case "signed up": location.href = "userdata.html";
				break;
				default: console.log(response.loginStatus);
			}
		}
	} catch (error) {
		console.log(error);
	}
}