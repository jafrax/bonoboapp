$(function() {
    //Date range picker
    $('#tanggalindong').daterangepicker();
});
function delete_dt(id){
  $.ajax({
    type: 'POST',
    data: 'id='+id,
    url: base_url+'admin/master_kategori/d_master_kategori',
    success: function(msg) {
      if (msg == 0) {
        $('.toko-'+id).fadeIn();
      }else{
        $('.toko-'+id).fadeOut().remove();
      }      
    }
  }); 
}