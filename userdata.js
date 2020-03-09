function $(e){return document.querySelector(e);}
function $All(e){return document.querySelectorAll(e);}

window.onload = function(){
	login("start");
	
	$(".ssubmit").addEventListener("click", function(){
		login("save");
	});
	
	$(".logout").addEventListener("click", function(){
		login("lout");
	});
	
	for(var cn of country_list){
		$("#countries").innerHTML += "<option>"+cn+"</option>";
	}
}

function login(mode){
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function(){
		if(xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText){
			
			console.log(xhttp.responseText);
			var response = JSON.parse(xhttp.responseText);
			
			recieve(response);
		}
	};
	
	if(mode == "save"){
		console.log("save");
		
		var n = $(".name").value;
		var dob = $(".dob").value;
		var c = $(".country").value;
		var fc = $(".favcolor").value;
		
		var data = "name="+n+"&dob="+dob+"&country="+c+"&favcolor="+fc;
		
		send(xhttp, "save.php", data);
		
	}else if(mode == "lout"){
		console.log("lout");
		
		send(xhttp, "logout.php", "");
		
	}else if(mode == "start"){
		console.log("start");
		
		send(xhttp, "start.php", "");
	}
}

function recieve(response){
	if(response.loginStatus == "logged in"){
		console.log("logged in");
		
		userdata(response);
		
	}else if(response.loginStatus == "dataUpdated"){
		console.log("dataUpdated");
		
	}else if(response.loginStatus == "logged out"){
		console.log("logged out");
		location.href = "index.html";
		
	}else if(response.loginStatus == "log in"){
		console.log("log in");
		location.href = "index.html";
	}
}

function send(xhttp, page, data){
	xhttp.open("POST", page, true);
	console.log(page);
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	xhttp.send(data);
}

function userdata(response){
	$(".name").value = response.name;
	$(".dob").value = response.dob;
	$(".country").value = response.country;
	$(".favcolor").value = response.favcolor;
}

function loggedin(signedup){
	$(".status").classList = "status";
	
	if(signedup)
		$(".status").innerHTML = "Account created successfully";
}