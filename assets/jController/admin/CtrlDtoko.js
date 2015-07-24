$(function() {
    //Date range picker
    $('#tanggalindong').daterangepicker();
});
function delete_dt(id){
  $.ajax({
    type: 'POST',
    data: 'id='+id,
    url: base_url+'admin/daftar_toko/d_daftar_toko',
    success: function(msg) {
      if (msg == 0) {
        $('.toko-'+id).fadeIn();
      }else{
        $('.toko-'+id).fadeOut().remove();
      }      
    }
  }); 
}