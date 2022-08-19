//var msgText = msgReadCookie('msgText');   //cookie based messaging
//var msgType = msgReadCookie('msgType');
//var msgTitle= msgReadCookie('msgTtitle');
//
//msgEraseCookie('msgText');
//msgEraseCookie('msgType');
//msgEraseCookie('msgTitle');

//if(msgText){
//	msgDisplay(msgText, msgType, msgTitle);
//}
var msgDiv;

function msgCatchEsc(e)
{
	if (!e){
		e = window.event;
	}
	if (e.keyCode){
		code = e.keyCode;
	} else if (e.which){
		code = e.which;
	}
	if(code==27){
		msgCloseClick();
	}
}

function msgAttachEvent(name, element, callBack)
{
	if (element.addEventListener) {
		element.addEventListener(name, callBack, false);
	} else if (element.attachEvent) {
	 	element.attachEvent('on'+name, callBack);
	}
}

function msgCreateCookie(cName, cValue)
{
	var argv = msgCreateCookie.arguments;
	var argc = msgCreateCookie.arguments.length;
	var expires = (argc > 2) ? new Date(argv[2]) : null;
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	document.cookie = cName + "=" + escape (cValue) +
	((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
	((path == null) ? "" : ("; path=" + path)) +
	((domain == null) ? "" : ("; domain=" + domain)) +
	((secure == true) ? "; secure" : "");	
}

function msgReadCookie(keyName)
{
	var nameEQ = keyName + "=";
	var ca = document.cookie.split (';');
	for (var i = 0; i < ca.length; i ++) {
		var c = ca [i];
		while (c.charAt (0) == ' ') c = c.substring (1, c.length);
		if (c.indexOf (nameEQ) == 0) return c.substring (nameEQ.length, c.length);
	}
	return null;
}

function msgEraseCookie(cName)
{
	msgCreateCookie(cName, "", -1);
}

function msgDisplay(msgText, msgType, msgTitle, msgCmd, Id, Index)
{
	_msgLoader = function()
	{
		if(document.body){
			document.body.appendChild(msgDiv);
			_msgBtns = document.getElementById('msgExtra').childNodes;
			for(var key in _msgBtns){
				if(_msgBtns[key].tagName == "INPUT" && _msgBtns[key].offsetLeft){
					msgAttachEvent('keypress', _msgBtns[key], msgCatchEsc);
					_msgBtns[key].onkeypress = msgCatchEsc;
					setTimeout('_msgBtns['+key+'].focus();', 200);
					break;
				}
			}
			msgDiv.style.left = parseInt((document.body.offsetWidth - msgDiv.offsetWidth) / 2)+'px';
			msgScroll(null, -msgDiv.offsetHeight-20);
			msgAttachEvent('keyup', document, msgCatchEsc);
			
			if(msgType == 'reminder'){
				_msgCmbContainer = document.getElementById('msgCmbContainer');
				_msgCmbContainer.innerHTML = "<select id='msgCmbPostpone' name='msgCmbPostpone'>"+
												"<option value='300'>5 Minutes</option>"+
												"<option value='600'>10 Minutes</option>"+
												"<option value='900'>15 Minutes</option>"+
												"<option value='1800'>30 Minutes</option>"+
												"<option value='3600'>1 Hour</option>"+
												"<option value='7200'>2 Hours</option>"+
												"<option value='14400'>4 Hours</option>"+
												"<option value='28800'>8 Hours</option>"+
												"<option value='43200'>0.5 Days</option>"+
												"<option value='86400'>1 Day</option>"+
												"<option value='172800'>2 Days</option>"+
												"<option value='259200'>3 Days</option>"+
												"<option value='345600'>4 Days</option>"+
												"<option value='604800'>1 Week</option>"+
												"<option value='1209600'>2 Weeks</option>"+
											  "</select>";						  
			}		
		} else {
			setTimeout('_msgLoader()', 500);	
		}
	}
	if(typeof(msgDiv) == 'object'){
		return false;	
	}	
	if(typeof(msgType) != 'string'){
		msgType = '';	
	}
	if(typeof(msgTitle) != 'string'){
		msgTitle = msgType.toUpperCase();
	}
	msgDiv = document.createElement('DIV');
	msgDiv.className = 'msgDiv';
	msgDiv.id = 'msg_' + msgType.toLowerCase();

	if(typeof(msgCmd)!='undefined' && msgCmd){
		var OkClick 		= msgCmd;
		var ApplyClick		= msgCmd; 
		var YesClick		= msgCmd; 
		var DelClick    	= msgCmd; 
		var PostponeClick   = msgCmd; 
	} else {		
		var OkClick			= "msgOkClick();";
		var ApplyClick		= "msgApplyClick();"; 
		var YesClick		= "msgYesClick();"; 
		var DelClick    	= "msgDelClick("+Id+");";
		var PostponeClick   = "msgPostponeClick("+Id+","+Index+");";
	}
	msgDiv.innerHTML = 	'<div class="header" id="msgHeader"><div class="close" id="msgClose" onclick="msgCloseClick();" onmousedown="this.style.margin=\'3px 1px 1px 3px\'" onmouseup="this.style.margin=\'2px\'">X</div><div class=title id="msgTitle">'+msgTitle+'</div></div>'+
						'<div class="picture" id="msgPicture"></div>'+
						'<div class="content" id="msgContent">'+msgText+'</div>'+
						'<div class="extra" id="msgExtra"><input id="msgBtnOk" onclick="'+OkClick+'" type="button" value="OK" /> <input id="msgBtnCancel" onclick="msgCancelClick();" type="button" value="Cancel" /> <input id="msgBtnApply" onclick="'+ApplyClick+'" type="button" value="Apply" /> <input id="msgBtnYes" onclick="'+YesClick+'" type="button" value="Yes" /> <input id="msgBtnNo" onclick="msgNoClick();" type="button" value="No" /> <input id="msgBtnDel" onclick="'+DelClick+'" type="button" value="Delete" /> <input id="msgBtnPostpone" onclick="'+PostponeClick+'" type="button" value="Postpone" /> <span id="msgCmbContainer"></span> </div>';
	_msgLoader();	
}

function msgScroll(align, steps)
{
	var topMargin = 232 + document.body.scrollTop;
	var stepsDivisor = 1.3;
	var interval = 20;
	if(typeof(msgDiv)!="object"){
		return false;
	}
	msgDiv.style.top = (steps + topMargin) +'px';
	steps = parseInt(steps / stepsDivisor);
	if(steps < -2){
		setTimeout('msgScroll('+align+', '+steps+')', interval);
	}
}

function msgDelClick(Id){
	var a=new Ajax("index.php?section=user&module=reminder-admin&cmd=delete&frm_id="+Id, {method: 'get'}).request();
	msgCloseClick();
}

function msgPostponeClick(Id, Index){
	var Postpone = $('msgCmbPostpone').value;
	var d = Number(new Date());
	d = d + (Postpone * 1000);
	d = new Date(d);
	var month = (d.getMonth() + 1).toString();
	if(month.length == 1){
		month = "0"+month;
	}
	var day = d.getDate().toString();
	if(day.length == 1){
		day = "0"+day;
	}
	var newDate = d.getFullYear() + '-' + month + '-' + day;
	var newHour = d.getHours();
	var newMinute = d.getMinutes();
	var newTimestamp = Math.floor(Number(d)/10000);
	var a=new Ajax("index.php?section=user&module=reminder-admin&cmd=postpone&reminderid="+Id+"&reminderindex="+Index+"&newtimestamp="+newTimestamp+"&newdate="+newDate+"&newhour="+newHour+"&newminute="+newMinute, {method: 'get', evalScripts: true}).request();
	msgCloseClick();
}

msgCloseClick = msgOkClick = msgCancelClick = msgApplyClick = msgYesClick = msgNoClick = function()
{
	if(typeof(msgDiv)=='object') {
		document.body.removeChild(msgDiv);
		msgDiv = 0;
	}
}

function MESSAGE()
{
	this.display = this.show = msgDisplay;
	this.alert = function(msgText){this.display(msgText, 'alert', 'Alert', this.cmd)}
	this.error = function(msgText){this.display(msgText, 'error', 'Error', this.cmd)}
	this.help = function(msgText){this.display(msgText, 'help', 'Help', this.cmd)}
	this.info = this.confirm = function(msgText){this.display(msgText, 'info', 'Confirm', this.cmd)}
	this.lock = function(msgText){this.display(msgText, 'lock', 'Access', this.cmd)}
	this.ok = function(msgText){this.display(msgText, 'ok', '', this.cmd)}
	this.reminder = function(msgText, Id, Index){this.display(msgText, 'reminder', 'Reminder', this.cmd, Id, Index)}
	this.yes = msgYesClick;
	this.no = msgNoClick;
}

var msg = new MESSAGE;