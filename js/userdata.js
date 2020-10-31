class UserData{
	constructor(name, dob, country, favcolor){
		this.name = name,
		this.dob = dob,
		this.country = country,
		this.favcolor = favcolor
	}
}

window.onload = () => {
	request("start");
	
	$aEL($("body"), "input", () => {
		request("save");
	});
	
	$aEL($(".logout"), "click", () => {
		request("lout");
	});
	
	countryLister();
}

function countryLister(){
	for(var cn of country_list){
		$("#countries").innerHTML += "<option>"+cn+"</option>";
	}
}

function sender(xhttp, mode){
	switch(mode){
		case "save": saveData();
		break;
		
		case "lout": send(xhttp, "php/logout.php", "application/x-www-form-urlencoded");
		break;

		case "start": send(xhttp, "php/start.php", "application/x-www-form-urlencoded", "");
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
		
	send(xhttp, "php/save.php", "application/x-www-form-urlencoded", data);
}

function recieve(response){
	switch(response.message){
		case "logged in": userdata(response);
		break;

		case "logged out": location.href = "index.html";
		break;

		case "log in": location.href = "index.html";
		break;

		default: console.log("out of options: " + response.message);
	}
	
	return true;
}

function userdata(response){
	$(".name").value = response.name;
	var dob = response.dob.slice(0, 10);
	$(".dob").value = dob;
	$(".country").value = response.country;
	$(".favcolor").value = response.favcolor;
	var datetime = updateTime(response.datetime);
	$(".date").innerText = datetime[0];
	$(".time").innerText = datetime[1];
}

function updateTime(datetimeString){
	var datetime = new Date(datetimeString);
	
	var date = datetime.getDate() + "-" + datetime.getMonth() + "-" + datetime.getFullYear();
	var time = datetime.getHours() + ":" + datetime.getMinutes() + ":" + datetime.getSeconds();
	
	return [date, time];
}

function loggedin(signedup){
	$(".status").classList = "status";
	
	if(signedup)
		$(".status").innerHTML = "Account created successfully";
}
