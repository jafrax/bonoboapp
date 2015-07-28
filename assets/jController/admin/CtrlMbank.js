$(function() {
    //Date range picker
    $('#tanggalindong').daterangepicker();
});
$(document).ready(function() {

    $('#form-bank-edit').validate({

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

function bank_modal_add() {
$("#box-form-bank-add").modal("show").on('shown.bs.modal', function () {
	$('#form-bank-add')[0].reset();
	$('label.error').hide();
});
}
function bank_modal(id) {
$.ajax({
	type    : "POST",
	url     : base_url+"admin/master_bank/edit",
	data    : "getid="+id,
	dataType: 'json',
	success : function(response){
		if (response.msg == "success") {
			var data = response[0];
			idedit      = data.id;
			$("#box-form-bank-edit").modal("show").on('shown.bs.modal', function () {				
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