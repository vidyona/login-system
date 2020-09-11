$ = (e) => {return document.querySelector(e);}
$All = (e) => {return document.querySelectorAll(e);}
$aEL = (o, e, f) => {o.addEventListener(e, f);}

function send(xhttp, page, data){
	xhttp.open("POST", page, true);
	console.log(page);
	
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	
	xhttp.send(data);
}