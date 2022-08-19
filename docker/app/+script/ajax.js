// JavaScript Document
// XML Http requests

var uniqnum_counter = (new Date).getTime();
var agt = navigator.userAgent.toLowerCase();

var is_opera = (agt.indexOf("opera") != -1);
var is_ie = (agt.indexOf("msie") != -1) && document.all && !is_opera;
var is_ie5 = (agt.indexOf("msie 5") != -1) && document.all;

var ajax = new AJAX;

//Sample    do not use different functions with same names for handler. use random names
//ajax.handler456 = function(inp){alert(inp.readyState)}
//ajax.get('http://ser/index.php', ajax.handler456);

function AJAX()
{
	this.agt = agt;
	this.is_opera = is_opera;
	this.is_ie = is_ie;
	this.is_ie5 = is_ie5;
	
	this.send = sendServerRequest;
	this.get  = startGetRequest;
	this.post = startPostRequest;	
}

function createXmlHttpReq(handler)
{
	var xmlhttp = null;
	if (is_ie) {
		// Guaranteed to be ie5 or ie6
		var control = (is_ie5) ? "Microsoft.XMLHTTP" : "Msxml2.XMLHTTP";
		try {
			xmlhttp = new ActiveXObject(control);
		} catch(e) {
			// TODO: better help message
			alert("You need to enable active scripting and activeX controls");
			DumpException(e);
		}
	} else {
		// Mozilla
		xmlhttp = new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange = function() {
		handler(xmlhttp);
	}
	return xmlhttp;
}

function uniqueNum()
{
	return ++uniqnum_counter;
}

function sendServerRequest(url)
{
	startGetRequest(url, function() {});
}

function startGetRequest(url, handler)
{
	var xmlhttp = createXmlHttpReq(handler);
	url = url.indexOf('?') ? url + "&rand=" + uniqueNum() : url + "?rand=" + uniqueNum();
	xmlhttp.open('GET', url, true);
	xmlhttp.send(null);
}

function startPostRequest(url, data, handler)
{
	var xmlhttp = createXmlHttpReq(handler);
	xmlhttp.open('POST', url, true);
	xmlhttp.send(data);
}
