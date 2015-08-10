// Created by : dinarwahyu13@gmail.com



/*
* MAIN SCROOL AJAX
*/
var offset_rs=5;
var scrolling_rs=true;

$(window).scroll(function () {      
        if ($(window).scrollTop() == ( $(document).height() - $(window).height()) && scrolling_rs==true && $('#satu').hasClass('ready_stock')) {
            $('#preloader').slideDown();
            
            scrolling_rs      = false;
            var total_produk  = $('#total_produk').val();
            var uri           = $('#uri').val();
            var url           = base_url+'produk/index/'+uri+'/'+offset_rs;
            
            window.scrollTo(0, ($(window).scrollTop()-50) );

            $.ajax({
                type: 'POST',
                data: 'ajax=1&scroll=1',
                url: url,
                dataType: 'json',
                success: function(response) {
                    if (response.msg == 'success'){
                        $('#satu').append(atob(response.satu));
                        $('#dua').append(atob(response.dua));
                        $('#preloader').slideUp();
                        offset_rs      = offset_rs+5;
                        scrolling_rs   = true;
                        $('ul.tabs').tabs();
                        Materialize.updateTextFields();
                        $('#total_produk').val(total_produk+5);
                    }else{
                        $('#preloader').slideUp();
                        scrolling_rs   = false;
                        $('#habis').slideDown();
                    }
                }
            });
            return false;
        }
    });

var offset_po=5;
var scrolling_po=true;

$(window).scroll(function () {      
        if ($(window).scrollTop() == ( $(document).height() - $(window).height()) && scrolling_po==true && $('#satu').hasClass('pre_order')) {
            $('#preloader').slideDown();
            
            scrolling_po      = false;
            var total_produk  = $('#total_produk').val();
            var uri           = $('#uri').val();
            var url           = base_url+'produk/pre_order/'+uri+'/'+offset_po;
            
            window.scrollTo(0, ($(window).scrollTop()-50) );

            $.ajax({
                type: 'POST',
                data: 'ajax=1&scroll=1',
                url: url,
                dataType: 'json',
                success: function(response) {
                    if (response.msg == 'success'){
                        $('#satu').append(atob(response.satu));
                        $('#dua').append(atob(response.dua));
                        $('#preloader').slideUp();
                        offset_po      = offset_po+5;
                        scrolling_po   = true;
                        $('ul.tabs').tabs();
                        Materialize.updateTextFields();
                        $('#total_produk').val(total_produk+5);
                    }else{
                        $('#preloader').slideUp();
                        scrolling_po   = false;
                        $('#habis').slideDown();
                    }
                }
            });
            return false;
        }
    });

/*
* END MAIN SCROOL AJAX
*/





(function() {   

  $("#form-ready").validate({
      errorClass:'error',
      ignore: ":hidden:not(select)",
      rules:{
          tipe                    : {required: true,maxlength:100},
          nama                    : {required: true,maxlength:50},
          sku                     : {maxlength:20},
          kategori                : {required: true,maxlength:50},
          pic_1                   : {accept: 'image/*',filesize: 1000000},
          pic_2                   : {accept: 'image/*',filesize: 1000000},
          pic_3                   : {accept: 'image/*',filesize: 1000000},
          pic_4                   : {accept: 'image/*',filesize: 1000000},
          pic_5                   : {accept: 'image/*',filesize: 1000000},
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
              },
          pic_2: {
                filesize: message_alert('Ukuran file terlalu besar, maksimal 1 MB'),
              },
          pic_3: {
                filesize: message_alert('Ukuran file terlalu besar, maksimal 1 MB'),
              },
          pic_4: {
                filesize: message_alert('Ukuran file terlalu besar, maksimal 1 MB'),
              },
          pic_5: {
                filesize: message_alert('Ukuran file terlalu besar, maksimal 1 MB'),
              },
      }
  }); 

   $("#form-pre").validate({
      errorClass:'error',
      ignore: ":hidden:not(select)",
      rules:{
          tipe                    : {required: true,maxlength:100},
          nama                    : {required: true,maxlength:50},
          tgl_pre_order_submit    : {required: true,maxlength:50},
          sku                     : {maxlength:20},
          kategori                : {required: true,maxlength:50},
          pic_1                   : {accept: 'image/*',filesize: 1000000},
          pic_2                   : {accept: 'image/*',filesize: 1000000},
          pic_3                   : {accept: 'image/*',filesize: 1000000},
          pic_4                   : {accept: 'image/*',filesize: 1000000},
          pic_5                   : {accept: 'image/*',filesize: 1000000},
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
              },
          pic_2: {
                filesize: message_alert('Ukuran file terlalu besar, maksimal 1 MB'),
              },
          pic_3: {
                filesize: message_alert('Ukuran file terlalu besar, maksimal 1 MB'),
              },
          pic_4: {
                filesize: message_alert('Ukuran file terlalu besar, maksimal 1 MB'),
              },
          pic_5: {
                filesize: message_alert('Ukuran file terlalu besar, maksimal 1 MB'),
              },
      }
  });  

  $("#form_add_kategori").validate({
      errorClass:'error',
      rules:{
          nama_kategori           : {required: true,maxlength:20,remote: base_url+"produk/rules_kategori"},     
      },
      messages: {
          nama_kategori: {
                remote: message_alert('Nama kategori sudah ada'),
              }
      }
  }); 

  if ($('.cek_produk').length > 0) {
    $('.cek_produk').prop('checked',false);
    document.getElementById("cek_all").checked = false; 
  };

  $('#nama_barang').focus();

  $('#keyword').keypress(function(e) {
    if (e.which == 13) {
      var keyword = $('#keyword').val();
      $.ajax({
        type: 'POST',
        data: 'keyword='+keyword,
        url: base_url+'produk/set_search',
        success: function(msg) {
          location.reload();
        } 
      });
    }
  });
})();

var tot_picture = 1;
function add_picture() {
    tot_picture = tot_picture+1;    
    var hitung = $('.picture-area .card').length;
    if (hitung < 5) {
        $('#total_picture').val(tot_picture);
        $('.picture-area').append(box_picture(tot_picture));
        $('#add-poto').show();
        //$('.label-area').append(box_alert(tot_picture));
        $('input[name="pic_'+tot_picture+'"]').each(function () {
            $(this).rules("add", {
                accept: 'image/*',filesize: 1000000,
                messages: {
                    filesize: message_alert("Ukuran file terlalu besar, maksimal 1 MB"),  
                },
            });
        });
    }

    if (hitung == 2) {
      $('#add-poto').hide();
    }
}

function box_picture(id) {
    var box = "<div class='col s6 m4 l2' id='div_pic_"+tot_picture+"'><div class='card' >"
                  +"<a class='delimg' onclick=javascript:remove_picture('pic_"+tot_picture+"')><i class='mdi-navigation-close right'></i></a>"
                  +"<div class='card-image img-product waves-effect waves-block waves-light'>"
                     +"<img id='img_pic_"+tot_picture+"' onclick=javascript:click_picture('pic_"+tot_picture+"') class='img-product responsive-img' src='"+base_url+"html/images/comp/product_large.png'>"
                     +"<input type='file' class='pic_product' name='pic_"+tot_picture+"' id='pic_"+tot_picture+"' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id)>"
                  +"</div>"
               +"<label id='label_pic_"+tot_picture+"' for='pic_"+tot_picture+"' class='error error-image' generated='true'></label></div></div>";
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
   var img     = $(input).val();

    switch(img.substring(img.lastIndexOf('.') + 1).toLowerCase()){
        case 'jpg': case 'png':
            preview.src = URL.createObjectURL(input.files[0]);  
            break;
        default:
            $(input).val('');
            // error message here
            Materialize.toast('Silahkan pilih file format gambar .jpg / .png.', 4000);
            break;
    }
     
}

function remove_picture(id) {
   /*$('#div_'+id).remove();   
    var hitung = $('.picture-area .card').length;
    if (hitung == 0) {
        tot_picture = tot_picture+1;
        $('#total_picture').val(tot_picture);
        $('.picture-area').append(box_picture(tot_picture));
    }

    if (hitung < 3) {$('#add-poto').show();};*/
  var loc = base_url+"html/images/comp/product_large.png";
  $('#'+id).val('');
  $('#img_'+id).attr("src",loc);  
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
  var hitung = $('#tempat-varian .varsto').length;
    if (hitung < 5) {
      $('#tempat-varian').append(boxVarian(tot_varian));
      $('#tot_varian').val(tot_varian);
    }
}

function boxVarian(id) {
  var stok      = $('#stok').val();
  if (stok == 1) {
      var varian = "<li class='varsto' id='li_varian_"+tot_varian+"'><div class='input-field col s12 m5 nolmar'>"
                      +"<span for='varian'>Varian</span>"
                      +"<input id='varian' name='nama_varian_"+tot_varian+"' type='text' maxlength='30' placeholder='Ex : Merah' class='validate'>"
                    +"</div>"
                    +"<div class='input-field col s11 m5 tersedia'>"
                        +"<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>"
                      +"</div>"
                      +"<div class='input-field col s11 m5 pakai-stok'  style='display:none'>"
                        +"<input id='varian' name='stok_varian_"+tot_varian+"' type='number' placeholder='Jumlah stok' class='validate'>"
                        +"<label for='varian'>Stok <span></span></label>"
                      +"</div>"
                      +"<div class='input-field col s1 m1' >"
                      +"<a onclick=javascript:deleteVarian('li_varian_"+tot_varian+"'); class='btn-floating btn-xs waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>"
                    +"</div>"
                    +"</li>";
   }else if (stok == 0) {
      var varian = "<li class='varsto' id='li_varian_"+tot_varian+"'><div class='input-field col s12 m5 nolmar'>"
                      +"<span for='varian'>Varian</span>"
                      +"<input id='varian' name='nama_varian_"+tot_varian+"' maxlength='30' type='text' placeholder='Ex : Merah' class='validate'>"
                    +"</div>"
                    +"<div class='input-field col s11 m5 tersedia' style='display:none'>"
                        +"<label for='varian'>Stok : <span class='text-green'>selalu tersedia</span></label>"
                      +"</div>"
                      +"<div class='input-field col s11 m5 pakai-stok'>"
                        +"<input id='varian' name='stok_varian_"+tot_varian+"' type='number' placeholder='Jumlah stok' class='validate'>"
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
  
  if (jmlh == 0) {$('#tot_varian').val(tot_varian);$('#tempat-varian').append(boxVarian(jmlh));};
  
}


// view ready stock============================================================================
var typingTimer;                
var doneTypingInterval = 500;

function change_stock(id){
  var stok = $('.stok-'+id).val();
  
  if (stok != '') {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function(){ 
      var stok = $('.stok-'+id).val();
      $.ajax({
        type: 'POST',
        data: 'id='+id+'&stok='+stok,
        url: base_url+'produk/change_stock',
        success: function(msg) {
          if (stok == 0) {
            $('.habis-'+id).fadeIn();
          }else{
            $('.habis-'+id).fadeOut();
          };
          $('.stok-'+id).val(msg);
          $('.ok-'+id).fadeIn();
          $('.ok-'+id).delay(500).fadeOut();        
        }
      });
    }, doneTypingInterval);
  }
}


function change_stock2(id){
  var stok = $('.stok-2-'+id).val();
  if (stok != '') {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(function(){ 
      $.ajax({
        type: 'POST',
        data: 'id='+id+'&stok='+stok,
        url: base_url+'produk/change_stock',
        success: function(msg) {
          if (stok == 0) {
            $('.habis-'+id).fadeIn();
          }else{
            $('.habis-'+id).fadeOut();
          };
          $('.stok-'+id).val(msg);
          $('.ok-'+id).fadeIn();
          $('.ok-'+id).delay(500).fadeOut();        
        }
      });
    }, doneTypingInterval);
  }
}

function delete_produk(id){
  $.ajax({
    type: 'POST',
    data: 'id='+id,
    url: base_url+'produk/delete_product',
    success: function(msg) {
      if (msg == 0) {
        $('.produk-'+id).fadeIn();
      }else{
        $('.produk-'+id).fadeOut().remove();
      }      
    }
  }); 
}

function cek_all(){  
  if ($('#cek_all').is(":checked")) {
    $('.cek_produk').prop('checked',true);
  }else{
    $('.cek_produk').prop('checked',false);
  }
}

function ngeklik(a,b){
  if ($('#'+b).is(":checked")) {
    $('#'+a).prop('checked',true);
  }else{
    $('#'+a).prop('checked',false);
  }  
}


// cek option============================================================================

function go(){
  var total_produk  = $('#total_produk').val();
  var option        = $('#option-go').val();
  var url           = '';

  if (option == 1) {
    url = base_url+'produk/delete_product';
  } else if (option == 2) {
    url = base_url+'produk/draft_product';
  } else if (option == 3) {
    url = base_url+'produk/publish_product';
  } else if (option == 4) {
    url = base_url+'produk/ready_product';
  } else if (option == 5) {
    url = base_url+'produk/pre_order_product';
  }   


  for (var i = 1 ; i <= total_produk; i++) {
    if ($('#cek-1-'+i).is(":checked")) {
      var id = $('#cek-'+i).val();
      if (option == 1) {
        $('.produk-'+id).fadeOut().remove();
      } else if (option == 2) {            
        $('.draft-'+id).fadeIn();        
      } else if (option == 3) {            
        $('.draft-'+id).fadeOut();
      } else if (option == 4) {
        $('.produk-'+id).fadeOut().remove();
      } else if (option == 5) {
        $('.produk-'+id).fadeOut().remove();
      }
      $.ajax({
        type: 'POST',
        data: 'id='+id,
        async: false,
        url: url,
        success: function(msg) {
          
        }
      });
    }   if (i == total_produk) {location.reload();}; 
  }
}


function change_active(){
  var active_type = $('#active_type').val();
  window.location.href = base_url+'produk/index/'+active_type;  
}

function change_active_pre(){
  var active_type = $('#active_type').val();
  window.location.href = base_url+'produk/pre_order/'+active_type;  
}


function tambah_kategori(){
  var nama  = $('#nama_kategori').val();
  var id    = $('#id-toko').val();

  if ($('#form_add_kategori').valid()) {
    $.ajax({
          type: 'POST',
          data: 'nama='+nama+'&id='+id,
          url: base_url+'produk/add_kategori',
          success: function(msg) {
            Materialize.toast('Kategori telah ditambahkan', 4000);
            $('#tempat-kategori').html(msg);
            $('#select-kategori').chosen();
            $('#add_kategori').closeModal();
            $('#nama_kategori').val('');
          }
      });
  }else{
    return;
  };
}

function tambah_kategori_atur(){  
  $('.add-kateg').attr('disabled', true);
  var nama  = $('#nama_kategori').val();
  var id    = $('#id-toko').val();  

  if ($('#form_add_kategori').valid() == true) {
    $.ajax({
          type: 'POST',
          data: 'nama='+nama+'&id='+id,
          url: base_url+'produk/add_kategori2',
          async: false,
          success: function(msg) {
            Materialize.toast('Kategori telah ditambahkan', 4000);
            $('#tempat-kategori').html(msg);
            $('#select-kategori').chosen();
            $('#nama_kategori').val('');
            $('#tambah_kategori').closeModal();
            $('.modal-trigger').leanModal();
            $('.add-kateg').attr('disabled', false);
            offset_kat      = 10;
            scrolling_kat   = true;
            $('#habis').slideUp();
          }
      });
  }else{
    $('.add-kateg').attr('disabled', false);
  };
}

function delete_kategori(id){
  $.ajax({
        type: 'POST',
        data: 'id='+id,
        url: base_url+'produk/delete_kategori',
        success: function(msg) {
          if (msg == 1) {
            Materialize.toast('Kategori telah dihapus', 4000);
            $('#kategori-'+id).fadeOut().remove();
            $('.modal-trigger').leanModal();            
          }else{
            Materialize.toast('Gagal menghapus kategori', 4000);   
            $('.modal-trigger').leanModal();         
          };          
        }
  });
}

function set_rules (e) {
  $("#form_edit_kategori_"+e).validate(); //sets up the validator
  Materialize.updateTextFields();
  $("input[id*=nama_"+e+"]").each(function () {
    $(this).rules('add', {
        required: true,maxlength:20,remote: base_url+"produk/rules_kategori",
        messages: {remote: message_alert('Nama kategori sudah ada')}
    });
  });
}

function edit_kategori(id){
  var nama  = $('#nama_'+id).val();

  if ($("#form_edit_kategori_"+id).valid()) {
    $.ajax({
        type: 'POST',
        data: 'nama='+nama+'&id='+id,
        url: base_url+'produk/edit_kategori',
        success: function(msg) {
          Materialize.toast('Kategori telah disunting', 4000);
          $('#tempat-kategori').html(msg);
          $('#edit_kategori_'+id).closeModal();
          $('.modal-trigger').leanModal();
          offset_kat      = 10;
          scrolling_kat   = true; 
          $('#habis').slideUp();
          
        }
    });
  };  
}

function cari_kategori(e){
  if (e.which == 13) {
      var keyword = $('#keyword-kategori').val();
      $.ajax({
        type: 'POST',
        data: 'keyword='+keyword,
        url: base_url+'produk/set_search_kategori',
        success: function(msg) {
          $('#tempat-kategori').html(msg);
          $('.modal-trigger').leanModal();
          offset_kat      = 10;
          scrolling_kat   = true;
          $('#habis').slideUp();
        } 
      });
    }
}

function change_date(id){
  var date = $('input[name="tanggal-'+id+'_submit"]').val();

  $.ajax({
    type: 'POST',
    async: false,
    data: 'date='+date+'&id='+id,
    url: base_url+'produk/change_date',
    success: function(msg) {
      if (msg == 'sukses') {        
        $('.draft-'+id).fadeOut();
        $('.kadal-'+id).fadeOut();
        $('.date-'+id).html(date);
      }else{
        $('.draft-'+id).fadeIn();
        $('.kadal-'+id).fadeIn();
        $('.date-'+id).html(date);       
      };
    } 
  });
}

function filter_kategori(){
  var kategori = $('#filter-kategori').val();
  
  $.ajax({
    type: 'POST',
    data: 'kategori='+kategori,
    url: base_url+'produk/set_filter_kategori',
    success: function(msg) {
      location.reload();
    } 
  });
}

function reset_cat () {
  $("#form_add_kategori")[0].reset();
  $("#form_add_kategori .error-chosen").hide();
  $("#nama_kategori").focus();
}


var offset_kat=10;
var scrolling_kat=true;

$(window).scroll(function () {      
        if ($(window).scrollTop() == ( $(document).height() - $(window).height())  && scrolling_kat==true && $('#tempat-kategori').length > 0) {
            $('#preloader').slideDown();
            
            scrolling_kat       = false;            
            var url         = base_url+'produk/atur_kategori/'+offset_kat;
            
            window.scrollTo(0, ($(window).scrollTop()-50) );

            $.ajax({
                type: 'POST',
                data: 'ajax=1&scroll=1',
                url: url,
                success: function(msg) {
                    if (msg){
                        $('#tempat-kategori').append(msg);
                        $('#preloader').slideUp();
                        offset_kat      = offset_kat+5;
                        scrolling_kat   = true;
                        $('#habis').slideUp();
                        $('.modal-trigger').leanModal();
                    }else{
                        $('#preloader').slideUp();
                        scrolling_kat   = false;
                        $('#habis').slideDown();
                        $('.modal-trigger').leanModal();
                    }
                }
            });
            return false;
        }
    });