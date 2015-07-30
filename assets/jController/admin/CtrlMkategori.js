
$(document).ready(function() {
    $('#form-kategori-edit').validate({
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

function kategori_modal_add() {
$("#box-form-kategori-add").modal("show").on('shown.bs.modal', function () {
	$('#form-kategori-add')[0].reset();
	$('label.error').hide();
});
}
function kategori_modal(id) {
$.ajax({
	type    : "POST",
	url     : base_url+"admin/master_kategori/edit",
	data    : "getid="+id,
	dataType: 'json',
	success : function(response){
		if (response.msg == "success") {
			var data = response[0];
			idedit      = data.id;
			$("#box-form-kategori-edit").modal("show").on('shown.bs.modal', function () {				
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