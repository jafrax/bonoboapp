
$(document).ready(function() {
	$('#form-dkurir-add').validate({
        rules:{
            fprovince        : {required: true},
            fkota       	 : {required: true},
            fkecamatan       : {required: true},
            tprovince        : {required: true},
            tkota            : {required: true},
            tkecamatan       : {required: true},
            hargapkg         : {required: true},
			
        },
        messages: {
            fprovince: { required: ("cannot be empty"), },
            fkota	: { required: ("cannot be empty"), },
            fkecamatan	: { required: ("cannot be empty"), },
            tprovince	: { required: ("cannot be empty"), },
            tkota	: { required: ("cannot be empty"), },
            tkecamatan	: { required: ("cannot be empty"), },
            hargapkg	: { required: ("cannot be empty"), },
			
        },
    });
})

function dkurir_modal_add() {
	$.ajax({
            type    : "POST",
            url     : base_url+"admin/kurir_detail/add_dk",
            success : function(response){
				$("#box-form-dkurir-add").modal("show").on('shown.bs.modal', function () {
					$('#chosen-add').html(response);
					$('.chosen-select').chosen();
				});
                
            },
            error : function(){
                
            }
        });
}
function dkurir_modal(id) {
$.ajax({
	type    : "POST",
	url     : base_url+"admin/kurir_detail/edit",
	data    : "getid="+id,
	dataType: 'json',
	success : function(response){
		if (response.msg == "success") {
			var data = response[0];
			idedit      = data.id;
				
				$.ajax({
						type: 'POST',
						data: { idedit: data.id, 
								ffprovince: data.location_from_province, 
								ffkota: data.location_from_city, 
								ffkecamatan: data.location_from_kecamatan, 
								ftprovince: data.location_to_province, 
								ftkota: data.location_to_city, 
								ftkecamatan: data.location_to_kecamatan,
								price: data.price,
								},
						url: base_url+'admin/kurir_detail/set_edit',
						success: function(response) {
							$('#edit_dk'+id).html(response);
							$('.chosen-select').chosen();
						}
				});
			
		}
	},
	error : function(){
		
	}
});
}

function submit_data_edit(selection,url) {
        $.ajax({
            type    : "POST",
            url     : base_url+url,
            data    : $("#"+selection).serialize(),
            dataType: 'json',
            success : function(response){
                if (response.msg == "success") {
                    $("#fp-"+idedit).html($("#fprovince").val());
                    $("#fc-"+idedit).html($("#fkota").val());
                    $("#fk-"+idedit).html($("#fkecamatan").val());
                    $("#tp-"+idedit).html($("#tprovince").val());
                    $("#tc-"+idedit).html($("#tkota").val());
                    $("#tk-"+idedit).html($("#tkecamatan").val());
                    $("#pr-"+idedit).html($("#hargapkg").val());
                    $(".modal").modal("hide");
                }else{
                     $("#edit_num"+idedit).show();
                }
            },
            error : function(){
                
            }
        });
}
function set_city(){
    var province = $('#fprovince').val();
    $.ajax({
			type: 'POST',
			data: 'province='+province,
			url: base_url+'admin/kurir_detail/set_city', 
			success: function(city) {
				$('#ffkota').html(city);
				$('#fkota').chosen();
				$('#ffkecamatan').html("<select  class='chosen-select' name='fkecamatan' id='fkecamatan'><option value='' disabled selected>Pilih Kecamatan</option></select>");
				$('#fkecamatan').chosen();
			}
			});
}
function set_kecamatan(){
    var kota = $('#fkota').val();
    $.ajax({
			type: 'POST',
			data: 'kota='+kota,
			url: base_url+'admin/kurir_detail/set_kecamatan', 
			success: function(kec) {
				$('#ffkecamatan').html(kec);
				$('#fkecamatan').chosen();
			}
			});
}
function set_tcity(){
    var province = $('#tprovince').val();
    $.ajax({
			type: 'POST',
			data: 'province='+province,
			url: base_url+'admin/kurir_detail/set_tcity', 
			success: function(city) {
				$('#ftkota').html(city);
				$('#tkota').chosen();
				$('#ftkecamatan').html("<select  class='chosen-select' name='tkecamatan' id='tkecamatan'><option value='' disabled selected>Pilih Kecamatan</option></select>");
				$('#tkecamatan').chosen();
			}
			});
}
function set_tkecamatan(){
    var kota = $('#tkota').val();
    $.ajax({
			type: 'POST',
			data: 'kota='+kota,
			url: base_url+'admin/kurir_detail/set_tkecamatan', 
			success: function(kec) {
				$('#ftkecamatan').html(kec);
				$('#tkecamatan').chosen();
			}
			});
}


