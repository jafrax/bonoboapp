(function() {
   $('#tambah-kategori').on('click', function() {
   		var nama 	= $('#nama-kategori').val();
   		var id 		= $('#id-toko').val();

   		$.ajax({
            type: 'POST',
            data: 'nama='+nama+'&id='+id,
            url: base_url+'produk/add_kategori',
            success: function(msg) {
            	Materialize.toast('Kategori telah ditambahkan', 4000);
            	$('#tempat-kategori').html(msg);
               $('#select-kategori').material_select();
            }
        });
   });

})();

var tot_picture = 1;
function add_picture() {
    tot_picture = tot_picture+1;
    $('#total_picture').val(tot_picture);
    var hitung = $('.picture-area .card').length;
    if (hitung < 3) {
        $('.picture-area').append(box_picture(tot_picture));
        /*$('.label-area').append(box_alert(tot_picture));
        $('input[name="pic_'+tot_picture+'"]').each(function () {
            $(this).rules("add", {
                accept: 'image/*',filesize: 2097152,
                messages: {
                    filesize: message_alert("Valid max size is 2 Mega Bytes"),  
                },
            });
        });*/
    }
}

function box_picture(id) {
    var box = "<div class='col s6 m4 l3' id='div_pic_"+tot_picture+"'><div class='card' >"
                  +"<a class='delimg' onclick=javascript:remove_picture('pic_"+tot_picture+"')><i class='mdi-content-backspace'></i></a>"
                  +"<div class='card-image img-product waves-effect waves-block waves-light'>"
                     +"<img id='img_pic_"+tot_picture+"' onclick=javascript:click_picture('pic_"+tot_picture+"') class='img-product responsive-img' src='"+base_url+"html/images/comp/product_large.png'>"
                     +"<input type='file' class='pic_product' name='pic_"+tot_picture+"' id='pic_"+tot_picture+"' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id)>"
                  +"</div>"
               +"</div></div>";
    return box;
}

function click_picture(file) {
   $('#'+file).click();
}

function picture_upload(id){
   var URL     = window.URL || window.webkitURL;
   var input   = document.querySelector('#'+id);
   var preview = document.querySelector('#img_'+id);
   preview.src = URL.createObjectURL(input.files[0]);    
}

function remove_picture(id) {
   $('#div_'+id).remove();   
    var hitung = $('.picture-area .card').length;
    if (hitung == 0) {
        tot_picture = tot_picture+1;
        $('.picture-area').append(box_picture(tot_picture));
    }
}

function change_stok() {
   var stok = $('#stok').val();

   if (stok == 1) {
      $('.stok').html("<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>");
   }else if (stok == 0) {
      $('.stok').html("<input id='varian' type='text' placeholder='Jumlah stok' class='validate'>"
                        +"<label for='varian'>Stok <span></span></label>");
   }
}

function setVarian() {
   if ($('#gunakan_varian').is(":checked")) {
      $('.cek-stok').show();
      $('.uncek-stok').hide();
   }else{
      $('.uncek-stok').show();
      $('.cek-stok').hide();
   };
}
var tot_stok = 1;
function addVarian() {
  var stok = $('#stok').val();

  if (stok == 1) {
      var varian = "<li class='varsto'><div class='input-field col s12 m6'>"
                      +"<input id='varian' name='nama_varian_1' type='text' placeholder='Misal: Lusin, Pcs' class='validate'>"
                      +"<label for='varian'>Varian <span></span></label>"
                    +"</div>"
                    +"<div class='input-field col s12 m6 tersedia'>"
                        +"<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>"
                      +"</div>"
                      +"<div class='input-field col s12 m6 pakai-stok'  style='display:none'>"
                        +"<input id='varian' name='stok_varian_1' type='text' placeholder='Jumlah stok' class='validate'>"
                        +"<label for='varian'>Stok <span></span></label>"
                        +"<a href='#delete_varian' class='modal-trigger btn-floating btn-xs waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>"
                      +"</div></li>";
   }else if (stok == 0) {
      var varian = "<li class='varsto'><div class='input-field col s12 m6'>"
                      +"<input id='varian' name='nama_varian_1' type='text' placeholder='Misal: Lusin, Pcs' class='validate'>"
                      +"<label for='varian'>Varian <span></span></label>"
                    +"</div>"
                    +"<div class='input-field col s12 m6 tersedia' style='display:none'>"
                        +"<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>"
                      +"</div>"
                      +"<div class='input-field col s12 m6 pakai-stok'>"
                        +"<input id='varian' name='stok_varian_1' type='text' placeholder='Jumlah stok' class='validate'>"
                        +"<label for='varian'>Stok <span></span></label>"
                        +"<a href='#delete_varian' class='modal-trigger btn-floating btn-xs waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>"
                      +"</div></li>";
   }  

  $('#tot_varian').
  $('#tempat-varian').append(varian);
}