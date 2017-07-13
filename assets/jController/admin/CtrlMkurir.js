
$(document).ready(function() {
    $('#form-kurir-edit').validate({
        rules:{
            namaedit        : {required: true}
        },
        messages: {
            namaedit: {
                required: ("Name cannot be empty"),
            }
        },
    });
	$('#form-kurir-add').validate({
        rules:{
            namaadd        : {required: true}
        },
        messages: {
            namaadd: {
                required: ("Name cannot be empty"),
            }
        },
    });
        $("input.ribuan").priceFormat({     
        limit: 9,
        centsLimit: 0,
        centsSeparator: "",
        thousandsSeparator: ".",
        prefix: "Rp.",
    });
        
})

function kurir_modal_add() {
$("#box-form-kurir-add").modal("show").on('shown.bs.modal', function () {
	$('#form-kurir-add')[0].reset();
	$('label.error').hide();
    $("#fileimage-add").attr("src", base_url+"html/admin/img/credit/dummy_logo.png");
});
}
function kurir_modal(id) {
$.ajax({
	type    : "POST",
	url     : base_url+"admin/master_kurir/edit",
	data    : "getid="+id,
	dataType: 'json',
	success : function(response){
		if (response.msg == "success") {
			var data = response[0];
			idedit      = data.id;
			$("#box-form-kurir-edit").modal("show").on('shown.bs.modal', function () {				
				$("#namaedit").val(data.name).focus();
				$("#idedit").val(data.id);
                if (data.image != '') {
                    $("#image").val(data.image);
                    $("#fileimageedit-add").attr("src", base_url+"assets/pic/kurir/resize/"+data.image);
                };
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