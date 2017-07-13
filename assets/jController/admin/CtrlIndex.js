$(function() {
	$('#fsignin').validate({
		rules:{
			email : {
				required: true
			},
			password: {
				required: true
			}
		},
		messages: {
			email:{
				required: "Field ini dibutuhkan",
			},
			password:{
				required: "Field ini dibutuhkan",
			},
		},
	});
	/*function login(){
		$.ajax({
				type: 'POST',
				data: $('#fsignin').serialize(),
				url: base_url+'admin/index/signin',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						top.location.href = base_url+'admin/dashboard';
					}else{
						alert(response.message);//$('#lblNotif').html();
						//$('#lblNotif').slideDown();
						//$('#lblNotif').delay(5000).slideUp('slow');
					}
				}
		});
		
	}*/
})
function valaid(id){
	if(!$('#'+id).valid()){
		$('label.error').delay(5000).slideUp('slow');
	}
}

function r_password(selection,url,uri) {
    if ($("#"+selection).valid()) {
    	var uri = uri;
        $.ajax({
            type    : "POST",
            url     : base_url+url,
            data    : $("#"+selection).serialize(),
            dataType: 'json',
            success : function(response){
            	
                if (response.msg == "success") {
                     window.location.href = base_url+'admin/index/dashboard';
                }else{
                 	window.location.href = uri;
                }
            },
            error : function(){
                
            }
        });
    }
}

