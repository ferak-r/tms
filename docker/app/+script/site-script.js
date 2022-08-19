function updateCombos(tbl, value, comboName, width){
	new Ajax('index.php?section=admin&module=combo-admin&table='+tbl+'&cmd=combooutput&frm_name='+encodeURI(value)+'&comboname='+comboName+'&width='+width, { update:comboName+'_span' , method:'get', evalScripts:true }).request();
	$(comboName+'_span').innerHTML = '<img src="../images/loading.gif" width="16" height="16" border="0" alt="loading" style="margin-right: 100px;" />';
}
function swapLinkDisplay(obj, tbl, update, width){
	if(obj.style.display == 'none'){ 
		$(obj.name+'_cancle').style.display = 'none'; 
		if(update == 1){
			updateCombos(tbl, $(obj.name+'_new').value, obj.name, width); 
		}
		$(obj.name+'_ok').innerHTML = 'New '+tbl;
		obj.style.display = 'inline'; 
		$(obj.name+'_new').style.display = 'none'; 
	}else{ 
		$(obj.name+'_ok').innerHTML = '<img src=../images/icons/16x16/ok.png border=0px>'; 
		obj.style.display = 'none'; 
		$(obj.name+'_new').style.display = 'inline'; 
		$(obj.name+'_cancle').style.display='inline';
	}
}
function newFileInput(){
	var filenum	   = parseInt($('frm_filenum').value);
	var fileinput  = document.createElement('input');
	fileinput.type = 'file';
	fileinput.name = 'frm_file' + (filenum + 1);
	$('frm_filebox').appendChild(fileinput);
	$('frm_filenum').value = filenum + 1;
}
function equipmentChanged(){
	var form1 = document.forms['form1'];
	form1.frm_equipment.disabled=false;
	form1.frm_chassisno.disabled=false;
	form1.frm_certificate.disabled=false;
	form1.frm_vsltype.disabled=false;
	
	if(form1.frm_equipmentcat.value == 1){
		form1.frm_equipment.disabled='disabled';
		form1.frm_vsltype.disabled='disabled';
	}
	if(form1.frm_equipmentcat.value == 2){
		form1.frm_chassisno.disabled='disabled';
		form1.frm_certificate.disabled='disabled';
	}
	
	$$('#form1 INPUT, #form1 SELECT, #form1 TEXTAREA').each(function(el){
		var pr = el.getParent().getParent().getParent();
		if(el.disabled && pr.tagName=='TR') 
			pr.addClass('hidden');
		else	
			pr.removeClass('hidden');
	});
}
function getNumber(valueStr){
      var iValue = parseFloat(valueStr);
      if(isNaN(iValue)){
            return 0;
      }
      return iValue;
}
function changeSum(){
	var t = $("frm_totalamount").value = getNumber($("frm_duzvolagh").value)+getNumber($("frm_escort").value)+getNumber($("frm_overweight").value)+getNumber($("frm_imco").value)+getNumber($("frm_etcamount").value);
	var r = $("frm_remain").value = t - getNumber($("frm_agent").value) - getNumber($("frm_prepaidamount").value);
	$("frm_collectamount").value = r - getNumber($("frm_deliverylateamount").value);
}
