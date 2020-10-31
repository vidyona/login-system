$ = (e) => {return document.querySelector(e);}
$All = (e) => {return document.querySelectorAll(e);}
$aEL = (o, e, f) => {o.addEventListener(e, f);}

function send(xhttp, page, type, data){
	xhttp.open("POST", page, true);
	//console.log(page);
	
	xhttp.setRequestHeader("Content-type", type);
	
	xhttp.send(data);
}

function responseHandler(responseText){
	responseText = responseText.trim();
	var isjson = responseText.startsWith('{"message":"') && ((responseText.endsWith('"}') || responseText.endsWith(']}')));
	
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

function request(mode, n, p){
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = () => {
		if(xhttp.readyState == 4 && xhttp.status == 200 && xhttp.responseText){
			responseHandler(xhttp.response);
		}
		console.log("xhttp.readyState: " + xhttp.readyState);
	};
	
	sender(xhttp, mode, n, p);
}