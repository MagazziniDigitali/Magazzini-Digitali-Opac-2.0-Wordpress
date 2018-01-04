/**
 * 
 */
function cerca(){
	document.forms.tecaLoginForm.submit();
}

function changeTypeAuth(radio) {
	if (radio.value=='editore'){
		document.getElementById("istituto").setAttribute("class","rHidden");
	}  else {
		document.getElementById("istituto").setAttribute("class","control-group");
	}
	document.getElementById("login").setAttribute("class","control-group");
	document.getElementById("password").setAttribute("class","control-group");
//	document.getElementById("dCaptcha").setAttribute("class","control-group");
	document.getElementById("button").setAttribute("class","control-group");
}
