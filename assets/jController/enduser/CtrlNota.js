// Created by : dinarwahyu13@gmail.com


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

function go(){
  var total_nota  = $('#total-nota').val();
  var option        = $('#option-go').val();
  var url           = '';

  if (option == 0) {
    url = base_url+'nota/nota_batal';
  } else if (option == 1) {
    url = base_url+'nota/nota_delete';
  }


  for (var i = 1 ; i <= total_nota; i++) {
    if ($('#cek-nota-'+i).is(":checked")) {
      var id = $('#cek-'+i).val();      
      $.ajax({
        type: 'POST',
        data: 'id='+id,
        async: false,
        url: url,
        success: function(msg) {
          if (option == 1) {
		    $('#nota-'+id).fadeOut().remove();
		  } else {
		  	$('#btn-batal-'+id).fadeOut();
    		$('#btn-bayar-'+id).fadeOut();
    		$('#lokasi-btn-'+id).html('<br>');
    		$('#lunas-'+id).html('Batal');        		
    		$('#lunas-'+id).addClass('grey-text');
    		$('#lunas-'+id).addClass('red-text');
		  }

        }
      });
    } if (i == total_nota) {$('.cek_nota').prop('checked',false);$('#pilih-semua').prop('checked',false);}; 
  } 
}




function change_metode(id){
	var metode = $('#metode-'+id).val();

	if (metode == 1) {
		$('#rekening-'+id).hide();
	}else{
		$('#rekening-'+id).fadeIn();
	};
}

function konfirmasi(id){
	var metode 		= $('#metode-'+id).val();
	var rekening 	= $('#rek-'+id).val();	

	$.ajax({
        type: 'POST',
        data: 'id='+id+'&metode='+metode+'&rekening='+rekening,
        url: base_url+'nota/konfirmasi',
        success: function(msg) {
        	if (msg == 1) {        		
        		
        		Materialize.toast('Nota telah di konfirmasi', 4000);
        	};          	
        } 
    });
}


function set_location(){
    var postal = $('#postal-code').val();
    if (postal.length == 5) {        
        $.ajax({
            type: 'POST',
            async: true,
            data: 'postal='+postal,
            url: base_url+'nota/set_location',
            success: function(msg) {
                if (msg == 0) {             
                    Materialize.toast('Kode pos salah', 4000);
                }else{
                    $('#panggon-province').html(msg);
                    $('#province').chosen();
                    $.ajax({type: 'POST',data: 'postal='+postal,url: base_url+'nota/set_city', success: function(city) {$('#panggon-city').html(city);$('#city').chosen();}});
                    $.ajax({type: 'POST',data: 'postal='+postal,url: base_url+'nota/set_kecamatan', success: function(kecamatan) {$('#panggon-kecamatan').html(kecamatan);$('#kecamatan').chosen();}});
                }
            } 
        });
    }
}

function set_city(){
    var province = $('#province').val();
    $.ajax({type: 'POST',data: 'province='+province,url: base_url+'nota/set_city_prov', success: function(city) {$('#panggon-city').html(city);$('#city').chosen();}});
}

function set_kecamatan(){
    var city = $('#city').val();
    $.ajax({type: 'POST',data: 'city='+city,url: base_url+'nota/set_kecamatan_city', success: function(kecamatan) {$('#panggon-kecamatan').html(kecamatan);$('#kecamatan').chosen();}});
}

function confirm_courier(){
    var pengiriman = $('#form-pengiriman');

    $.ajax({
        type: 'POST',
        data: pengiriman.serialize(),
        url: base_url+'nota/pengiriman',
        success: function(msg) {
            if (msg == 1) {
                Materialize.toast('Pengiriman telah di konfirmasi', 4000);
            };              
        } 
    });
}