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
		
		case "lout": send(xhttp, "logout.php");
		break;

		case "start": send(xhttp, "start.php", "");
		break;
		
		default: console.log("invalid option: " + mode);
	}
}

function saveData(){
	var name = $(".name").value;
	var dob = $(".dob").value;
	var country = $(".country").value;
	var favcolor = $(".favcolor").value;

	var userdata = new UserData(name, dob, country, favcolor);
	
	var data = "userdata=" + JSON.stringify(userdata);
		
	send(xhttp, "save.php", data);
}

function recieve(response){
	switch(response.message){
		case "logged in": userdata(response);
		break;

		case "data updated": lastUpdated(response);
		break;

		case "logged out": location.href = "index.html";
		break;

		case "log in": location.href = "index.html";
		break;

		default: console.log("out of options: " + response.message);
	}
}

function userdata(response){
	$(".name").value = response.name;
	var dob = response.dob.slice(0, 10);
	$(".dob").value = dob;
	$(".country").value = response.country;
	$(".favcolor").value = response.favcolor;
}

function lastUpdated(response){
	$(".lastSaved.date").innerHTML = response.date;
	$(".lastSaved.time").innerHTML = response.time;
}

function loggedin(signedup){
	$(".status").classList = "status";
	
	if(signedup)
		$(".status").innerHTML = "Account created successfully";
}
