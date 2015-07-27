$(function() {
    //Date range picker
    $('#tanggalindong').daterangepicker();
});
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