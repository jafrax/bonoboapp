function CtrlSignup(){
	this.init = init;
	
	var btnSave;
	var formSignup,formSignupJQuery;
	var notifName,notifEmail,notifPassword,notifRepassword;
	var lblNotif;
	
	function init(){
		initComponent();
		initEventlistener();
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
		
		if(valid){
			$.ajax({
				type: 'POST',
				data: formSignupJQuery.serialize(),
				url: base_url+'index/signup/',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
					
					}else{
					
					}
					
					lblNotif.html(response.message);
					lblNotif.slideDown();
					lblNotif.delay(5000).slideUp('slow');
				}
			});
		}
	}
}

function CtrlSignin(){
	this.init = init;
	
	var btnSave;
	var formSignin,formSigninJQuery;
	var notifEmail,notifPassword;
	var lblNotif;
	var txtForgotEmail, aForgotSubmit, notifForgotPassword;
		
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		btnSave = $hs("btnSave");
		formSignin = $hs("formSignin");
		
		formSigninJQuery = $("#formSignin");
		notifEmail = $("#notifEmail");
		notifPassword = $("#notifPassword");
		lblNotif = $("#lblNotif");
		
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
			notifForgotPassword.html("<i class='fa fa-warning'></i> Email harus diisi !");
			notifForgotPassword.slideDown();
			notifForgotPassword.delay(5000).slideUp('slow');
			return;
		}
		
		$.ajax({
			type: 'POST',
			data: "email="+txtForgotEmail.value,
			url: base_url+'index/doForgotPassword',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					txtForgotEmail.value = "";
					notifForgotPassword.html("<div style='color:blue;'>"+response.message+"</div>");
					notifForgotPassword.slideDown();
					notifForgotPassword.delay(5000).slideUp('slow');
				}else{
					notifForgotPassword.html("<i class='fa fa-warning'></i> "+response.message);
					notifForgotPassword.slideDown();
					notifForgotPassword.delay(5000).slideUp('slow');
				}
			}
		});
	}
}