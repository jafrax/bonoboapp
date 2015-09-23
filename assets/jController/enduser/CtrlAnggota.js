function CtrlAnggotaJoinin(){
	this.init = init;
	this.accept = accept;
	this.doDelete = doDelete;
	this.doDeletes = doDeletes;
	this.doAccept = doAccept;
	this.doReject = doReject;
	this.popupDetail3 = popupDetail3;
		
	var formJoininLevel;
	var aJoinLevelYes,aJoinLevelNo;
	var popupBlacklist;
		
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		formJoininLevel = $hs("formJoininLevel");
		aJoinLevelYes = $hs("aJoinLevelYes");
		aJoinLevelNo = $hs("aJoinLevelNo");
		popupBlacklist = $("#popupBlacklist");
		$('.modal-trigger').leanModal();
	}
	
	function initEventlistener(){
		aJoinLevelYes.onclick = function(){
			doAccept();
		};
		
		aJoinLevelNo.onclick = function(){
			formJoininLevel.id.value = "";
		};
	}
	

	function popupDetail3(e){
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'anggota/members_detail_ab',
			success: function(result) {
				popupBlacklist.html(result);
				popupBlacklist.openModal();
			}
		});
	}

	function accept(e){
		$("#levelbos").val('').trigger('chosen:updated');
		
		if ($('#levelbos option').size() > 1) {
			formJoininLevel.id.value = e;
			$('#setting_harga').openModal();
		}else{
			var divButton = $("#divButton"+e);
			$.ajax({
				type: 'POST',
				data: "id="+e+"&level=1",
				url: base_url+'anggota/doJoininAccept',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						divButton.html("");
						//divButton.html("<a class='waves-effect btn-flat right' onclick=ctrlAnggotaJoinin.doDelete("+formJoininLevel.id.value+")><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>");
						$("#textku"+e).html('menjadi Anggota toko Anda');
						$(".pesan"+e).css("color", "#43a047!important").html('<b>diterima</b>');
						e = "";
						
					}else{
						Materialize.toast(response.message, 4000);						
					}
				}
			});
		};		
	}
	
	function doDelete(e){
		var valid = true;
		
		if(e == ""){			
			Materialize.toast('Data yang dipilih tidak valid', 4000);
			valid = false;
		}
		
		if(valid){
			$.ajax({
				type: 'POST',
				data: "id="+e,
				url: base_url+'anggota/doJoininDelete',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						top.location.href = base_url+"anggota";
					}else{
						$hs_notif("#notifJoinin",response.message);
					}
				}
			});
		}
	}
	
	function doDeletes(e){
		var valid = true;
		
		if(e == ""){
			Materialize.toast('Data yang dipilih tidak valid', 4000);			
			valid = false;
		}
		
		if(valid){
			$.ajax({
				type: 'POST',
				data: "shop_id="+e,
				url: base_url+'anggota/doJoininDeletes',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						top.location.href = base_url+"anggota";
					}else{
						Materialize.toast(response.message, 4000);						
					}
				}
			});
		}
	}
	
	function doAccept(){
		var valid = true;
		var divButton = $("#divButton"+formJoininLevel.id.value);
		
		if(formJoininLevel.id.value == ""){
			Materialize.toast('Data yang dipilih tidak valid', 4000);
			valid = false;
		}
		
		if(formJoininLevel.level.value == ""){
			//jika kosong di isi level 1
			formJoininLevel.level.value = 1;
				//cek lagi jika sudah di isi
				if(formJoininLevel.level.value == ""){
				Materialize.toast('Level harus dipilih !', 4000);			
				valid = false;
				
				}
		}
		
		if(divButton == null){
			Materialize.toast('Komponen tidak ditemukan', 4000);			
			valid = false;
		}
		
		if(valid){
			$.ajax({
				type: 'POST',
				data: "id="+formJoininLevel.id.value+"&level="+formJoininLevel.level.value,
				url: base_url+'anggota/doJoininAccept',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						divButton.html("");
						//divButton.html("<a class='waves-effect btn-flat right' onclick=ctrlAnggotaJoinin.doDelete("+formJoininLevel.id.value+")><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>");
						$("#textku"+formJoininLevel.id.value).html('menjadi Anggota toko Anda');
						$(".pesan"+formJoininLevel.id.value).css("color", "#43a047!important").html('<b>diterima</b>');
						formJoininLevel.id.value = "";
						
					}else{
						Materialize.toast(response.message, 4000);						
					}
				}
			});
		}
	}
	
	function doReject(e){
		var valid = true;
		var divButton = $("#divButton"+e);
		var edi=e;
		
		if(e == ""){
			Materialize.toast('Data yang dipilih tidak valid', 4000);			
			valid = false;
		}
		
		if(divButton == null){
			Materialize.toast('Komponen tidak ditemukan', 4000);			
			valid = false;
		}
		
		if(valid){
			$.ajax({
				type: 'POST',
				data: "id="+e,
				url: base_url+'anggota/doJoininReject',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						//divButton.html("<a class='waves-effect btn-flat right' onclick=ctrlAnggotaJoinin.doDelete("+e+")><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>");
						divButton.html("");
						$("#textku"+e).html('menjadi Anggota toko Anda');
						$(".pesan"+e).css("color", "red").html('<b>ditolak</b>');
						
					}else{
						Materialize.toast(response.message, 4000);						
					}
				}
			});
		}
	}
}


function CtrlAnggotaInvite(){
	this.init = init;
	
	var form;
	var btnSave;
	
	function init(){
		initComponent();
		initEventlistener();
		initValidation();
	}
	
	function initComponent(){
		form = $("#formInvite");
		btnSave = $hs('btnSave');
	}
	
	function initEventlistener(){
		btnSave.onclick = function(){
			doSave();
		};
	}
	
	function initValidation(){
		form.validate({
			rules:{
				email: {
					required: true,
					email: true,
				}
			},
			messages: {
				email:{
					required: message_alert("Field ini dibutuhkan"),
					email: message_alert("Email tidak valid"),
				}
			}
		});
	}
	
	function doSave(){
		if(!form.valid()){
			Messagebox_timer();
			return;
		}else{
        $.ajax({
            type    : "POST",
            url     : base_url+"anggota/invite",
            data    : $("#formInvite").serialize(),
            dataType: 'json',
            success : function(response){
                if (response.msg == "success") {
                    $('#formInvite')[0].reset();
					Materialize.toast(response.notif, 4000);
                    $("label.error").hide();
                    $('#email').focus();
                }else{
                    Materialize.toast(response.notif, 4000);
                }
            },
            error : function(){
                
            }
        });
		}
	}
}



function CtrlAnggotaMembers(){
	this.init = init;
	this.popupDetail = popupDetail;
	this.popupDelete = popupDelete;
	this.popupEdit = popupEdit;
	
	var popupMembers;
	var memberDeleteID,memberDeleteName,memberDeleteBlacklist;
	var aMemberDeleteYes,aMemberDeleteNo;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		popupMembers = $("#popupMembers");
		memberEdit = $hs("memberEdit");
		memberDeleteID = $hs("memberDeleteID");
		memberDeleteName = $hs("memberDeleteName");
		memberDeleteBlacklist = $hs("memberDeleteBlacklist");
		aMemberDeleteYes = $hs("aMemberDeleteYes");
		aMemberDeleteNo = $hs("aMemberDeleteNo");
		
		initComboBox();
	}
	
	function initEventlistener(){
		aMemberDeleteYes.onclick = function(){
			doDelete();
		};
		
		aMemberDeleteNo.onclick = function(){
			doDeleteCancel();
		};
	}
	
	function popupDetail(e){
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'anggota/members_detail',
			success: function(result) {
				popupMembers.html(result);
			}
		});
	}
	
	function popupDelete(e,n){
		memberDeleteID.value = e;
		memberDeleteName.innerHTML = "'"+atob(n)+"'";
		memberDeleteBlacklist.checked = false;
	}

	function popupEdit(e){
		memberEdit.value = e;
		$('#level-saiki').val($('#price_level_'+e).val());		
	}
	
	function doDelete(){
		var checked = "0";
		
		if(memberDeleteBlacklist.checked){
			checked = "1";
		}
		
		$.ajax({
			type: 'POST',
			data: "id="+memberDeleteID.value+"&blacklist="+checked,
			url: base_url+'anggota/doMemberDelete',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					top.location.href = base_url+"anggota/members/";
				}else{
					Materialize.toast(response.message, 4000);					
				}
			}
		});
	}
	
	function doDeleteCancel(){
		memberDeleteID.value = "";
		memberDeleteName.innerHTML = "";
		memberDeleteBlacklist.checked = false;
	}
}




function CtrlAnggotaBlacklist(){
	this.init = init;
	this.popupDetail = popupDetail;
	this.popupDetail2 = popupDetail2;
	this.popupDelete = popupDelete;
	
	var popupBlacklist;
	var blacklistDeleteID;
	var aBlacklistDeleteYes,aBlacklistDeleteNo;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		popupBlacklist = $("#popupBlacklist");
		blacklistDeleteID = $hs("blacklistDeleteID");
		aBlacklistDeleteYes = $hs("aBlacklistDeleteYes");
		aBlacklistDeleteNo = $hs("aBlacklistDeleteNo");
		
		initComboBox();
	}
	
	function initEventlistener(){
		aBlacklistDeleteYes.onclick = function(){
			doDelete();
		};
		
		aBlacklistDeleteNo.onclick = function(){
			doDeleteCancel();
		};
	}
	
	function popupDetail(e){
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'anggota/members_detail',
			success: function(result) {
				popupBlacklist.html(result);
			}
		});
	}
	
	function popupDetail2(e){
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'anggota/members_detail_b',
			success: function(result) {
				popupBlacklist.html(result);
			}
		});
	}

	
	function popupDelete(e,n){
		blacklistDeleteID.value = e;
	}
	
	function doDelete(){
		$.ajax({
			type: 'POST',
			data: "id="+blacklistDeleteID.value,
			url: base_url+'anggota/doBlacklistDelete',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					top.location.href = base_url+"anggota/blacklist/";
				}else{
					Materialize.toast(response.message, 4000);
				}
			}
		});
	}
	
	function doDeleteCancel(){
		blacklistDeleteID.value = "";
	}
}

$(document).ready(function() {
	$('#notifinvite').delay(5000).slideUp('slow');
	$('#email').focus();
})

function save_level () {
	var id    = $('#memberEdit').val();
	var level = $('#level-saiki').val();

	$.ajax({
		type: 'POST',
		data: "id="+id+"&level="+level,
		url: base_url+'anggota/edit_level',
		async:false,
		success: function(result) {
			var response = JSON.parse(result);
			if(response.result == 1){
				location.reload();
				$('#label_level_'+id).html('Level : '+response.message);
				Materialize.toast(response.notif, 4000);
			}else{
				Materialize.toast(response.notif, 4000);
			}
		}
	});
}