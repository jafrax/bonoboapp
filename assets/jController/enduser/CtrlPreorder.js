// Created by : dinarwahyu13@gmail.com


/*
* MAIN SCROOL AJAX
*/
var offset_rs=6;
var scrolling_rs=true;

$(window).scroll(function () {      
        if ($(window).scrollTop() == ( $(document).height() - $(window).height()) && scrolling_rs==true && $('#ajax-div').hasClass('preorder')) {
            $('#preloader').slideDown();
            
            scrolling_rs      = false;
            var total_produk  = $('#total_produk').val();
            var uri           = $('#uri').val();
            var url           = base_url+'preorder/index/'+offset_rs;
            
            window.scrollTo(0, ($(window).scrollTop()-50) );

            $.ajax({
                type: 'POST',
                data: 'ajax=1&scroll=1',
                url: url,
                success: function(msg) {
                    if (msg){
                        $('#ajax-div').append(msg);
                        $('#preloader').slideUp();
                        offset      = offset+5;
                        scrolling   = true;                        
                    }else{
                        $('#preloader').slideUp();
                        scrolling   = false;
                        $('#habis').slideDown();
                    }
                }
            });
            return false;
        }
    });


// Notes nota ======================================================================================
function edit_notes (id) {
	$('.notes-'+id).prop("disabled", false);
	$('.tombol-notes-'+id).show();
}

function batal_notes (id) {
	$('.notes-'+id).prop("disabled", true);
	$('.tombol-notes-'+id).hide();
}

function simpan_notes (id) {
	var note = $('.notes-'+id).val();
	$.ajax({
        type: 'POST',
        data: 'id='+id+'&note='+note,
        url: base_url+'nota/change_note',
        success: function(msg) {
        	if (msg == 1) {
        		$('.notes-'+id).prop("disabled", true);
				$('.tombol-notes-'+id).hide();
        	}else{
        		Materialize.toast('Gagal menyimpan notes Anda', 4000);
        	};          	
        } 
    });
}

//=======================================================================================================

function cek_all_nota(){  
  if ($('#pilih-semua').is(":checked")) {
    $('.cek_nota').prop('checked',true);
  }else{
    $('.cek_nota').prop('checked',false);
  }
}

function batal_nota(id){
	$('#btn-batal-'+id).html('loading...');
	$('#btn-batal-'+id).fadeTo('slow',0.5);
	$.ajax({
        type: 'POST',
        data: 'id='+id,
        url: base_url+'nota/nota_batal',
        success: function(msg) {
        	if (msg == 1) {        		
        		$('#btn-batal-'+id).fadeOut();
        		$('#btn-bayar-'+id).fadeOut();
        		$('#lokasi-btn-'+id).html('<br>');
        		$('#lunas-'+id).html('Batal');        		
        		$('#lunas-'+id).addClass('grey-text');
        		$('#lunas-'+id).addClass('red-text');
        	};          	
        } 
    });

}

function delete_nota(id){
	$.ajax({
        type: 'POST',
        data: 'id='+id,
        url: base_url+'nota/nota_delete',
        success: function(msg) {
        	if (msg == 1) {        		
        		$('#nota-'+id).fadeOut().remove();
        		Materialize.toast('Nota telah dihapus', 4000);
        	};          	
        } 
    });
}

function selesaikan(){
  var total_nota  = $('#total-nota').val();

  for (var i = 1 ; i <= total_nota; i++) {
    if ($('#cek-nota-'+i).is(":checked")) {
      var id = $('#cek-'+i).val();      
      $.ajax({
        type: 'POST',
        data: 'id='+id,
        async: false,
        url: base_url+'preorder/selesai_semua',
        success: function(msg) {
          
		  	//$('#btn-batal-'+id).fadeOut();
    		$('#tombol-'+id).fadeOut();
    		//$('#lokasi-btn-'+id).html('<br>');
    		$('#selesai-'+id).html('Selesai');        		
    		$('#selesai-'+id).removeClass('red-text');
    		$('#selesai-'+id).addClass('green-text');
		  
        }
      });
    } if (i == total_nota) {$('.cek_nota').prop('checked',false);$('#pilih-semua').prop('checked',false);}; 
  } 
}

function all_done(id){
    $('#btn-selesai-'+id).fadeTo('slow',0.4);
    $('#btn-selesai-'+id).html('LOADING...');
    
    $.ajax({
        type: 'POST',
        data: 'id='+id,        
        url: base_url+'preorder/selesai_semuanya',
        success: function(msg) {          
            $('#btn-selesai-'+id).fadeTo('slow',1);
            $('#btn-selesai-'+id).html('Selesai Semua');            
            $('#counter-'+id).html('0 Belum Selesai');            
        }
      });
}

//================================================================================================

function change_sort(){
    var sort    = $('#sort').val();    
    var id      = $('#idd').val();

    $('#ajax-div').fadeTo('slow',0.4);
    $.ajax({
        type: 'POST',
        data: 'code='+sort+'&id='+id,
        url: base_url+'preorder/sort',
        success: function(msg) {
            if (msg != 0) {
                $('#ajax-div').html(msg);
                $('#ajax-div').fadeTo('slow',1);
            }else{
                Materialize.toast('Sorting gagal!', 4000);$('#ajax-div').fadeTo('slow',1);
            };
        } 
    });
}

function change_selesai(){
    var selesai = $('#selesaiin').val();
    var id      = $('#idd').val();

    $('#ajax-div').fadeTo('slow',0.4);
    $.ajax({
        type: 'POST',
        data: 'code='+selesai+'&id='+id,
        url: base_url+'preorder/selesai',
        success: function(msg) {
            if (msg != 0) {
                $('#ajax-div').html(msg);
                $('#ajax-div').fadeTo('slow',1);
            }else{
                Materialize.toast('Filter bayar gagal!', 4000);$('#ajax-div').fadeTo('slow',1);
            };
        }
    });
}



(function() {   
    $("#keyword_nota").keypress(function (e) {
    if (e.which == 13) {
        var keyword_nota    = $('#keyword_nota').val();
        var search_by       = $('#search_by').val();
        var idd             = $('#idd').val();

        $('#ajax-div').fadeTo('slow',0.4);
        $.ajax({
            type: 'POST',
            data: 'keyword='+keyword_nota+'&search='+search_by+'&id='+idd,
            url: base_url+'preorder/search',
            success: function(msg) {
                if (msg != 0) {
                    $('#ajax-div').html(msg);
                    $('#ajax-div').fadeTo('slow',1);
                }else{
                    $('#ajax-div').fadeTo('slow',1);
                    Materialize.toast('Nota tidak ditemukan!', 4000);
                };              
            }
        });
    }
});
  
})();