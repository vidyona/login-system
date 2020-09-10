class UserData{
	constructor(name, dob, country, favcolor){
		this.name = name,
		this.dob = dob,
		this.country = country,
		this.favcolor = favcolor
	}
}

window.onload = () => {
	login("start");
	
	$aEL($("body"), "input", () => {
		login("save");
	});
	
	$aEL($(".logout"), "click", () => {
		login("lout");
	});
	
	for(var cn of country_list){
		$("#countries").innerHTML += "<option>"+cn+"</option>";
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

function login(mode){
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = () => {
		if(xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText){
			responseHandler(xhttp.responseText);
		}
	};
	
	switch(mode){
		case "save": saveData();
		break;
		
		case "lout":
		console.log("lout");
		
		send(xhttp, "logout.php", "");
		break;

		case "start":
		console.log("start");
		
		send(xhttp, "start.php", "");
		break;
		
		default: console.log("invalid option");
	}
}

function saveData(){
	var name = $(".name").value;
	var dob = $(".dob").value;
	var country = $(".country").value;
	var favcolor = $(".favcolor").value;

	var userdata = new UserData(name, dob, country, favcolor);
		
	//var data = "name="+n+"&dob="+dob+"&country="+c+"&favcolor="+fc;
	var data = "userdata=" + JSON.stringify(userdata);
		
	send(xhttp, "save.php", data);
}

function send(xhttp, page, data){
	xhttp.open("POST", page, true);
	console.log(page);
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	xhttp.send(data);
}

function recieve(response){
	console.log(response.message);
	switch(response.message){
		case "logged in":
			userdata(response);
		break;

		case "logged out":
			location.href = "index.html";
		break;

		case "log in":
			location.href = "index.html";
		break;

		default: "out of options";
	}
}

function userdata(response){
	$(".name").value = response.name;
	var dob = response.dob.slice(0, 10);
	$(".dob").value = dob;
	$(".country").value = response.country;
	$(".favcolor").value = response.favcolor;
}

function loggedin(signedup){
	$(".status").classList = "status";
	
	if(signedup)
		$(".status").innerHTML = "Account created successfully";
}
