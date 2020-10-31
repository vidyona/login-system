window.onload = function(){
	request("start");
	
	$aEL($(".signupb"), "click", () => {
		location.href = "signup.html";
	});
	
	$aEL($(".lsubmit"), "click", validate);
	
	$aEL($(".password"), "focus", () => {
		$(".password").removeAttribute("readonly");
	});
	
	$aEL($(".login"), "input", () => {
		$(".alert").innerHTML = "";
	});
}

function validate(){
	var n = $(".username").value;
	var p = $(".password").value;
	
	if(n){
		if(p){
			request("lin", n, p);
		}else{
			$(".alert").innerHTML = "Please enter your password";
		}
	}else if(p){
		$(".alert").innerHTML = "Please enter your username";
	}else{
		$(".alert").innerHTML = "Please enter your username and password";
	}
		
}

function recieve(response){
	switch(response.message){
		case "logged in":
			location.href = "userdata.html";
		break;

		case "usernotfound":
			$(".alert").innerHTML = "Incorrect username";
		break;

		case "incorrectpass":
			$(".alert").innerHTML = "Incorrect password";
		break;

		default: console.log("out of options: " + response.message);
	}
}

function sender(xhttp, mode, n, p){
	switch(mode){
		case "lin":
			if(n && p){
				var data = "username="+n+"&password="+p;
				send(xhttp, "php/login.php", "application/x-www-form-urlencoded", data);
			}
		break;

		case "start": send(xhttp, "php/start.php", "application/x-www-form-urlencoded", "");
	}
}