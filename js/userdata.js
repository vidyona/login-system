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

function userdata(response){
	$("#userId").text(response.userId);
	$(".name").val(response.name);
	$(".dob").val(response.dob);
	$(".country").val(response.country);
	$(".favcolor").val(response.favcolor);
	$("#lastUpdated").text("Last updated: " + response.lastUpdated);
}

function responseHandler(data, status){
	console.log("data: " + data + "\n" + status);
	
	try {
		var response = extractJSON(data);
			
		if(typeof response == "object"){
			switch(response.loginStatus){
				case "logged in": userdata(response);
				break;
				case "not logged in": location.href = "index.php";
				break;
				default: console.log(response.loginStatus);
			}
		}
	} catch (error) {
		console.log(error);
	}
}