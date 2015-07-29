
function verifikasi(id) {
	var code = $('#kode1').val()+"-"+$('#kode2').val()+"-"+$('#kode3').val()+"-"+$('#kode4').val();

    $.ajax({
	    type: 'POST',
	    data: 'id='+id+'&code='+btoa(code),
	    url: base_url+'license/submit_verification',
	    success: function(msg) {
			
	    }
    }); 

}