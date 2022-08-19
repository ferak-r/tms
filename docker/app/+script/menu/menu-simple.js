var overid;
var inTime = 200;
var outTime = 500;
var tout;
var $ = function(id){return document.getElementById(id);}
var tuneX = 6;
var tuneY = 0; 
function menuOver(obj)
{
	var id = obj.id.replace(/menu_/g, '');
	obj.onmouseout = function(){menuOut(this)};
	obj.onclick = function(){menuClick(this)};
	overid = id;
	status = overid;
	clearTimeout(tout);
	tout = setTimeout('showMenu(0);', inTime);
}

function menuOut(obj)
{
	var id = obj.id.replace(/menu_/g, '');
	overid = null;
	clearTimeout(tout);
	tout = setTimeout('hideMenu(0);', outTime);	
}

function menuClick(obj)
{
	var id = obj.id.replace(/menu_/g, '');
	overid = id;
	showMenu(id);
}

function showMenu(id)
{
	id = (id==0) ? overid : id;
	var menu = $('menu_'+id);
	var submenu = $('submenu_'+id);
	if(submenu && overid){
		var i=1;
		overid=null;
		while($('submenu_'+i)){
			if(i!=id){
				hideMenu(i);
			}
			i++;
		}
		submenu.style.top = (findPosY(menu)+tuneY)+'px';
		submenu.style.left = (findPosX(menu)-submenu.clientWidth+tuneX)+'px';
		submenu.style.visibility = 'visible';
		submenu.onmouseover = function(){subOver(this)};
		submenu.onmouseout = function(){subOut(this)};
		submenu.onclick = function(){subClick(this)};
		overid = id;
	}	
}

function hideMenu(id)
{		
	var submenu = $('submenu_'+id);
	if(id==0){
		var i=1;
		while($('submenu_'+i)){
			hideMenu(i);
			i++;
		}
	} else {
		if(!overid && submenu){
			submenu.style.visibility = 'hidden';
		}	
	}
}

function subOver(obj)
{
	var id = obj.id.replace(/submenu_/g, '');
	overid = id;
}

function subOut(obj)
{
	var id = obj.id.replace(/submenu_/g, '');
	overid = null;
	clearTimeout(tout);
	tout = setTimeout('hideMenu(0);', outTime);	
}

function subClick(obj)
{
	var id=obj.id.replace(/submenu_/g, '');
	overid=null;
	hideMenu(id);
}

function activateTab(n)
{
	var i=1;
	var tab;
	while(tab=$('tab'+i)){
		if(i != n){	
			tab.className = 'tab';
			$('tab'+i+'_content').style.display = 'none';	
		} else {
			tab.className = 'tab_active';
			$('tab'+i+'_content').style.display = '';			
		}		
	}
}

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