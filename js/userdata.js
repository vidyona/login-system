$(() => {
	$.post("php/retrieveUserData.php", "", responseHandler);
	
	$(".ssubmit").click(saveData);
	
	$(".logout").click(() => $.post("php/logout.php", "", responseHandler));
	
	var options = "";

	for(var cn of country_list){
		options += "<option>"+cn+"</option>";
	}

	$("#countries").html(options);

	$(".deleteAccount").click(() => {
		if(confirm("Complete account with each data will be deleted.\nAre you sure?")){
			$.post("php/deleteUserAccount.php", "", responseHandler);
		}
	});
});

function saveData(){
	var n = $(".name").val();
	var dob = $(".dob").val();
	var c = $(".country").val();
	var fc = $(".favcolor").val();

	$.post("php/storeUserData.php", "name="+n+"&dob="+dob+"&country="+c+"&favcolor="+fc, responseHandler);
}

function userdata(response){
	for(let i in response){
		switch (i) {
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
			default: console.log(response);
				break;
		}
	}
}

function messageHandler(response){
	switch (response.message) {
		case "not logged in": location.href = "index.php";
			break;
		default: console.log(response);
			break;
	}
}

function responseHandler(data, status){
	console.log({status: status, data: data});
	
	var responses = extractJSON(data);
		
	for(let response of responses){
		if(typeof response == "object"){
			if(response.message){
				messageHandler(response);
			} else {
				userdata(response);
			}
		}
	}
}