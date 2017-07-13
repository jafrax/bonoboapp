$(document).ready(function() {
    $.validator.setDefaults({
        ignore: []
    });
    
    $('#form-change-password').validate({
        rules:{
            oldpass     : {required: true,remote: base_url+"admin/account/rules_password"},
            newpass     : {required: true,minlength:4,maxlength:50},
            renewpass   : {required: true,equalTo:'#newpass'}
        },
        messages: {
            oldpass: {
                required: message_alert("Old password cannot be empty"),
                remote: message_alert("Old password is wrong"),
            },
            newpass: {
                required: message_alert("Password cannot be empty"),
                minlength: message_alert("Min length 5 characters"),
                maxlength: message_alert("Max length 50 characters"),
            },
            renewpass: {
                required: message_alert("Retype password cannot be empty"),
                equalTo: message_alert("Please enter the same password"),
            }
        },
    });
})

function change_password(selection,url) {
    if ($("#"+selection).valid()) {
        $.ajax({
            type    : "POST",
            url     : base_url+url,
            data    : $("#"+selection).serialize(),
            dataType: 'json',
            success : function(response){
                if (response.msg == "success") {
                    $('#'+selection)[0].reset();
                    $("label.error").hide();
                    $(".modal").modal("hide");
                }else{
                    
                }
            },
            error : function(){
                
            }
        });
    }
}
$(function(){
		//select active nav
	var link=window.location;
	$('ul.nav li a[href="'+link+'"]').parent().addClass("active");
	
	//pagination
	$(document).on('click','.pagination li a',function() {
		var url = $(this).attr('href');		
		$.ajax({
			type	: 'POST',
			data	: 'ajax=1',
			url		: url,
			success: function(msg) {				
				$('#div-paging').html(msg);
				checkall();
			}
		});
		return false;
	});	
		
	//checkall cehckbox
	$("table").on('click', '#checkall', function () {
		$(this).parents('table:eq(0)').find(':checkbox').prop('checked', this.checked);
	});
});
$(document).ready(function() {
		/*NUMBER FORMAT*/
	$("input.rupiah").priceFormat({	    
	    limit: 18,
    	centsLimit: 2,
		centsSeparator: ",",
    	thousandsSeparator: ".",
    	prefix: "Rp. ",
	});
	/*NUMBER FORMAT*/
});