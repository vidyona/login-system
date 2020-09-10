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
			
			if(response.message == "logged in"){
				location.href = "userdata.html";
			}else if(response.message == "usernotfound"){
				$(".alert").innerHTML = "Incorrect username";
			}else if(response.message == "incorrectpass"){
				$(".alert").innerHTML = "Incorrect password";
			}
		}
	}
}

function login(mode, n, p){
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = () => {
		if(xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText){
			responseHandler(xhttp.responseText);
		}
	};
	
	if(n && p && mode == "lin"){console.log("!lout");
	
		xhttp.open("POST", "login.php", true);
		
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhttp.send("username="+n+"&password="+p);
		
	}else if(mode == "start"){console.log("start");
	
		xhttp.open("POST", "start.php", true);
		
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhttp.send();
		
	}
}