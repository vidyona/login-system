window.onload = function(){
	login("start");
	
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
			login("lin", n, p);
		}else{
			$(".alert").innerHTML = "Please enter your password";
		}
	}else if(p){
		$(".alert").innerHTML = "Please enter your username";
	}else{
		$(".alert").innerHTML = "Please enter your username and password";
	}
		
}

function responseHandler(responseText){
	console.log(responseText);

	var list = responseText.split("{");

	for(var item of list){
		if(item != ""){
			obj = "{" + item;

			var response = JSON.parse(obj);
			
			recieve(response);
		}
	}
}

function recieve(response){
	console.log(response.message);
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

		default: console.log("out of options:");
	}
}

function login(mode, n, p){
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = () => {
		if(xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText){
			responseHandler(xhttp.responseText);
		}
	};
	
	switch(mode){
		case "lin":
			if(n && p){
				var data = "username="+n+"&password="+p;
				send(xhttp, "login.php", data);
			}
		break;

		case "start": send(xhttp, "start.php", "");
	}
}