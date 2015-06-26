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

  $("#form-ready").validate({
      errorClass:'error',
      ignore: ":hidden:not(select)",
      rules:{
          tipe                    : {required: true,maxlength:100},
          nama                    : {required: true,maxlength:50},
          sku                     : {maxlength:20},
          kategori                : {required: true,maxlength:50},
          pic_1                   : {accept: 'image/*',filesize: 1000000},
          berat                   : {number:true,maxlength:50},
          satuan                  : {maxlength:5},
          min_order               : {digits: true,maxlength:11},
          deskripsi               : {maxlength:250},
          stok                    : {required: true,maxlength:50},
          harga_pembelian         : {digits: true,maxlength:50},
          harga_level_1           : {digits: true,maxlength:50},
          harga_level_2           : {digits: true,maxlength:50},
          harga_level_3           : {digits: true,maxlength:50},
          harga_level_4           : {digits: true,maxlength:50},
          harga_level_5           : {digits: true,maxlength:50},          
      },
      messages: {
          pic_1: {
                filesize: message_alert('Ukuran file terlalu besar, maksimal 1 MB'),
              }
      }
  });

  document.getElementById("gunakan_varian").checked = false; 
})();

var tot_picture = 1;
function add_picture() {
    tot_picture = tot_picture+1;    
    var hitung = $('.picture-area .card').length;
    if (hitung < 3) {
        $('#total_picture').val(tot_picture);
        $('.picture-area').append(box_picture(tot_picture));
        $('.label-area').append(box_alert(tot_picture));
        $('input[name="pic_'+tot_picture+'"]').each(function () {
            $(this).rules("add", {
                accept: 'image/*',filesize: 1000000,
                messages: {
                    filesize: message_alert("Valid max size is 1 Mega Bytes"),  
                },
            });
        });
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

function box_alert(id) {
    var label = "<br><label id='label_pic_"+tot_picture+"' for='pic_"+tot_picture+"' class='error' generated='true'></label>";
    return label;
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
      $('.tersedia').show();
      $('.pakai-stok').hide();
   }else if (stok == 0) {
      $('.pakai-stok').show();
      $('.tersedia').hide();
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

var tot_varian= 1;
function addVarian() {  
  tot_varian = tot_varian+1;
  
  $('#tempat-varian').append(boxVarian(tot_varian));
  $('#tot_varian').val(tot_varian);
}

function boxVarian(id) {
  var stok      = $('#stok').val();
  if (stok == 1) {
      var varian = "<li class='varsto' id='li_varian_"+tot_varian+"'><div class='input-field col s12 m5'>"
                      +"<input id='varian' name='nama_varian_"+tot_varian+"' type='text' placeholder='Misal: Lusin, Pcs' class='validate'>"
                      +"<label for='varian'>Varian <span></span></label>"
                    +"</div>"
                    +"<div class='input-field col s11 m5 tersedia'>"
                        +"<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>"
                      +"</div>"
                      +"<div class='input-field col s11 m5 pakai-stok'  style='display:none'>"
                        +"<input id='varian' name='stok_varian_"+tot_varian+"' type='text' placeholder='Jumlah stok' class='validate'>"
                        +"<label for='varian'>Stok <span></span></label>"
                      +"</div>"
                      +"<div class='input-field col s1 m1' >"
                      +"<a onclick=javascript:deleteVarian('li_varian_"+tot_varian+"'); class='btn-floating btn-xs waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>"
                    +"</div>"
                    +"</li>";
   }else if (stok == 0) {
      var varian = "<li class='varsto' id='li_varian_"+tot_varian+"'><div class='input-field col s12 m5'>"
                      +"<input id='varian' name='nama_varian_"+tot_varian+"' type='text' placeholder='Misal: Lusin, Pcs' class='validate'>"
                      +"<label for='varian'>Varian <span></span></label>"
                    +"</div>"
                    +"<div class='input-field col s11 m5 tersedia' style='display:none'>"
                        +"<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>"
                      +"</div>"
                      +"<div class='input-field col s11 m5 pakai-stok'>"
                        +"<input id='varian' name='stok_varian_"+tot_varian+"' type='text' placeholder='Jumlah stok' class='validate'>"
                        +"<label for='varian'>Stok <span></span></label>"
                      +"</div>"
                      +"<div class='input-field col s1 m1' >"
                      +"<a onclick=javascript:deleteVarian('li_varian_"+tot_varian+"'); class='btn-floating btn-xs waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>"
                    +"</div>"
                      +"</li>";
   }
   return varian;   
}

function deleteVarian(varian) {
  $('#'+varian).remove();
  var jmlh = $('#tempat-varian li').length;
  
  if (jmlh == 0) {$('#tempat-varian').append(boxVarian(jmlh));};
  
}