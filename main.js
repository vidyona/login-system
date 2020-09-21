$ = (e) => {return document.querySelector(e);}
$All = (e) => {return document.querySelectorAll(e);}
$aEL = (o, e, f) => {o.addEventListener(e, f);}

function send(xhttp, page, data){
	xhttp.open("POST", page, true);
	console.log(page);
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	xhttp.send(data);
}

function responseHandler(responseText){
	var isjson = responseText.startsWith('{"message":"') && responseText.endsWith('"}');
	
	if(isjson){
		var list = "[" + responseText.replace("}{", "},{") + "]";
		var jsonA = JSON.parse(list);
		for(var i of jsonA){
			recieve(i);
		}
	} else {
		console.log(responseText)
	}
	
}