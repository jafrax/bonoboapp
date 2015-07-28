$(function() {
    //Date range picker
    $('#tanggalindong').daterangepicker();
});
$(document).ready(function() {
    $('#form-account-edit').validate({
        rules:{
            namaedit        : {required: true}
        },
        messages: {
            namaedit: {
                required: ("Name cannot be empty"),
            }
        },
    });
	$('#form-account').validate({
        rules:{
            name        : {required: true,maxlength:50},
            username    : {required: true,email:true,maxlength:100,remote: base_url+"admin/account/rules_username"},
            password    : {required: true,minlength:5,maxlength:50},
            repassword  : {required: true,equalTo:'#exampleInputPassword1'}
        },
        messages: {
            name: {
                required: message_alert("Field Nama tidak boleh kosong"),
                maxlength: message_alert("maksimal 50 karakter"),
            },
            username: {
                required: message_alert("Field Email tidak boleh kosong"),
                maxlength: message_alert("maksimal 100 karakter"),
                remote: message_alert("Email ini telah digunakan"),
            },
            password: {
                required: message_alert("Field Password tidak boleh kosong"),
                minlength: message_alert("minimal 5 karakter"),
                maxlength: message_alert("maksimal 50 karakter"),
            },
            repassword: {
                required: message_alert("Field Ulangi password tidak boleh kosong"),
                equalTo: message_alert("Password tidak sama dengan new password"),
            }
        },
    });
	$('#form-change-account').validate({
        rules:{
            change_pass     : {required: true,minlength:5,maxlength:50},
            change_new_pass : {required: true,equalTo:'#change_pass'}
        },
        messages: {
            change_pass: {
                required: message_alert("Password cannot be empty"),
                minlength: message_alert("Min length 5 characters"),
                maxlength: message_alert("Max length 50 characters"),
            },
            change_new_pass: {
                required: message_alert("Retype password cannot be empty"),
                equalTo: message_alert("Please enter the same password"),
            }
        },
    });
})
function account_reset_modal(id,name) {
    $(".body-delete > p").html("Kamu yakin untuk reset "+atob(name)+"'s Password ? ");
    $(".delete-ok").show().attr("onclick","account_reset('"+id+"')");
    $("#delete-confirm").modal("show");
}
function account_reset(id) {
    $.ajax({
        type    : "POST",
        url     : base_url+"admin/account/reset",
        data    : "id="+id,
        dataType: 'json',
        success : function(response){
            if (response.msg == "success") {
                $("#delete-confirm").modal("hide");
                return;
            }
        },
        error : function(){
            
        }
    });
}
function new_data(selection) {
    $('#'+selection).slideDown();
}
function cancel_data(selection) {
    var form    = selection.replace("box-", "");
    $('#'+form)[0].reset();
    $('label.error').hide();
    $('#'+selection).slideUp();
}
function account_modal(id) {
$.ajax({
	type    : "POST",
	url     : base_url+"admin/account/edit",
	data    : "getid="+id,
	dataType: 'json',
	success : function(response){
		if (response.msg == "success") {
			var data = response[0];
			idedit      = data.id;
			$("#box-form-account-edit").modal("show").on('shown.bs.modal', function () {				
				$("#namaedit").val(data.name).focus();
				$("#idedit").val(data.id);
			});
		}
	},
	error : function(){
		
	}
});
}

function submit_data_edit(selection,url) {
    if ($("#"+selection).valid()) {
        $.ajax({
            type    : "POST",
            url     : base_url+url,
            data    : $("#"+selection).serialize(),
            dataType: 'json',
            success : function(response){
                if (response.msg == "success") {
                    $("#nama-"+idedit).html($("#namaedit").val());
                    $(".modal").modal("hide");
                }else{
                    
                }
            },
            error : function(){
                
            }
        });
    }
}