// Created by : dinarwahyu13@gmail.com

/*
* MAIN SCROOL AJAX
*/
var offset_rs=10;
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
                        offset_rs      = offset_rs+10;
                        scrolling_rs   = true;
                        $('ul.tabs').tabs();
                        Materialize.updateTextFields();
                        $('#total_produk').val(total_produk+10);
                        $('.modal-trigger').leanModal();
                    }else{
                        $('#preloader').slideUp();
                        scrolling_rs   = false;
                        $('#habis').slideDown();
                        $('.modal-trigger').leanModal();
                        Materialize.updateTextFields();
                    }
                    /*NUMBER ONLY*/
                    jQuery('.numbersOnly').keyup(function () { 
                        this.value = this.value.replace(/[^0-9\.]/g,'');
                    });
                    /*NUMBER ONLY*/
                }
            });
            return false;
        }
    });

var offset_po=10;
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
                        offset_po      = offset_po+10
                        scrolling_po   = true;
                        $('ul.tabs').tabs();
                        Materialize.updateTextFields();
                        $('#total_produk').val(total_produk+10);
                        $('.modal-trigger').leanModal();
                        /*DATE PICKER*/
                        $('.datepicker').pickadate({
                          selectMonths: true, // Creates a dropdown to control month    
                          monthsFull: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                          monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Desc'],
                          selectYears: 15, // Creates a dropdown of 15 years to control year
                          today: 'Hari ini',
                          clear: 'Hapus',
                          close: 'Tutup',
                          formatSubmit: 'yyyy-mm-dd'
                        });
                        /*END DATE PICKER*/
                    }else{
                        $('#preloader').slideUp();
                        scrolling_po   = false;
                        $('#habis').slideDown();
                        $('.modal-trigger').leanModal();
                        /*DATE PICKER*/
                        $('.datepicker').pickadate({
                          selectMonths: true, // Creates a dropdown to control month    
                          monthsFull: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                          monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Desc'],
                          selectYears: 15, // Creates a dropdown of 15 years to control year
                          today: 'Hari ini',
                          clear: 'Hapus',
                          close: 'Tutup',
                          formatSubmit: 'yyyy-mm-dd'
                        });
                        /*END DATE PICKER*/
                        Materialize.updateTextFields();
                    }
                }
            });
            return false;
        }
    });

/*
* END MAIN SCROOL AJAX
*/





$(document).ready(function() {   

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
          stok_varian_1           : {required: true,maxlength:10},
          nama_varian_1           : {required: true,maxlength:10},
          harga_pembelian         : {digits: false,maxlength:11},
          harga_level_1           : {required: true,digits: false,maxlength:11},
          harga_level_2           : {digits: false,maxlength:11},
          harga_level_3           : {digits: false,maxlength:11},
          harga_level_4           : {digits: false,maxlength:11},
          harga_level_5           : {digits: false,maxlength:11},          
      },
      messages: {
          pic_1: {
                filesize: message_alert('Terlalu besar, maksimal 1 MB'),
              },
          pic_2: {
                filesize: message_alert('Terlalu besar, maksimal 1 MB'),
              },
          pic_3: {
                filesize: message_alert('Terlalu besar, maksimal 1 MB'),
              },
          pic_4: {
                filesize: message_alert('Terlalu besar, maksimal 1 MB'),
              },
          pic_5: {
                filesize: message_alert('Terlalu besar, maksimal 1 MB'),
              },
          harga_pembelian: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
              },
          harga_level_1: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
              },
          harga_level_2: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
              },
          harga_level_3: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
              },
          harga_level_4: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
              },
          harga_level_5: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
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
          harga_pembelian         : {digits: false,maxlength:11},
          harga_level_1           : {required: true,digits: false,maxlength:11},
          harga_level_2           : {digits: false,maxlength:11},
          harga_level_3           : {digits: false,maxlength:11},
          harga_level_4           : {digits: false,maxlength:11},
          harga_level_5           : {digits: false,maxlength:11},          
      },
      messages: {
          pic_1: {
                filesize: message_alert('Terlalu besar, maksimal 1 MB'),
              },
          pic_2: {
                filesize: message_alert('Terlalu besar, maksimal 1 MB'),
              },
          pic_3: {
                filesize: message_alert('Terlalu besar, maksimal 1 MB'),
              },
          pic_4: {
                filesize: message_alert('Terlalu besar, maksimal 1 MB'),
              },
          pic_5: {
                filesize: message_alert('Terlalu besar, maksimal 1 MB'),
              },
          harga_pembelian: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
              },
          harga_level_1: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
              },
          harga_level_2: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
              },
          harga_level_3: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
              },
          harga_level_4: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
              },
          harga_level_5: {
                maxlength: message_alert('Maksimal harga 999.999.999'),
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

  $('#nama_kategori').keypress(function(e) {
    if (e.which == 13) {
      tambah_kategori();
    }
  });

  $('.modal-trigger').leanModal({
      ready: function() { $("#nama_kategori").focus(); Materialize.updateTextFields();}, // Callback for Modal open
      complete: function() { Materialize.updateTextFields(); } // Callback for Modal close
    }
  ); 
});

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
    var box = "<div class='col s6 m3 l2' id='div_pic_"+tot_picture+"'><div class='card' >"
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

function click_picture_edit(file) {
  $('input[name="'+file+'"]').each(function () {
      $(this).rules("add", {
          accept: 'image/*',filesize: 1000000,
          messages: {
              filesize: message_alert("Ukuran file terlalu besar, maksimal 1 MB"),  
          },
      });
  });
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
            $('#rem_'+id).show();
            break;
        default:
            $(input).val('');
            // error message here
            Materialize.toast('Silahkan pilih file format gambar .jpg / .png.', 4000);
            break;
    }
     
}

function remove_picture(id) {
   $('#div_'+id).remove();   
    var hitung = $('.picture-area .card').length;
    if (hitung == 0) {
        tot_picture = tot_picture+1;
        $('#total_picture').val(tot_picture);
        $('.picture-area').append(box_picture(tot_picture));
    }

    if (hitung < 3) {$('#add-poto').show();};
  var loc = base_url+"html/images/comp/product_large.png";
  $('#'+id).val('');
  $('#img_'+id).attr("src",loc);
  $('#rem_'+id).hide();
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


function change_stokPr() {
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


function setVarianPr() {
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
  if (hitung == 4){
      $('#add-varian').hide();
    }
    if (hitung < 5) {
      $('#tempat-varian').append(boxVarian(tot_varian));
      $('#tot_varian').val(tot_varian);
      Materialize.updateTextFields();
      jQuery('.numbersOnly').keyup(function () { 
          this.value = this.value.replace(/[^0-9\.]/g,'');
      });
    }


}

var tot_varian= 1;
function addVarianPr() {  
	  tot_varian = tot_varian+1;
	  var hitung = $('#tempat-varian .varsto').length;
	  if (hitung == 4){
	      $('#add-varianPr').hide();
	    }
	    if (hitung < 5) {
	      $('#tempat-varian').append(boxVarianPr(tot_varian));
	      $('#tot_varian').val(tot_varian);
	      Materialize.updateTextFields();
	      jQuery('.numbersOnly').keyup(function () { 
	          this.value = this.value.replace(/[^0-9\.]/g,'');
	      });
	    }


	}

function boxVarianPr(id) {
  var stok      = $('#stokPr').val();
  if (stok == 1) {
      var varian = "<li class='varsto nolmar' id='li_varian_"+tot_varian+"'><div class='input-field col s12 m5 '>"                      
                      +"<input id='varian' name='nama_varian_"+tot_varian+"' type='text' maxlength='30' placeholder='Ex : Merah' class='validate'>"
                      +"<label for='varian'>Varian</label>"
                    +"</div>"
                      +"<div class='input-field col s1 m1' >"
                      +"<a onclick=javascript:deleteVarian('li_varian_"+tot_varian+"'); class='btn-floating waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>"
                    +"</div>"
                    +"</li>";
   }else if (stok == 0) {
      var varian = "<li class='varsto nolmar' id='li_varian_"+tot_varian+"'><div class='input-field col s12 m5 '>"                      
                      +"<input id='varian' name='nama_varian_"+tot_varian+"' maxlength='30' type='text' placeholder='Ex : Merah' class='validate'>"
                      +"<label for='varian'>Varian</label>"
                    +"</div>"
                      +"<div class='input-field col s1 m1' >"
                      +"<a onclick=javascript:deleteVarian('li_varian_"+tot_varian+"'); class='btn-floating waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>"
                    +"</div>"
                      +"</li>";
   }
   return varian;   
}


function boxVarian(id) {
  var stok      = $('#stok').val();
  if (stok == 1) {
      var varian = "<li class='varsto nolmar' id='li_varian_"+tot_varian+"'><div class='input-field col s12 m5 '>" 
                      +"<span for='varian'>Varian <span class='text-red'>*</span></span>"                     
                      +"<input id='varian' name='nama_varian_"+tot_varian+"' type='text' maxlength='30' placeholder='Ex : Merah' class='validate'>"
                    +"</div>"
                    +"<div class='input-field col s11 m5 tersedia'>"
                        +"<label >Stok : <span class='text-green'>selalu tersedia</span></label>"
                      +"</div>"
                      +"<div class='input-field col s11 m5 pakai-stok'  style='display:none'>"
                        +"<span for='varian'>Stok <span class='text-red'>*</span></span>"
                        +"<input id='varian' name='stok_varian_"+tot_varian+"' type='text' maxlength='10' placeholder='Jumlah stok' class='validate numbersOnly'>"
                      +"</div>"
                      +"<div class='input-field col s1 m1' >"
                      +"<a onclick=javascript:deleteVarian('li_varian_"+tot_varian+"'); class='btn-floating waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>"
                    +"</div>"
                    +"</li>";
   }else if (stok == 0) {
      var varian = "<li class='varsto nolmar' id='li_varian_"+tot_varian+"'><div class='input-field col s12 m5 '>"                      
                      +"<span for='varian'>Varian <span class='text-red'>*</span></span>"
                      +"<input id='varian' name='nama_varian_"+tot_varian+"' maxlength='30' type='text' placeholder='Ex : Merah' class='validate'>"
                    +"</div>"
                    +"<div class='input-field col s11 m5 tersedia' style='display:none'>"
                        +"<label >Stok : <span class='text-green'>selalu tersedia</span></label>"
                      +"</div>"
                      +"<div class='input-field col s11 m5 pakai-stok'>"
                        +"<span for='varian'>Stok <span class='text-red'>*</span></span>"
                        +"<input id='varian' name='stok_varian_"+tot_varian+"' type='text' maxlength='10' placeholder='Jumlah stok' class='validate numbersOnly'>"
                      +"</div>"
                      +"<div class='input-field col s1 m1' >"
                      +"<a onclick=javascript:deleteVarian('li_varian_"+tot_varian+"'); class='btn-floating waves-effect waves-red white right'><i class='mdi-navigation-close blue-grey-text'></i></a>"
                    +"</div>"
                      +"</li>";
   }
   return varian;   
}


function deleteVarian(varian) {
  $('#'+varian).remove();
  var jmlh = $('#tempat-varian li').length;
  
  if (jmlh == 0) {$('#tot_varian').val(tot_varian);$('#tempat-varian').append(boxVarian(jmlh));};
  var hitung = $('#tempat-varian .varsto').length;
    if (hitung < 5) {      
      $('#add-varian').show();
    }
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

function delete_produk(id,uri){
  $.ajax({
    type: 'POST',
    data: 'id='+id+'&uri='+uri,
    url: base_url+'produk/delete_product',
    success: function(msg) {
      if (msg == 0) {
        $('.produk-'+id).fadeIn();
      }else{
        $('.produk-'+id).fadeOut().remove();
        
      }
      if (uri == 'index') {
        $('#totalan').html('<b>READY STOCK</b> <span>( '+msg+' Produk )</span>');
      }else{
        $('#totalan').html('<b>PRE ORDER</b> <span>( '+msg+' Produk )</span>');
      };
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
  var a = 0;
  for (var i = 1 ; i <= total_produk; i++) {
    if ($('#cek-1-'+i).is(":checked")) {
      a++;
    }   
    if (i == total_produk) {if (a == 0) {Materialize.toast('Tidak ada produk yang dipilih', 2000);return;}}; 
  }

  if (option == 1) {    
    $('#tipe-go').html('menghapus');
    $('#head-go').html('Hapus');
  } else if (option == 2) {
    $('#tipe-go').html('memindah Draft');
    $('#head-go').html('Draft');
  } else if (option == 3) {
    $('#tipe-go').html('memindah Publish');
    $('#head-go').html('Publish');
  } else if (option == 4) {
    $('#tipe-go').html('memindah Ready Stock');
    $('#head-go').html('Ready Stock');
  } else if (option == 5) {
    $('#tipe-go').html('memindah Pre Order');
    $('#head-go').html('Pre Order');
  }

  $('#produk_go').openModal();
}

function delete_produk_go () {
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

  var a = 0;
  for (var i = 1 ; i <= total_produk; i++) {
    if ($('#cek-1-'+i).is(":checked")) {
      var id = $('#cek-'+i).val();
      a++;
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
    }   if (i == total_produk) {if (a > 0 && option != 1) {location.reload();}else{Materialize.toast('Produk telah dihapus', 4000);}}; 
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
            if (msg!=0) {
              Materialize.toast('Kategori telah ditambahkan', 4000);
              $('#tempat-kategori').html(msg);
              $('#add_kategori').closeModal();
              $('#nama_kategori').val('');    
              $('#select-kategori').selectize(); 
            }else{
              //Materialize.toast('Kategori telah ditambahkan', 4000);
            };
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
      success: function(msg) {
        if (msg != 0) {
          Materialize.toast('Kategori telah ditambahkan', 4000);
          $('#tempat-kategori').html(msg);            
          $('#nama_kategori').val('');            
          $('.modal-trigger').leanModal();
          $('.add-kateg').attr('disabled', false);
          offset_kat      = 10;
          scrolling_kat   = true;
          $('#habis').slideUp();
          $('#tambah_kategori').closeModal();
        }else{
          //Materialize.toast('Gagal!. Nama kategori sudah tersedia', 4000);
        };
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
            Materialize.toast('Gagal '+msg, 4000);   
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
          if (msg != 0) {
            Materialize.toast('Kategori telah disunting', 4000);
            $('#tempat-kategori').html(msg);
            $('#edit_kategori_'+id).closeModal();
            $('.modal-trigger').leanModal();
            offset_kat      = 10;
            scrolling_kat   = true; 
            $('#habis').slideUp();
          }else{
            //Materialize.toast('Gagal!. Nama kategori sudah tersedia', 4000);
          };
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
       // $('.draft-'+id).fadeOut();
        $('.kadal-'+id).fadeOut();
        $('.date-'+id).html(date);
      }else{
        //$('.draft-'+id).fadeIn();
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
        if ($(window).scrollTop() == ( $(document).height() - $(window).height())  && scrolling_kat==true && $('.hanya-atur').length > 0) {
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
                        offset_kat      = offset_kat+10;
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