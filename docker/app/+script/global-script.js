// new ajax(url, {update:myObj}).request();
var ajax = Ajax.extend({
		xAjaxOptions: function(){
		return {										//change this values on site change
			loading: '../images/loading.gif',
			onError: function(tr){alert('Error in Ajax')},
			retry: 1,
			method: 'get',
			evalScripts: true,
			
			update: null,
			Tupdate: null,
			retryCount: 0
		};
	},

	initialize: function(url, options){
		this.addEvent('onFailure', this.onError);
		this.setOptions(this.xAjaxOptions(), options);
		this.parent(url, this.options);
	},

	onError: function(){
		if(this.retryCount>0) {
			this.request.delay(20, this, [true]);	
		} else {
			if(this.options.loading && $(this.options.update)) {
				$(this.options.update).replaceWith(this.Tupdate);
			}
			this.fireEvent('onError', [this.transport], 20);
		}
	},
	
	request: function(retry){
		if(!retry && this.url && this.options.loading && $(this.options.update)){
			this.Tupdate = $(this.options.update).clone();
			$(this.options.update).setHTML('');
			if(this.options.loading.test(/\.gif|png|jpg|jpeg$/i)) {
				var img = new Element('img');
				img.setProperty('id', 'loadingimg');
				img.setProperty('src', this.options.loading);
				$(this.options.update).adopt(img);
			} else {
				$(this.options.update).appendText(this.options.loading);
			}
		}
		this.retryCount = retry ? this.retryCount-1 : this.options.retry;
		var data = null;
		switch ($type(this.options.postBody)){
			case 'element': data = $(this.options.postBody).toQueryString(); break;
			case 'object': data = Object.toQueryString(this.options.postBody); break;
			case 'string': data = this.options.postBody;
		}
		if (this._method) data = (data) ? [this._method, data].join('&') : this._method;
		var url = this.url+(this.url.test(/^.+\?.+/) ? '&' : '?')+'_r_='+$random(1, 1000000);
		return this.send(url, data);
	}
});

function set_tofrom(obj)
{
	function _chmode(name, mode)
	{
		var ar = document.getElementsByName(name);
		for (var i=0; i<ar.length; i++){
			ar[i].style.display = mode;	
		}
	}	
	if(obj.options[obj.selectedIndex].text == "") {
		return;
	}
	if (obj.options[obj.selectedIndex].value <= 2) {
		_chmode('countrysec', 'none');
		_chmode('customsec', '');
	} else {	
		_chmode('countrysec', '');
		_chmode('customsec', 'none');
	}
}

function openNewWindow(url, w, h)
{
	// open a blank window
	w = (w==null) ? 500 : w;
	h = (h==null) ? 400 : h;
	var aWindow = window.open(url.replace(/&popup=[^&]*/,'')+'&popup=1', '_blank',
	'scrollbars=yes,menubar=yes,resizable=yes,toolbar=no,top=0,left=0,width='+w+',height='+h);
}

var tbl;
inEditFlag = false;
function _numberData(txt)
{
		txt = txt.replace(/[^\d]*(\d*)(.*)/, '$1');
		if(Number(txt)==NaN || txt=='') {
			return 0;
		}
		return Number(txt);
}

function inEdit()
{
	if(inEditFlag){
		alert('لطفا سطر در حال ویرایش را ثبت کنید.');
		return true;
	}	
	return false;
}

function swapView(id)
{
	obj = document.getElementById('sub'+id);
	img = document.getElementById('icon'+id);
	if(obj.style.display!='block'){
		obj.style.display = 'block';
		if(img){
			img.src = '../images/btn-less.png';
			img.style.background = 'url(../images/btn-less.png)';
		}
	} else {
		obj.style.display = 'none';
		if(img){
			img.src = '../images/btn-more.png';
			img.style.background = 'url(../images/btn-more.png)';
		}
	}		
}

function swapDisplay(id)
{
	obj = document.getElementById(id);
	if(obj.style.display=='none'){
		obj.style.display = 'block';
	} else {
		obj.style.display = 'none';
	}		
}

function setCookie(cName, cValue)
{
	var argv = setCookie.arguments;
	var argc = setCookie.arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path = (argc > 3) ? argv[3] : null;
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	document.cookie = cName + "=" + escape (cValue) +
	((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
	((path == null) ? "" : ("; path=" + path)) +
	((domain == null) ? "" : ("; domain=" + domain)) +
	((secure == true) ? "; secure" : "");	
}

function getCookie(keyName)
{
	var nameEQ = keyName + "=";
	var ca = document.cookie.split (';');
	for (var i = 0; i < ca.length; i ++)
	{
		var c = ca [i];
		while (c.charAt (0) == ' ') c = c.substring (1, c.length);
		if (c.indexOf (nameEQ) == 0) return c.substring (nameEQ.length, c.length);
	}
	return null;
}

function deleteCookie(cName)
{
	setCookie(cName, "", -1);
}

function sortList(name, value)
{
	if(getCookie(name+'sortBy')!=value) {
		setCookie(name+'sortOrder', 'ASC');
	} else {
		setCookie(name+'sortOrder', getCookie(name+'sortOrder')=='DESC'?'ASC':'DESC');
	}
	setCookie(name+'sortBy', value);
	document.location.href = document.location.href.replace(/&page=[0-9]*/, '');
}

function sortList2(sortBy, sortMode, sortByVal, sortModeVal)
{
	setCookie(sortBy, sortByVal);
	setCookie(sortMode, sortModeVal);
	document.location.href = document.location.href.replace(/&page=([0-9]*)/g, '&page=1');
}

function filter(path, obj)
{
	var name = path + obj.name;
	var value = obj.options[obj.selectedIndex].value;
	setCookie(name, value);
	clearSearch();  // clear page & query and reload
}

function goto(page)
{
	// my paging is n=zzz this is the page number page are start from 1
	q = document.location.href;
	var patern = /^(.*)(\?|\&)page=(\d+)(\&?.*)$/;
	var reg = new RegExp(patern);
	if(!reg.test(q))
	{						// check if n=zzz dose not exists, add n=1 at the end of query
		var reg2 = new RegExp(/.*\?.*/);
		if(reg2.test (q))					// add ?n=zzz or &n=zzz
			q = q + "&page=1"; 
		else
			q = q + "?page=1";				
	}
	if(page == "prev")
	{						// goto previous page
		Page = Number(q.replace (patern, "$3")) - 1;
	}
	else
	{
		if(page=="next")
		{					// goto next page
			Page = Number(q.replace (patern, "$3")) + 1;
		}
		else
		{
			Page = Number(page);				// goto page n
		}
	}	
	q = q.replace(patern, "$1$2page=" + String(Page) + "$4");
	document.location.href = q;
}

function clearSearch()
{
	document.location.href = document.location.href.replace(/&query=[^&]*/, '').replace(/&page=[0-9]*/, '');		
}

function doDelete(action, objName, sender)
{
	while(sender = sender.parentNode){
		if(sender.className == objName || sender.id == objName || sender.name == objName){
			sender.style.display = 'none';
			if(sender.tagName=="TR") {
				sender.parentNode.deleteRow(sender.sectionRowIndex);
			}
			sendServerRequest(action);
			return true;
		}
	}
	return false;
}

ajaxDelete = doDelete;

var sdiv;
var active;
var trid;
var stime;

function findPosX(obj)
{
	var curleft = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	}
	else if (obj.x)
		curleft += obj.x;
	return curleft;
}

function findPosY(obj)
{
	var curtop = 0;
	if (obj.offsetParent)
	{
		while (obj.offsetParent)
		{
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	}
	else if (obj.y)
		curtop += obj.y;
	return curtop;
}

function setDetailContent(inp)
{
	document.getElementById('detail-content').innerHTML = inp;
	if(document.body.scrollTop + document.body.clientHeight < findPosY(myDiv) + myDiv.offsetHeight){
		myDiv.style.top = (document.body.scrollTop + document.body.clientHeight - myDiv.offsetHeight)+'px';
	}
	myDiv.style.width = null;
}

var myDiv
function showDetail(section, module, id, obj)
{
	if(!myDiv){
		myDiv = document.createElement('DIV');
		myDiv.className='detail';
		myDiv.id='myDiv';
		document.body.appendChild(myDiv);
		myDiv.innerHTML = '<div id="detail-top" class="detail-top"><span style="width: 350px;"></span></div><div><div id="detail-content" class="detail-content" dir="rtl">	Please wait ...<br /><br /><br /><br /><br /><br /><br /><br /><br />	</div></div';
		
		var prn = new Image();
		prn.src = '../images/print.gif';
		prn.style.margin = '3px';
		prn.style.background = 'url(../images/print.gif)';
		prn.style.cursor = 'pointer';
		prn.style.height = '16px';
		prn.style.width = '16px';
		prn.onclick = printDetail;
		document.getElementById('detail-top').appendChild(prn);		
		
		var img = new Image();
		img.src = '../images/close.gif';
		img.style.margin = '3px';
		img.style.background = 'url(../images/close.gif)';
		img.style.cursor = 'pointer';
		img.style.height = '16px';
		img.style.width = '16px';
		img.onclick = function (){myDiv.style.display='none'};
		document.getElementById('detail-top').appendChild(img);
	}
	var wait = '<span dir="ltr">Please wait...</span>';
	document.getElementById('detail-content').innerHTML ='<div align="center" style="height: 100px; width: 350px; padding-top: 40px;">' + wait + '</div>';
	with(myDiv.style){
		position = 'absolute';
		display = "block";
		top = findPosY(obj) + 'px';
		if(document.body.scrollTop + document.body.clientHeight < findPosY(obj) + myDiv.offsetHeight){
			top = document.body.scrollTop + document.body.clientHeight - myDiv.offsetHeight;
		}
		left = (findPosX(obj) + 50) + 'px';
	}
	new ajax('index.php?section='+section+'&module='+module+'-detail&'+module+'id_frm='+id, {onComplete: setDetailContent, evalScripts:false}).request();
}

function printDetail()
{
	tbody = document.body.innerHTML;
	document.body.innerHTML = $('detail-content').parentNode.innerHTML+
			"<div align=right style='margin: 20px;' class='noprint form-input'><input type='button' value='Return' style='width:130px;' onclick='document.body.innerHTML=tbody;myDiv=$(\"myDiv\");myDiv.parentNode.removeChild(myDiv);myDiv = null;' />";
	window.print();	
}

function add_event(obj, evType, fn)
{ 
	if (obj.addEventListener){ 
		obj.addEventListener(evType, fn, false); 
		return true; 
	} else if (obj.attachEvent){ 
		var r = obj.attachEvent("on"+evType, fn); 
		return r; 
	} else { 
		return false; 
	} 
}

function trace(obj)
{
	if(typeof(obj)=='object'){
		var prop = '';
		var p;
		for(p in obj){
			prop += p + ' => ' + obj[p] + '<br>\n';
		}
		var ch = document.createElement('div');
		document.body.appendChild(ch);
		ch.innerHTML = prop;
		ch.style.margin = ch.style.padding = '20px';
		ch.style.border = '1px solid #333333';
	}
}

function findObject(obj) //find an object from id, name, or its classname 
{
	if(typeof(obj)=='object' && obj) return obj;
	var src = $(obj);
	if(typeof(src)=='object' && src) return src;
	src = _(obj)[0];
	if(typeof(src)=='object' && src) return src;
	var elementList = getAllChilds(document);
	for(var i=0; i<elementList.length; i++){
		if(elementList[i].className == obj) return elementList[i];
	}
	return null;
}

$ = typeof($)!='undefined' ? $:function(id){return document.getElementById(id)};
_ = function(name)
{
	var res = Array();
	if(!is_ie) {
		return document.getElementsByName(name);
	} else {
		// in ie document.getElementsByName just works for form elements. this is the fix up code
		var obj = document.getElementsByName(name);
		if (obj.length) return obj;
		var elementList = getAllChilds(document);
		var cnt = 0;
		for(var i=0; i<elementList.length; i++){
			if(elementList[i].name == name) res[cnt++] = elementList[i];
		}
	}
	return res;
}

function setSub(source, destination, opts, cnt, def)
{	
	if(opts) {
		var src = findObject(source);
		var dest = findObject(destination);
		if(!src || !dest) {
			return;	
		}
		var pid = (src.selectedIndex >= 0) ? src.options[src.selectedIndex].value : 0;
		var cnt2= 0;

		while(dest.options.length && dest.options[cnt]) {
			if(dest.options.length==1){
				dest.options[cnt] = new Option('', '');
				break;
			} else  {
				dest.options[cnt] = null;	//remove all options
			}
		}
		if(opts[pid]) {
			while(opts[pid][cnt2]) {
				ar = opts[pid][cnt2++].split("*:-)");
				dest.options[cnt++] = new Option(ar[1], ar[0]);		//add new options
			}
			if(def){
				dest.value = def;
			}
		}
	}
}

function checkBoxes(fmobj)
{
	for(var i = 0; i < fmobj.elements.length; i ++)
	{

		var e = fmobj.elements[i];
		if((e.type == 'checkbox') && (e.type == 'checkbox') && (e.checked == true))
		{
			return true;
		}
	}	
}

function checkAll(fmobj)
{
	for(var i = 0; i < fmobj.elements.length; i ++)
	{
		var e = fmobj.elements[i];
		if((e.name != 'allbox') && (e.type == 'checkbox') && (!e.disabled))
		{
			e.checked = fmobj.allbox.checked;
		}
	}
}

function checkCheckedAll(fmobj)
{	
	var TotalBoxes = 0;
	var TotalOn = 0;
	for(var i = 0; i < fmobj.elements.length; i ++)
	{
		var e = fmobj.elements[i];
		if((e.name != 'allbox') && (e.type == 'checkbox'))
		{
			TotalBoxes ++;
			if(e.checked)
			{
				TotalOn ++;
			}
		}
	}
	
	if (TotalBoxes == TotalOn)
	{
		fmobj.allbox.checked = true;
		return -1;		// all of them checked
	}
	else
	{
		fmobj.allbox.checked = false;
		return TotalOn;	// none of them checked=0 else some of them checked
	}
}

function saveForm(frm, loc, duration)
{
	Cookie.set(loc, $(frm).toQueryString(), {duration: duration});
}

function loadForm(frm, loc)
{
	frm = $(frm);
	var savedVal = Cookie.get(loc) ? '&'+Cookie.get(loc)+'&' : '';
	if(frmid = frm.id){
		var list = $$('#'+frmid+' INPUT, #'+frmid+' SELECT, #'+frmid+' TEXTAREA');
		for(var i=0; i<list.length; i++){
			var ch = list[i];
			if(ch.type && ch.type.test(/button|submit|reset|file|image|hidden/ig) || !ch.name) continue;
			//alert(ch.type+ch.type.test(/password|button|submit|reset|file|image|hidden/ig));
			var reg = new RegExp('^.*&'+encodeURIComponent(ch.name)+'=([^&]*)&.*$');
			var val = decodeURIComponent(savedVal.replace(reg, '$1'));
			val = val.charAt(0)=='&' ? '' : val;
			//alert(reg + '\n' + val);
			if(val){
				if(ch.type && (ch.type=='checkbox' || ch.type=='radio')){
					ch.checked = (ch.value == val);
				} else {
					ch.value = val;
				}
			}
		}
	}
}


//------------ report module ---------
function checkBetween(id)
{
	var sel = findObject('operator['+id+']');
	var val = findObject('value['+id+']');
	var bet = findObject('between'+id);
	if(sel.options[sel.selectedIndex].value=='BETWEEN') {
		bet.style.display='';
		val.style.display='none';
	} else if(sel.options[sel.selectedIndex].value=='IS NOT NULL' || sel.options[sel.selectedIndex].value=='IS NULL') {
		bet.style.display='none';
		val.style.display='none';
	} else {
		bet.style.display='none';
		val.style.display='';		
	}
}
//------------/report module ---------

//------------ mail module ---------
function saveMail(id)
{
	findObject('cmd').value = 'save';
	if(id){		
		findObject('frm_id').value = id;
	}
	findObject('form1').submit();
}

function sendMail(type)
{
	findObject('cmd').value = 'send';
	if(type){		
		findObject('type').value = type;
	}
	findObject('form1').submit();	
}
//------------/mail module ---------
