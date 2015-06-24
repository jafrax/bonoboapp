function CtrlAnggotaJoinin(){
	this.init = init;
	this.accept = accept;
	this.doDelete = doDelete;
	this.doDeletes = doDeletes;
	this.doAccept = doAccept;
	this.doReject = doReject;
	
	var notifJoinin;
	var formJoininLevel;
	var aJoinLevelYes,aJoinLevelNo;
		
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		notifJoinin = $("#notifJoinin");
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
			notifJoinin.html("Data yang dipilih tidak valid");
			notifJoinin.slideDown();
			notifJoinin.delay(5000).slideUp('slow');
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
						notifJoinin.html(response.message);
						notifJoinin.slideDown();
						notifJoinin.delay(5000).slideUp('slow');
					}
				}
			});
		}
	}
	
	function doDeletes(e){
		var valid = true;
		
		if(e == ""){
			notifJoinin.html("Data toko yang dipilih tidak valid");
			notifJoinin.slideDown();
			notifJoinin.delay(5000).slideUp('slow');
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
						notifJoinin.html(response.message);
						notifJoinin.slideDown();
						notifJoinin.delay(5000).slideUp('slow');
					}
				}
			});
		}
	}
	
	function doAccept(){
		var valid = true;
		var divButton = $("#divButton"+formJoininLevel.id.value);
		
		if(formJoininLevel.id.value == ""){
			notifJoinin.html("Data yang dipilih tidak valid");
			notifJoinin.slideDown();
			notifJoinin.delay(5000).slideUp('slow');
			valid = false;
		}
		
		if(formJoininLevel.level.value == ""){
			notifJoinin.html("Level harus dipilih !");
			notifJoinin.slideDown();
			notifJoinin.delay(5000).slideUp('slow');
			valid = false;
		}
		
		if(divButton == null){
			notifJoinin.html("Komponen tidak ditemukan");
			notifJoinin.slideDown();
			notifJoinin.delay(5000).slideUp('slow');
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
						notifJoinin.html(response.message);
						notifJoinin.slideDown();
						notifJoinin.delay(5000).slideUp('slow');
					}
				}
			});
		}
	}
	
	function doReject(e){
		var valid = true;
		var divButton = $("#divButton"+e);
		
		if(e == ""){
			notifJoinin.html("Data yang dipilih tidak valid");
			notifJoinin.slideDown();
			notifJoinin.delay(5000).slideUp('slow');
			valid = false;
		}
		
		if(divButton == null){
			notifJoinin.html("Komponen tidak ditemukan");
			notifJoinin.slideDown();
			notifJoinin.delay(5000).slideUp('slow');
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
					}else{
						notifJoinin.html(response.message);
						notifJoinin.slideDown();
						notifJoinin.delay(5000).slideUp('slow');
					}
				}
			});
		}
	}
	
}