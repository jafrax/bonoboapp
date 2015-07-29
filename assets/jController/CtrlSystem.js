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

function $hs_notif(c,e){
	var component = $(c);
	component.html(e);
	component.slideDown("slow");
	component.delay(5000).slideUp("slow");
}

function Messagebox_alert(e){
	return "<div class='messagebox messagebox-alert'><div class='o'>"+e+"</div></div>";
}

function Messagebox_info(e){
	return "<div class='messagebox messagebox-info'><div class='o'>"+e+"</div></div>";
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

$(function(){
		//select active nav
	var link=window.location;
	$('ul.nav li a[href="'+link+'"]').parent().addClass("active");
	
	//pagination
	$(document).on('click','.pagination li a',function() {
		var url = $(this).attr('href');		
		$.ajax({
			type	: 'POST',
			data	: 'ajax=1',
			url		: url,
			success: function(msg) {				
				$('#div-paging').html(msg);
				checkall();
			}
		});
		return false;
	});	
		
	//checkall cehckbox
	$("table").on('click', '#checkall', function () {
		$(this).parents('table:eq(0)').find(':checkbox').prop('checked', this.checked);
	});
});

function checkall(args) {
    $("table").on('click', '#checkall', function () {
        $(this).parents('table:eq(0)').find(':checkbox').prop('checked', this.checked);
	});
}
//on click del
function delete_table(url) {
	var values =   $('input:checkbox:checked.checkboxDelete').map(function (){
        return this.value;
    }).get();
	if(values == ""){
        $(".body-delete > p").html("No selected data");
        $(".delete-ok").hide();
    }else{
        $(".body-delete > p").html("Apakah anda yakin untuk menghapus data ini ?");
        $(".delete-ok").show().attr("onclick","delete_data('"+values+"','"+url+"')");
    }
}
//del select
function delete_data(values,url) {
    $.ajax({
		type    : "POST",
        url     : base_url+url,
        data    : {delete:values},
        success : function(){    
                location.reload();        
        },
        error : function(){
            
        }
    });
}
//del search
function search(id,url) {
    $.ajax({
        type	: 'POST',
        data	: 'search='+$(id).val(),
        url		: base_url+url,
        success: function(msg) {
            $('#div-paging').html(msg);
			checkall();
        }
    });
}
function key_enter(event,selection,url) {
	if(event.which == 13){
		submit_data(selection,url);
        event.preventDefault();
	} 
}
function press_enter(event,selection) {
    if(event.which == 13){
		$(selection).click()
        event.preventDefault();
	}
    
}
//add
function submit_data(selection,url) {
    if ($("#"+selection).valid()) {
        $.ajax({
            type    : "POST",
            url     : base_url+url,
            data    : $("#"+selection).serialize(),
            dataType: 'json',
            success : function(response){
                if (response.msg == "success") {
                   top.location.reload();
                }else{
 
                }
            },
            error : function(){

            }
        });
    }else{
           
    }
}
$(document).ready(function() {
    $.validator.setDefaults({
        ignore: []
    });
    
    $('#form-change-password').validate({
        rules:{
            oldpass     : {required: true,remote: base_url+"admin/account/rules_password"},
            newpass     : {required: true,minlength:4,maxlength:50},
            renewpass   : {required: true,equalTo:'#newpass'}
        },
        messages: {
            oldpass: {
                required: message_alert("Old password cannot be empty"),
                remote: message_alert("Old password is wrong"),
            },
            newpass: {
                required: message_alert("Password cannot be empty"),
                minlength: message_alert("Min length 5 characters"),
                maxlength: message_alert("Max length 50 characters"),
            },
            renewpass: {
                required: message_alert("Retype password cannot be empty"),
                equalTo: message_alert("Please enter the same password"),
            }
        },
    });
})

function change_password(selection,url) {
    if ($("#"+selection).valid()) {
        $.ajax({
            type    : "POST",
            url     : base_url+url,
            data    : $("#"+selection).serialize(),
            dataType: 'json',
            success : function(response){
                if (response.msg == "success") {
                    $('#'+selection)[0].reset();
                    $("label.error").hide();
                    $(".modal").modal("hide");
                }else{
                    
                }
            },
            error : function(){
                
            }
        });
    }
}

function klik (a) {
    $('#'+a).click();
}

function picture_upload(id){   
   var URL     = window.URL || window.webkitURL;
   var input   = document.querySelector('#'+id);
   var preview = document.querySelector('#'+id+'-add');
   preview.src = URL.createObjectURL(input.files[0]); 

}