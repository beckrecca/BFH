function setEntrance (entrance) {
	document.cookie = "entrance=" + entrance;
}
function readEntrance() {
	// split the cookie into an array at the semicolons
	var cookie = document.cookie.split(";");
	// initialize return var
	var result = null;
	// loop through the array to find the entrance
	for (var i = 0; i < cookie.length; i++) {
		// find the cookie name
		var cookiename = cookie[i].substr(0, cookie[i].indexOf("="));
		// check the name of the cookie
		if (cookiename == "entrance" || cookiename == " entrance") {
			result = cookie[i].substring(cookie[i].indexOf("=")+1, cookie[i].length);
		}
	}
	return result;
}