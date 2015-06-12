var folderUrl = "visione/Vertibox/";

function CtrlSystem(){
	this.init = init;
	this.alert = alert;
	this.showCalendar = showCalendar;
	this.initPagination = initPagination;
	
	function init(){
		initPagination();
	}
	
	
	function showCalendar(c){
		$(c).focus();
	}
	
	function addJavascript(id,file){
		var component, js, parent;
		
		component = document.createElement('script'); 
		component.type = 'text/javascript';
		component.id = id;
		component.src = file;
		
		parent = document.getElementsByTagName('head')[0];
		parent.appendChild(component);
	}
	
	function initPagination(){
		 $(document).on('click','.paging-1 a',function() {
			var url = $(this).attr('href');				
			$.ajax({
				type: 'POST',
				data: 'ajax=1',
				url: url,
				success: function(msg) {
					$('#div-paging-1').html(msg);
				}
			});
			return false;
		 });
		 
		 $(document).on('click','.paging-2 a',function() {
			var url = $(this).attr('href');				
			$.ajax({
				type: 'POST',
				data: 'ajax=1',
				url: url,
				success: function(msg) {
					$('#div-paging-2').html(msg);
				}
			});
			return false;
		 });
	}
	
}

function $hs(e){
	return document.getElementById(e);
}

function $hs_getService(a){
	return JSON.parse($hs_base64_decode(a));
}

function $hs_base64_encode(a){
	return window.btoa(a);
}

function $hs_base64_decode(a){
	return a;
}

function Messagebox_alert(e){
	return "<div class='messagebox messagebox-alert'><div class='o'><img src='"+base_url+"assets/icon/icon_alert_red.png' /></div><div class='o'>"+e+"</div></div>";
}

function Messagebox_info(e){
	return "<div class='messagebox messagebox-info'><div class='o'><img src='"+base_url+"assets/icon/icon_info_black.png' /></div><div class='o'>"+e+"</div></div>";
}

function Messagebox_timer(){
	$('.messagebox').delay(5000).slideUp('slow');
	$('.alert').delay(5000).slideUp('slow');
}

function $hs_getDate4String(a){
	var list = a.split('-');
	return list[2]+' '+getMonth4String(list[1])+' '+list[0];
}



function initComboBox(){
	var config = {
	  '.chzn-select'           : {search_contains:true},
	  '.chzn-select-deselect'  : {allow_single_deselect:true},
	  '.chzn-select-no-single' : {disable_search_threshold:0},
	  '.chzn-select-no-results': {no_results_text:'Oops, nothing found!'},
	  '.chzn-select-width'     : {width:"100%"}
	}

	for (var selector in config) {
	  $(selector).chosen(config[selector]);
	}
}

function $hs_getMonth4String(a){
	switch(a){
		case '01': return 'Januari'; break;
		case '02': return 'Februari'; break;
		case '03': return 'Maret'; break;
		case '04': return 'April'; break;
		case '05': return 'Mei'; break;
		case '06': return 'Juni'; break;
		case '07': return 'Juli'; break;
		case '08': return 'Agustus'; break;
		case '09': return 'September'; break;
		case '10': return 'Oktober'; break;
		case '11': return 'November'; break;
		case '12': return 'Desember'; break;
		case '1': return 'Januari'; break;
		case '2': return 'Februari'; break;
		case '3': return 'Maret'; break;
		case '4': return 'April'; break;
		case '5': return 'Mei'; break;
		case '6': return 'Juni'; break;
		case '7': return 'Juli'; break;
		case '8': return 'Agustus'; break;
		case '9': return 'September'; break;
	}
}

function $hs_onEnter(e){
	e.which = e.which || e.keyCode;
	if(e.which == 13){
		return true;
	}else{
		return false;
	}
}

function onlyNumber(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
