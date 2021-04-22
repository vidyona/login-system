function $(e){return document.querySelector(e);}
function $All(e){return document.querySelectorAll(e);}
function $aEL(e, eve, f){return e.addEventListener(eve, f);}

window.onload = function(){
	login("start");
	
	$(".signupb").addEventListener("click", function(){
		console.log("signupb clicked");
		location.href = "signup.html";
	});
	
	$(".lsubmit").addEventListener("click", validate);
	
	$(".password").addEventListener("focus", function(){
		$(".password").removeAttribute("readonly");
	});
	
	$aEL($(".login"),"input", typing);
}

function typing(){
	$(".alert").innerHTML = "";
	
	var n = $(".username").value;
	var p = $(".password").value;
	
	var inValPos = n.search(/[^A-Za-z0-9]/g);
	
	if(inValPos >= 0)
		$(".alert").innerHTML = "Only A-Z a-z and 0-9 are valid."
	else
		$(".alert").innerHTML = "";
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

function login(mode, n, p){
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText){
			console.log(xhttp.responseText);
			try {
				var response = JSON.parse(extractJSON(xhttp.responseText));
			
				if(typeof response == "object"){
					switch(response.loginStatus){
						case "logged in": location.href = "userdata.html";
						break;
						case "usernotfound": $(".alert").innerHTML = "User not found";
						break;
						case "incorrectpass": $(".alert").innerHTML = "Incorrect password";
						break;
						default: console.log(response.loginStatus);
					}
				}
			} catch (error) {
				console.log(error);
			}
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