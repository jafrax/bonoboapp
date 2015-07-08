function CtrlSignup(){
	this.init = init;
	this.onEnter= onEnter;
	
	var btnSave;
	var formSignup,formSignupJQuery;
	var notifName,notifEmail,notifPassword,notifRepassword;
	var lblNotif;
	
	function init(){
		initComponent();
		initEventlistener();
		initValidation();
	}
	
	function initComponent(){
		btnSave = $hs("btnSave");
		formSignup = $hs("formSignup");
		formSignupJQuery = $("#formSignup");
		notifName = $("#notifName");
		notifEmail = $("#notifEmail");
		notifPassword = $("#notifPassword");
		notifRepassword = $("#notifRepassword");
		lblNotif = $("#lblNotif");
	}
	
	function initEventlistener(){
		btnSave.onclick = function(){
			doSave();
		};
	}
	
	function onEnter(event){
		if ($hs_onEnter(event)){
			doSave();
		}
	
	}

	function initValidation(){
		formSignupJQuery.validate({
			rules:{
				name : {
					required: true,
					minlength:5,
					maxlength:50,
				},
				email: {
					required: true,
					email: true,
					maxlength:50,
					remote:base_url+'index/cek_mail',
				},
				password: {
					required: true,
					minlength:5,
					maxlength:50,
				},
				rePassword: {
					required: true,
					minlength:5,
					maxlength:50,
				},
			},
			messages: {
				name:{
					required: message_alert("Field ini dibutuhkan"),
					minlength: message_alert("Masukkan minimal 5 karakter"),
					maxlength: message_alert("Masukkan maksimal 50 karakter"),
				},
				email:{
					required: message_alert("Field ini dibutuhkan"),
					email: message_alert("Email tidak valid"),
					maxlength: message_alert("Masukkan maksimal 50 karakter"),
					remote: message_alert("Maaf email sudah digunakan, silahkan masukkan email lainnya"),
				},
				password:{
					required: message_alert("Field ini dibutuhkan"),
					minlength: message_alert("Masukkan minimal 5 karakter"),
					maxlength: message_alert("Masukkan maksimal 50 karakter"),
				},
				rePassword:{
					required: message_alert("Field ini dibutuhkan"),
					minlength: message_alert("Masukkan minimal 5 karakter"),
					maxlength: message_alert("Masukkan maksimal 50 karakter"),
				},
			}
		});
	}
	
	function doSave(){
		var valid = true;
		
		if(formSignup.name.value == ""){
			notifName.slideDown();
			notifName.delay(5000).slideUp('slow');
			valid = false;
		}
		
		if(formSignup.email.value == ""){
			notifEmail.slideDown();
			notifEmail.delay(5000).slideUp('slow');
			valid = false;
		}
		
		if(formSignup.password.value == ""){
			notifPassword.slideDown();
			notifPassword.delay(5000).slideUp('slow');
			valid = false;
		}
		
		if(formSignup.rePassword.value == ""){
			notifRepassword.slideDown();
			notifRepassword.delay(5000).slideUp('slow');
			valid = false;
		}
		
		if(formSignup.password.value != formSignup.rePassword.value){
			notifRepassword.slideDown();
			notifRepassword.delay(5000).slideUp('slow');
			valid = false;
		}
		
		if(!formSignupJQuery.valid()){
			return;
		}else{
			$.ajax({
				type: 'POST',
				data: formSignupJQuery.serialize(),
				url: base_url+'index/signup/',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						lblNotif.html(response.message);
						lblNotif.slideDown();
						lblNotif.delay(5000).slideUp('slow');
						document.getElementById("formSignup").reset();
					}else{
						lblNotif.html(response.message);
						lblNotif.slideDown();
						lblNotif.delay(5000).slideUp('slow');
						document.getElementById("formSignup").reset();
					}
				}
			});
		}
	}
}

function CtrlSignin(){
	this.init = init;
	this.onEnter= onEnter;
	
	var btnSave,forgetpass;
	var formSignin,formSigninJQuery;
	var notifEmail,notifPassword;
	var lblNotif,lblMailNotif;
	var txtForgotEmail, aForgotSubmit, notifForgotPassword;
		
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		btnSave = $hs("btnSave");
		forgetpass = $hs("forgetpass");
		formSignin = $hs("formSignin");
		
		formSigninJQuery = $("#formSignin");
		notifEmail = $("#notifEmail");
		notifPassword = $("#notifPassword");
		lblNotif = $("#lblNotif");
		lblMailNotif = $("#notifikasi");
		txtForgotEmail = $hs("txtForgotEmail");
		aForgotSubmit = $hs("aForgotSubmit");
		notifForgotPassword = $("#notifForgotPassword");
		
		$('.modal-trigger').leanModal();
		
	}

	function initEventlistener(){
		btnSave.onclick = function(){
			doSave();
		};
		
		aForgotSubmit.onclick = function(){
			doForgotPassword();
		};
	}
	function onEnter(event){
		if ($hs_onEnter(event)){
			doSave();
		}
	}	
	
	$(function() {
		lblMailNotif.delay(5000).slideUp('slow');
	})
	
	function doSave(){
		var valid = true;
		
		if(formSignin.email.value == ""){
			notifEmail.slideDown();
			notifEmail.delay(5000).slideUp('slow');
			valid = false;
		}
		
		if(formSignin.password.value == ""){
			notifPassword.slideDown();
			notifPassword.delay(5000).slideUp('slow');
			valid = false;
		}
		
		if(valid){
			$.ajax({
				type: 'POST',
				data: formSigninJQuery.serialize(),
				url: base_url+'index/signin',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						top.location.href = base_url+'index';
					}else{
						lblNotif.html(response.message);
						lblNotif.slideDown();
						lblNotif.delay(5000).slideUp('slow');
					}
				}
			});
		}
	}
	
	function doForgotPassword(){
		if(txtForgotEmail.value == ""){
			notifForgotPassword.html("<i class='fa fa-warning'></i> Email harus diisi e!");
			notifForgotPassword.slideDown();
			notifForgotPassword.delay(5000).slideUp('slow');
			return;
		}

		var capcha = $("#g-recaptcha-response").val();
			
		
		$.ajax({
			type: 'POST',
			data: "email="+txtForgotEmail.value+"&rechapcha="+capcha,
			url: base_url+'index/doForgotPassword',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					txtForgotEmail.value = "";
					notifForgotPassword.html("<div style='color:blue;'>"+response.message+"</div>");
					notifForgotPassword.slideDown();
					notifForgotPassword.delay(5000).slideUp('slow');
					grecaptcha.reset();
				}else{					
					notifForgotPassword.html("<i class='fa fa-warning'></i> "+response.message+"</div>");
					notifForgotPassword.slideDown();
					notifForgotPassword.delay(5000).slideUp('slow');
					grecaptcha.reset();
				}
			}
		});
	}
}