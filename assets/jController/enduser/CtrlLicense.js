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

  $('#kode1').focus();

});

function verifikasi(id) {
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
					$('#ok-btn').delay(1000).fadeTo(1,'slow').html("Ok");
		    	}else{
		    		box_notif_alert (response.notif);
		    		$('#ok-btn').delay(1000).fadeTo(1,'slow').html("Ok");
		    	}
		    }
	    });
	};
}

function box_notif_alert (e) {
	var box = "	<div class='card-panel red lighten-4'>"
				    +"<span class='blue-grey-text text-darken-4'>"+e+"</span>"
				+"</div>";
	$('#notif').html(box).hide().slideDown().delay(5000).slideUp('slow');
}

function box_notif_success (a,b,c) {
	var box = "	<div class='card-panel green darken-1'>"
				      +"<span class='white-text '><h4>Selamat! Akun anda sudah aktif</h4></span>"
				      +"<span class='white-text '>Masa aktif akun Anda sampai : <b style='text-decoration:underline'>"+a+"</b></span>"
				      +"<span class='white-text '>License Code : <b style='text-decoration:underline'>"+b+"</b></span>"
				      +"<span class='white-text '>Email : <b style='text-decoration:underline'>"+c+"</b></span><button class='btn waves-effect right waves-light white green-text' type='button' name='action'>Go to Dashboard</button>"
				    +"</div>";
	$('#notif').html(box).hide().slideDown();
}