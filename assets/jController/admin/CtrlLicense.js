

(function() {   
  $("#form-setting").validate({
      errorClass:'error',
      ignore: ":hidden:not(select)",
      rules:{
          default_duration : {number: true,maxlength:50},          
          code_1           : {maxlength:4},
          code_2           : {maxlength:4},
          code_3           : {maxlength:4},
          code_4           : {maxlength:4},
      }
  }); 

})();


function submit_setting () {
	$('#btn-submit-setting').fadeTo(0.4,'slow');
	$('#btn-submit-setting').html("<img width='16px' src='"+base_url+"html/images/comp/loading2.GIF' /> Loading...");
	$.ajax({ 
		type:'post',
		url:base_url+'admin/license/save_setting',
		data:$('#form-setting').serialize(),
		success:function(msg){
			if (msg = 1111) {
				$('#btn-submit-setting').fadeTo(1,'slow');
				$('#btn-submit-setting').html("Submit");
				notif('Data telah disimpan','success');
			};
		}
	});
}