$(function() {
    //Date range picker
     $('#datepickermah').datepicker({
       autoclose: true,
       todayHighlight: true,
       format: 'dd MM yyyy' 
   });
});
$(document).ready(function() {
    $('#date-munggah').validate({
        rules:{
            datepickermah        : {required: true}
        },
        messages: {
            datepickermah: {
                required: ("cannot be empty"),
            }
        },
    });
})
function tanggal_modal(id) {
$.ajax({
	type    : "POST",
	url     : base_url+"admin/daftar_toko/datechange",
	data    : "getid="+id,
	dataType: 'json',
	success : function(response){
		if (response.msg == "success") {
			var data = response[0];
			idedit      = data.id;
			$("#bs-example-modal-smedit").modal("show").on('shown.bs.modal', function () {				
				$("#datepickermah").val(data.expired_on).focus();
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
                    $("#tanggalmu"+idedit).html($("#datepickermah").val());
                    $(".modal").modal("hide");
                }else{
                    
                }
            },
            error : function(){
                
            }
        });
	}
}
function toko_suspend(id) {
    $.ajax({
        type    : "POST",
        url     : base_url+"admin/daftar_toko/suspend",
        data    : "id="+id,
        dataType: 'json',
        success : function(response){
            if (response.msg == "success") {
                $(".btn-toko-"+id).removeClass("btn-info").addClass("btn-danger").html("Unsuspend");
                $(".tombol-ok"+id).attr("onclick","toko_unsuspend('"+id+"')");
                return;
            }
        },
        error : function(){
            
        }
    });   
}
function toko_unsuspend(id) {

    $.ajax({
        type    : "POST",
        url     : base_url+"admin/daftar_toko/unsuspend",
        data    : "id="+id,
        dataType: 'json',
        success : function(response){
            if (response.msg == "success") {
                $(".btn-toko-"+id).removeClass("btn-danger").addClass("btn-info").html("Suspend");
                $(".tombol-ok"+id).attr("onclick","toko_suspend('"+id+"')");
                return;
            }
        },
        error : function(){
            
        }
    });

}
