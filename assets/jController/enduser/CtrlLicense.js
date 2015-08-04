$(document).ready(function() {
   	$("#form-license").validate({
      errorClass:'error',
      ignore: ":hidden:not(select)",
      rules:{
          kode1                    : {required: true,maxlength:4,minlength:4},          
          kode2                    : {required: true,maxlength:4,minlength:4},          
          kode3                    : {required: true,maxlength:4,minlength:4},          
          kode4                    : {required: true,maxlength:4,minlength:4},          
      }
  	});

  	$("#form-minta").validate({
      errorClass:'error',
      ignore: ":hidden:not(select)",
      rules:{
          nama	: {required: true,maxlength:50,minlength:5},
          telp	: {required: true,number:true,maxlength:12},
          hp	: {required: true,number:true,maxlength:12},          
      }
  	});  

  $('#kode1').focus();

});

function verifikasi(id) {
	var capcha = $("#g-recaptcha-response").val();
	if(capcha == ""){		 
		$('#error-captcha').html("<i class='fa fa-warning'></i> Captcha tidak valid!");
		$('#error-captcha').slideDown();
		$('#error-captcha').delay(3000).slideUp('slow');
	 	return;
    }
	if ($("#form-license").valid()) {
		var code = $('#kode1').val()+"-"+$('#kode2').val()+"-"+$('#kode3').val()+"-"+$('#kode4').val();
		$('#ok-btn').fadeTo(0.3);
		$('#ok-btn').html("<img width='16px' src='"+base_url+"html/images/comp/loading2.GIF' /> Loading...");

	    $.ajax({
		    type: 'POST',
		    data: 'id='+id+'&code='+btoa(code),
		    url: base_url+'license/submit_verification',
		    dataType: 'json',
		    success: function(response) {
		    	if (response.msg == 'success') {
		    		var data = response[0];
					box_notif_success (response.end_date,data.code,data.email);
					$('#ok-btn').fadeTo(1,'slow').html("Ok");
					$('.panel-day-left').slideUp();
					$('.formain').slideUp();
		    	}else{
		    		box_notif_alert (response.notif);
		    		$('#ok-btn').fadeTo(1,'slow').html("Ok");
		    	}
		    }
	    });
	};
}

function box_notif_alert (e) {
	var box = "	<div class='card-panel red panel-day-left'>"
				    +"<span class='white-text'>"+e+"</span>"
				+"</div>";
	$('#notif').html(box).hide().slideDown().delay(5000).slideUp('slow');
}

function box_notif_success (a,b,c) {
	var box = "	<div class='card-panel green darken-1'>"
				      +"<span class='white-text '><h4>Selamat! Akun anda sudah aktif</h4></span>"
				      +"<span class='white-text '>Masa aktif akun Anda sampai : <b style='text-decoration:underline'>"+a+"</b></span><br>"
				      +"<span class='white-text '>License Code : <b style='text-decoration:underline'>"+b+"</b></span><br>"
				      +"<span class='white-text '>Email : <b style='text-decoration:underline'>"+c+"</b></span><button class='btn waves-effect right waves-light white green-text' type='button' name='action' onclick='location.href=\""+base_url+"toko\"'>Go to Dashboard</button>"
				    +"</div>";
	$('#notif').html(box).hide().slideDown();
}

function box_notif_minta (a,b,c) {
	var box = "	<div class='card-panel green darken-1'>"
				      +"<span class='white-text '>Permintaan telah dikirim</span>"				      
				    +"</div>";
	$('#notif').html(box).hide().slideDown().delay(3000).slideUp('slow');
}

function minta_disini(id){
	var nama = $('#nama').val();
	var telp = $('#telp').val();
	var hp = $('#hp').val();
	var capcha = $("#g-recaptcha-response").val();
	 if(capcha == ""){		 
		 $('#error-captcha').html("<i class='fa fa-warning'></i> Captcha tidak valid!");
		 $('#error-captcha').slideDown();
		 $('#error-captcha').delay(3000).slideUp('slow');
	 return;
     }

    $('#minta-button').fadeTo(0.3);
	$('#minta-button').html("<img width='16px' src='"+base_url+"html/images/comp/loading2.GIF' /> Loading...");

    if ($("#form-minta").valid()) {
    	$.ajax({
		    type: 'POST',
		    data: 'nama='+nama+'&telp='+telp+'&hp='+hp+'&captcha='+capcha,
		    url: base_url+'license/minta_disini',
		    dataType: 'json',
		    success: function(response) {
		    	if (response.result == 1) {
		    		Materialize.toast(response.message, 4000);	
		    		$("#form-minta")[0].reset();
					grecaptcha.reset();
					$('#minta-button').fadeTo(1);
					$('#minta-button').html("Pesan kode aktivasi");
		    	}else{
		    		Materialize.toast(response.message, 4000);
		    		$("#form-minta")[0].reset();
		    		grecaptcha.reset();
		    		$('#minta-button').fadeTo(1);
					$('#minta-button').html("Pesan kode aktivasi");
		    	}
		    }
	    });
    };	
}