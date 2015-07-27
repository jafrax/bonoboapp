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
var idedit      = "";
var namaedit    = "";
function kategori_modal(id) {
    id_edit = id;
    if (id != "") {
        $.ajax({
            type    : "POST",
            url     : base_url+"admin/master_kategori/edit",
            data    : "getid="+id,
			dataType: 'json',
            success : function(response){
                if (response.msg == "success") {
                    var data = response[0];
                    $("#namaedit").val(data.name);
                    $("#idedit").val(data.id);
                    idedit      = data.id;
                    namaedit    = data.nama;
                    $("#box-form-kategori-edit").modal("show").on('shown.bs.modal', function () {
                        var el = $("#namaedit").get(0);
                        var elemLen = el.value.length;
                    
                        el.selectionStart = elemLen;
                        el.selectionEnd = elemLen;
                        el.focus();
                        //$("#namaedit").focus();
                    });
                }
            },
            error : function(){
                
            }
        });
    }
    
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