window.onload = function(){
	request("start");

	$aEL($(".loginb"), "click", () => {location.href = "index.html"});
	
	$aEL($("button[name='rsubmit']"), "click", () => {
		request("signup");
	});
}

function sender(xhttp, mode){
	if(mode == "start"){console.log("start");
	
		xhttp.open("POST", "php/start.php", true);
		
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhttp.send();
		
	}else if(mode == "signup"){console.log("signup");
		var n = $(".signup .username").value;
		var p = $(".signup .password").value;
		
		if(n && p){
			//console.log(n);console.log(p);console.log(uname);
			xhttp.open("POST", "php/signup.php", true);
		
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
			xhttp.send("username="+n+"&password="+p);
		}
	}
}

function recieve(response){
	switch(response.message){
		case "userExists":
			$(".alert").innerHTML = "Username already exists";
		break;

		case "signed up":
			localStorage.signedup = true;
			location.href = "userdata.html";
		break;

		default: console.log("out of options: " + response.message);
	}
}