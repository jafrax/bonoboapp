

(function() {   
  $("#form-setting").validate({
      errorClass:'alert-danger',
      ignore: ":hidden:not(select)",
      rules:{
          default_duration : {number: true,maxlength:2},          
          code_1           : {maxlength:4,minlength: 4},
          code_2           : {maxlength:4,minlength: 4},
          code_3           : {maxlength:4,minlength: 4},
          code_4           : {maxlength:4,minlength: 4},
      }
  }); 

  $("#form-generate").validate({
      errorClass:'alert-danger',
      ignore: ":hidden:not(select)",
      rules:{
          toko  		: {required: true},          
          duration 		: {required: true,number: true,maxlength:2},
          duration_type : {required: true},
      }
  }); 

})();


function submit_setting () {
	
	if ($('#auto_add').is(":checked")) {

		if ($('[name="code_1"]').val() == '' && $('[name="code_2"]').val() == '' && $('[name="code_3"]').val() == '' && $('[name="code_4"]').val() == '') {
			notif('Apabila "Auto add license on Registration" aktif, Silahkan isi data default code.','error');
			//alert('a');
			$("#auto_add").removeAttr('checked');
			return;
		};
	};
	if ($("#form-setting").valid()==true) {
		$('#btn-submit-setting').fadeTo(0.4,'slow');
		$('#btn-submit-setting').html("<img width='16px' src='"+base_url+"html/images/comp/loading2.GIF' /> Loading...");
		$.ajax({ 
			type:'post',
			url:base_url+'admin/license/save_setting',
			data:$('#form-setting').serialize(),
			success:function(msg){
				if (msg == 1111) {
					$('#btn-submit-setting').fadeTo(1,'slow');
					$('#btn-submit-setting').html("Submit");
					notif('Data telah disimpan','success');
				}else{
					$('#btn-submit-setting').fadeTo(1,'slow');
					$('#btn-submit-setting').html("Submit");
					notif('Data gagal disimpan','error');
				};
			}
		});
	};
}

function change_duration() {
	$('#duration').val('');
}

function generate(){
	if ($("#form-generate").valid()==true) {
		$('#btn-generate').fadeTo(0.4,'slow');
		$('#generate-notif').fadeOut();
		$('#btn-generate').html("<img width='16px' src='"+base_url+"html/images/comp/loading2.GIF' /> Loading...");
		$.ajax({ 
			type:'post',
			url:base_url+'admin/license/generate',
			data:$('#form-generate').serialize(),
			success:function(msg){
				if(msg == 2){
					$('#btn-generate').fadeTo(1,'slow');
					$('#btn-generate').html("Generate");
					notif('Toko masih memiliki License Code aktif','error');
				}else if (msg != 0) {
					$('#btn-generate').fadeTo(1,'slow');
					$('#btn-generate').html("Generate");
					notif('License telah di generate','success');
					$('#generate-notif').html(msg).hide().slideDown();					
					document.getElementById("form-generate").reset();
				}else{
					$('#btn-generate').fadeTo(1,'slow');
					$('#btn-generate').html("Generate");
					notif('License gagal di generate','error');
					document.getElementById("form-generate").reset();
				};
			}
		});
	};
}

function change_option () {
	var opt = $('#option').val();

	$.ajax({
        type	: 'POST',
        data	: 'opt='+opt,
        url		: base_url+'admin/license/option',
        success: function(msg) {
            location.reload();
        }
    });
}