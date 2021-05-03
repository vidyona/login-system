$(function(){
	$.post("php/retrieveUserData.php", "", responseHandler);
	
	$(".ssubmit").click(saveData);
	
	$(".logout").click(() => $.post("php/logout.php", "", responseHandler));
	
	var options = "";

	for(var cn of country_list){
		options += "<option>"+cn+"</option>";
	}

	$("#countries").html(options);
});

function saveData(){
	var n = $(".name").val();
	var dob = $(".dob").val();
	var c = $(".country").val();
	var fc = $(".favcolor").val();

	$.post("php/storeUserData.php", "name="+n+"&dob="+dob+"&country="+c+"&favcolor="+fc, responseHandler);
}

// function userdata(response){
// 	$("#userId").text(response.userid);
// 	$(".name").val(response.name);
// 	$(".dob").val(response.dob);
// 	$(".country").val(response.country);
// 	$(".favcolor").val(response.favcolor);
// 	$("#lastUpdated").text("Last updated: " + response.last_updated);
// }

function responseHandler(data, status){
	console.log("data: " + data + "\n" + status);
	
	var responses = extractJSON(data);
		
	for(let response of responses){
		console.log(response);
		if(typeof response == "object" && response.message){
			messageHandler(response.message);
		} else{
			for(let i in response){
				switch (i) {
					case "message": messageHandler(response.message);
						break;
					case "userid" : $("#userId").text(response.userid);
						break;
					case "name" : $(".name").val(response.name);
						break;
					case "dob" : $(".dob").val(response.dob);
						break;
					case "country" : $(".country").val(response.country);
						break;
					case "favcolor" : $(".favcolor").val(response.favcolor);
						break;
					case "last_updated" : $("#lastUpdated").text("Last updated: " + response.last_updated);
						break;
					default: console.log(response.message);
						break;
				}
			}
		}
	}
}

function messageHandler(message){
	console.log(message);
	switch (message) {
		case "not logged in": location.href = "index.php";
			break;
		default: console.log(message);
			break;
	}
}