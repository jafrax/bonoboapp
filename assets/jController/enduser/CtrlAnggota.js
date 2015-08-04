function CtrlAnggotaJoinin(){
	this.init = init;
	this.accept = accept;
	this.doDelete = doDelete;
	this.doDeletes = doDeletes;
	this.doAccept = doAccept;
	this.doReject = doReject;
	
	var formJoininLevel;
	var aJoinLevelYes,aJoinLevelNo;
		
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		formJoininLevel = $hs("formJoininLevel");
		aJoinLevelYes = $hs("aJoinLevelYes");
		aJoinLevelNo = $hs("aJoinLevelNo");
		
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
	
	function accept(e){
		formJoininLevel.id.value = e;
	}
	
	function doDelete(e){
		var valid = true;
		
		if(e == ""){
			$hs_notif("#notifJoinin","Data yang dipilih tidak valid");
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
			$hs_notif("#notifJoinin","Data toko yang dipilih tidak valid");
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
						$hs_notif("#notifJoinin",response.message);
					}
				}
			});
		}
	}
	
	function doAccept(){
		var valid = true;
		var divButton = $("#divButton"+formJoininLevel.id.value);
		
		if(formJoininLevel.id.value == ""){
			$hs_notif("#notifJoinin","Data yang dipilih tidak valid");
			valid = false;
		}
		
		if(formJoininLevel.level.value == ""){
			$hs_notif("#notifJoinin","Level harus dipilih !");
			valid = false;
		}
		
		if(divButton == null){
			$hs_notif("#notifJoinin","Komponen tidak ditemukan");
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
						divButton.html("<a class='waves-effect btn-flat right' onclick=ctrlAnggotaJoinin.doDelete("+formJoininLevel.id.value+")><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>");
						formJoininLevel.id.value = "";
					}else{
						$hs_notif("#notifJoinin",response.message);
					}
				}
			});
		}
	}
	
	function doReject(e){
		var valid = true;
		var divButton = $("#divButton"+e);
		
		if(e == ""){
			$hs_notif("#notifJoinin","Data yang dipilih tidak valid");
			valid = false;
		}
		
		if(divButton == null){
			$hs_notif("#notifJoinin","Komponen tidak ditemukan");
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
						divButton.html("<a class='waves-effect btn-flat right' onclick=ctrlAnggotaJoinin.doDelete("+e+")><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>");
						$("#textku").html('menjadi Anggota toko Anda');
						$(".pesan").css("color", "red").html('<b>ditolak</b>');
						
					}else{
						$hs_notif("#notifJoinin",response.message);
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
				},
				message: {
					required: true,
				}
			},
			messages: {
				email:{
					required: Messagebox_alert("Field ini dibutuhkan"),
					email: Messagebox_alert("Email tidak valid"),
				},
				message:{
					required: Messagebox_alert("Field ini dibutuhkan"),
				}
			}
		});
	}
	
	function doSave(){
		if(!form.valid()){
			Messagebox_timer();
			return;
		}else{
			form.attr("method","POST");
			form.attr("action",base_url+"anggota/invite");
			form.submit();
		}
	}
}



function CtrlAnggotaMembers(){
	this.init = init;
	this.popupDetail = popupDetail;
	this.popupDelete = popupDelete;
	
	var popupMembers;
	var memberDeleteID,memberDeleteName,memberDeleteBlacklist;
	var aMemberDeleteYes,aMemberDeleteNo;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		popupMembers = $("#popupMembers");
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
		memberDeleteBlacklist.checked = true;
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
					$hs_notif("#notifMember",response.message);
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
					$hs_notif("#notifBlacklist",response.message);
				}
			}
		});
	}
	
	function doDeleteCancel(){
		blacklistDeleteID.value = "";
	}
}