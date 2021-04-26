$(function(){
	$.post("start.php", "", responseHandler);
	
	$(".ssubmit").click(saveData);
	
	$(".logout").click(() => $.post("logout.php", "", responseHandler));
	
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

	$.post("save.php", "name="+n+"&dob="+dob+"&country="+c+"&favcolor="+fc, responseHandler);
}

function userdata(response){
	$(".name").val(response.name);
	$(".dob").val(response.dob);
	$(".country").val(response.country);
	$(".favcolor").val(response.favcolor);
}

function responseHandler(data, status){
	console.log(data, status);
	
	try {
		var response = JSON.parse(extractJSON(data));
			
		if(typeof response == "object"){
			switch(response.loginStatus){
				case "logged in": userdata(response);
				break;
				case "dataUpdated": console.log("dataUpdated");
				break;
				case "logged out": location.href = "index.html";
				break;
				case "log in": location.href = "index.html";
				break;
				default: console.log(response.loginStatus);
			}
		}
	} catch (error) {
		console.log(error);
	}
}