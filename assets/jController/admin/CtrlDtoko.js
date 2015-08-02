$(function() {
    //Date range picker
    $('#tanggalindong').daterangepicker();
});
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
