function $(e){return document.querySelector(e);}
function $All(e){return document.querySelectorAll(e);}

window.onload = function(){
	login("start");
	
	$("button[name='rsubmit']").addEventListener("click", function(){
		login("signup");
		//console.log("rsubmit clicked");
	});
	
}

function login(mode, n, p){
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText){
			alert(xhttp.responseText);
			var response = JSON.parse(xhttp.responseText);
			
			if(response.loginStatus == "userExists"){
				$(".alert").innerHTML = "Username already exists";
			}else if(response.loginStatus == "signed up"){
				localStorage.signedup = true;
				location.href = "userdata.html";
			}
		}
	};
	
	if(mode == "start"){console.log("start");
	
		xhttp.open("POST", "start.php", true);
		
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhttp.send();
		
	}else if(mode == "signup"){//console.log("signup");
		var n = $(".signup .username").value;
		var p = $(".signup .password").value;
		
		if(n && p){
			//console.log(n);console.log(p);console.log(uname);
			xhttp.open("POST", "signup.php", true);
		
			xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
			xhttp.send("username="+n+"&password="+p);
		}
		
	}
}

function signup(){
	$(".alert").innerHTML = "";
	
	$("fieldset[name='login']").classList = "hidden";
	$(".signupb").classList = "signupb hidden";
	
	$(".signup").classList = "signup";
}
