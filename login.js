function $(e){return document.querySelector(e);}
function $All(e){return document.querySelectorAll(e);}

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
	
	$(".login").addEventListener("input", function(){
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

function login(mode, n, p){
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText){
			console.log(xhttp.responseText);
			var response = JSON.parse(xhttp.responseText);
			
			if(response.loginStatus == "logged in"){
				location.href = "userdata.html";
				
			}else if(response.loginStatus == "usernotfound"){
				$(".alert").innerHTML = "Incorrect username";
			}else if(response.loginStatus == "incorrectpass"){
				$(".alert").innerHTML = "Incorrect password";
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