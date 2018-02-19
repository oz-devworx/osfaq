//Get browser specific XmlHttpRequest Object
function getXmlHttpRequestObject() {
	if (window.XMLHttpRequest) {
		return new XMLHttpRequest(); //Not IE
	} else if(window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP"); //IE
	}
}
var receiveReq = getXmlHttpRequestObject();
//Respond to request state changes
function handleUpdate(){
	if (receiveReq.readyState == 4) {
		//job done!
		var sResponse = receiveReq.responseText;
		var pidEnd = sResponse.indexOf("_");//pID delim
		var btn1Start = sResponse.indexOf("<");//first tag
		var btn2Start = sResponse.indexOf("_____");//5 char delim

		var pID = sResponse.substr(0, pidEnd);
		pidEnd = pidEnd+1;
		var outputId = sResponse.substr(pidEnd, (btn1Start - pidEnd));

		if(btn2Start > -1){
			$(outputId+pID).html(sResponse.substr(btn1Start, (btn2Start - btn1Start)));
			$("#featbox"+pID).html(sResponse.substr((btn2Start+5)));
		}else{
			$(outputId+pID).html(sResponse.substr(btn1Start));
		}
	}
}
//Initiate request
function updStatus(href) {
	//If our XmlHttpRequest object is not in the middle of a request, start the new asyncronous call.
	if (receiveReq.readyState == 4 || receiveReq.readyState == 0) {
		//True explicity sets the request to asyncronous (default).
		receiveReq.open("GET", href, true);
		//Set the function that will be called when the XmlHttpRequest objects state changes.
		receiveReq.onreadystatechange = handleUpdate;
		receiveReq.send(null);
	}
}