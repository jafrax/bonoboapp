$(function() {
    //Date range picker
    $('#tanggalindong').daterangepicker();
});
$(document).ready(function() {
    $('#form-dkurir-edit').validate({
        rules:{
            namaedit        : {required: true}
        },
        messages: {
            namaedit: {
                required: ("Name cannot be empty"),
            }
        },
    });
	$('#form-dkurir-add').validate({
        rules:{
            namaedit        : {required: true}
        },
        messages: {
            namaedit: {
                required: ("Name cannot be empty"),
            }
        },
    });
})

function dkurir_modal_add() {
$("#box-form-dkurir-add").modal("show").on('shown.bs.modal', function () {
	$('#form-dkurir-add')[0].reset();
	$('label.error').hide();
});
}
function dkurir_modal(id) {
$.ajax({
	type    : "POST",
	url     : base_url+"admin/master_dkurir/edit",
	data    : "getid="+id,
	dataType: 'json',
	success : function(response){
		if (response.msg == "success") {
			var data = response[0];
			idedit      = data.id;
			$("#box-form-dkurir-edit").modal("show").on('shown.bs.modal', function () {				
				$("#namaedit").val(data.name).focus();
				$("#idedit").val(data.id);
			});
		}
	},
	error : function(){
		
	}
});
}

function submit_data_edit(selection,url) {
    if ($("#"+selection).valid()) {
        $.ajax({
            type    : "POST",
            url     : base_url+url,
            data    : $("#"+selection).serialize(),
            dataType: 'json',
            success : function(response){
                if (response.msg == "success") {
                    $("#nama-"+idedit).html($("#namaedit").val());
                    $(".modal").modal("hide");
                }else{
                    
                }
            },
            error : function(){
                
            }
        });
    }
}