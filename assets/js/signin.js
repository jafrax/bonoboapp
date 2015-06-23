$(function(){
	//pagination
	$(document).on('click','#pagination a',function() {
		var url = $(this).attr('href');
		start_loader();
		$.ajax({
			type	: 'POST',
			data	: 'ajax=1',
			url		: url,
			success: function(msg) {
				end_loader();
				$('[data-tooltip]').tooltip();
				$('#div-paging').html(msg);
			}
		});
		return false;
	});
	
});

//login register forgot//

$(document).ready(function() {
    $('#form-signup').validate({
        rules:{
            name        : {required: false,maxlength:50},
            position    : {required: false,maxlength:50},
            email       : {required: true,email:true,maxlength:100,remote: base_url+"login/rules_email"},
            password    : {required: true,minlength:5,maxlength:50},
            repassword  : {required: true,equalTo:'#password'},
            phone       : {required: false,minlength:7,maxlength:15},
        },
        messages: {
            name: {
                required: message_login_signup("Name cannot be empty"),
                maxlength: message_login_signup("Max length 50 characters"),
            },
            position: {
                maxlength: message_login_signup("Max length 50 characters"),
            },
            email: {
                required: message_login_signup("Email cannot be empty"),
                email: message_login_signup("Please enter a valid email address"),
                maxlength: message_login_signup("Max length 100 characters"),
                remote: message_login_signup("This Email is already used"),
            },
            password: {
                required: message_login_signup("Password cannot be empty"),
                minlength: message_login_signup("Min length 5 characters"),
                maxlength: message_login_signup("Max length 50 characters"),
            },
            repassword: {
                required: message_login_signup("Retype password cannot be empty"),
                equalTo: message_login_signup("Please enter the same password"),
            },
            phone: {
                minlength: message_login_signup("Min length 7 characters"),
                maxlength: message_login_signup("Max length 15 characters"),
            },
        },
        showErrors: function(map, list) {
            $('.message-sign-area-signup').html('')
            $('.form-control-feedback').hide();
            $.each(list, function(index, error) {
                $('.message-sign-area-signup').html(list[0].message);
                $('#'+list[0].element.id).after("<span class='glyphicon glyphicon-exclamation-sign form-control-feedback sign-icon-form' aria-hidden='true'></span>");
            });
        }
    });
    
    $('#form-login').validate({
        rules:{
            email_login: {required: true,email:true},
            password_login: {required: true},
        },
        messages: {
            email_login: {
                required: message_login_signup("Email cannot be empty"),
                email: message_login_signup("Please enter a valid email address"),
            },
            password_login: {
                required: message_login_signup("Password cannot be empty"),
            }
        },
        showErrors: function(map, list) {
            $('.message-sign-area').html('');
            $('.form-control-feedback').hide();
            $.each(list, function(index, error) {
                $('.message-sign-area').html(list[0].message);
                $('#'+list[0].element.id).after("<span class='glyphicon glyphicon-exclamation-sign form-control-feedback sign-icon-form' aria-hidden='true'></span>");
            });
            
        }
    });
    $('#form-forgot').validate({
        rules:{
            email: {required: true, email:true},
            recaptcha_response_field: {required: true},
        },
        messages: {
            email: {
                required: message_login_signup("Email cannot be empty"),
                email: message_login_signup("Please enter a valid email address"),
            },
            recaptcha_response_field: {
                required: message_login_signup("Captcha cannot be empty"),
            }
        },
        showErrors: function(map, list) {
            $('.message-sign-area-forgot').html('');
            $('.form-control-feedback').hide();
            $.each(list, function(index, error) {
                $('.message-sign-area-forgot').html(list[0].message);
                if (list[0].element.id != 'recaptcha_response_field') {
                    $('#'+list[0].element.id).after("<span class='glyphicon glyphicon-exclamation-sign form-control-feedback sign-icon-form' aria-hidden='true'></span>");
                }
            });
            
        }
    });
	
	$('#form-change-password').validate({
        rules:{
            old			: {required: true},
            newpass		: {required: true,minlength: 5,maxlength:20},
			renewpass	: {required: true,equalTo :"#new-password"},
        },
        messages: {
            old: {
                required: message_login_signup("Old password cannot be empty"),
            },
            newpass: {
                required: message_login_signup("New password cannot be empty"),
				minlength: message_login_signup("Min length is 5"),
				maxlength: message_login_signup("Max length is 20"),
            },
			renewpass: {
                required: message_login_signup("Renew password cannot be empty"),
				equalTo: message_login_signup("Renew Password is false"),
            },
        },
        showErrors: function(map, list) {
            $('.message-change-password-area').html('');
            $('.form-control-feedback').hide();
            $.each(list, function(index, error) {
                $('.message-change-password-area').html(list[0].message);
                $('#'+list[0].element.id).after("<span class='glyphicon glyphicon-exclamation-sign form-control-feedback sign-icon-form' aria-hidden='true'></span>");
            });
            
        }
    });
    
});

function form_change_password(args) {
	
	if ($("#form-change-password").valid()) {
		$(".cp-btn").html("<input type='button' class='form-control-reset' value='LOADING' >");
		$.ajax({
            type	: "POST",
			url		: base_url+'login/change_password',
            data	: $('#form-change-password').serialize(),
            dataType: 'json',
            success : function(data){    
                if (data.msg == "success") {
					$('#form-change-password')[0].reset();
					$(".frame-change-password").modal("hide");
				}else{
					$('.message-change-password-area').html(message_login_signup(data.notif));
				}
				$(".cp-btn").html("<input type='button' class='form-control-reset' value='CHANGE PASSWORD' onclick=javascript:form_change_password()>");
            },
            error : function(){
				$(".cp-btn").html("<input type='button' class='form-control-reset' value='CHANGE PASSWORD' onclick=javascript:form_change_password()>");
                $('.message-change-password-area').html(message_login_signup('System error. Please try again later'));
            }
        });
	}
}
function clear_form_sign() {
	$('.message-sign-area').html('');
	$('.sign-icon-form').hide();
}

function form_login() {
	if ($('#form-login').valid()) {
		$.ajax({
            type: "POST",
			url: base_url+'login/index',
            data: $('#form-login').serialize(),
            success : function(response){
				if (response == 'sukses') {
					top.location.reload();
				}else{
					$('.message-sign-area').html(message_login_signup(response));
				}
            },
            error : function(){
                $('.message-sign-area').html(message_login_signup('System error. Please try again later'));
            }
        });
	}
}

function key_enter(e,mode) {
	if(e.which == 13){
		if(mode == 1){
			form_signup();
		}else if(mode == 2){
			form_login();
		}else if (mode == 3) {
			form_create_account();
		}else if (mode == 4) {
			form_edit_account();
		}else if (mode == 5) {
			add_to_contact(e);
		}
		else if (mode == 6) {
			send_mail_contact(e);
		}else if (mode == 7) {
			form_change_password(e);
		}
	} 

}

function form_signup() {
	if ($('#form-signup').valid()) {
		$.ajax({
            type: "POST",
			url: base_url+'login/signup',
            data: $('#form-signup').serialize(),
            success : function(response){
				if (response == 'sukses') {
					top.location.href = base_url+'login/direct_signup';
				}else{
					$('.message-sign-area-signup').html(message_login_signup(response));
				}
            },
            error : function(){
                $('.message-sign-area-signup').html(message_login_signup('System error. Please try again later'));
            }
        });
	}
}


function form_forgot() {
	if ($('#form-forgot').valid()) {
		$.ajax({
            type: "POST",
			url: base_url+'login/forgot_password',
            data: $('#form-forgot').serialize(),
            success : function(response){
				if (response == 'sukses') {
					$('.message-sign-area-forgot').html(message_login_signup_success('Hi, Please check your email to reset your password'));
					$('#form-forgot')[0].reset();
					jQuery("#recaptcha_reload").click(); 
				}else{
					$('.message-sign-area-forgot').html(message_login_signup(response));
					jQuery("#recaptcha_reload").click(); 
				}
            },
            error : function(){
                $('.message-sign-area-forgot').html(message_login_signup('System error. Please try again later'));
            }
        });
	}
}

//=====================//



function resend_email(url) {
	message     = 'Failed to resend email verification'
	notif       = ''
	type_notif  = 'error'
	$.ajax({
		type: "POST",
		url: base_url+url,
		data: 'email=eksempel@mail.com',
		success : function(data){
			if (data == 'success') {
				message     = 'Resend email verification success';
				notif       = '';
				type_notif  = 'success';
				alert_verti(message,3);
			}else{
				alert_verti(message,3);
			}
		},
		error : function(){
			alert_verti(message,3);
		}
	});	
}


//error message validation setting//
function message_login_signup(e) {
	return "<div class='signup-message-sign error-message-sign' style='display: inline-block;'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> "+e+"</div>";
}

function message_login_signup_success(e) {
	return "<div class='signup-message-sign success-message-sign' style='display: inline-block;'><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span> "+e+"</div>";
}


function viewMoreCat(id){
    $('.cat-list-'+id).slideDown();
}


function to_resend_email(e,pass) {
	message     = 'Failed to resend email verification'
	notif       = ''
	type_notif  = 'error'
	$.ajax({
		type	: "POST",
		url		: base_url+"login/to_resend_email",
		data	: 'email='+e+"&code="+pass,
		success : function(data){
			if (data == 'success') {
				message     = 'Resend email verification success';
				$('.message-sign-area').html(message_login_signup(message));
			}else{
				$('.message-sign-area').html(message_login_signup(message));
			}
		},
		error : function(){
			alert_verti(message,3);
		}
	});	
}

