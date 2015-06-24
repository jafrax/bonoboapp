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
    var box = "<div class='card' id='div_pic_"+total_picture+"'>"
                  +"<a class='delimg' onclick=javascript:remove_picture('pic_"+total_picture+"')><i class='mdi-content-backspace'></i></a>"
                  +"<div class='card-image waves-effect waves-block waves-light'>"
                     +"<img id='img_pic_"+total_picture+"' onclick=javascript:click_picture('pic_"+total_picture+"') class='img-product responsive-img' src='"+base_url+"html/images/comp/product_large.png'>"
                     +"<input type='file' class='pic_product' name='pic_"+total_picture+"' id='pic_"+total_picture+"' style='opacity: 0.0;width:1px; height:1px' OnChange=javascript:picture_upload(this.id)>"
                  +"</div>"
               +"</div>";
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