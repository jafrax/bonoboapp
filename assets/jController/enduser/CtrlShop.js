function CtrlShopStep1(){
	this.init = init;
	this.loadComboboxCity = loadComboboxCity;
	this.loadComboboxKecamatan = loadComboboxKecamatan;
	
	var formStep1;
	var intAttributeCount;
	var divCity, divKecamatan, divAttributes;
	var imgShopLogo, txtShopLogoFile, aShopLogoDelete;
	var btnNext, btnSave;
	var aAttributeAdd;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		formStep1 = $hs("formStep1");
		divCity = $("#divCity");
		divKecamatan = $("#divKecamatan");
		divAttributes = $("#divAttributes");
		
		imgShopLogo = $hs("imgShopLogo");
		txtShopLogoFile = $hs("txtShopLogoFile");
		intAttributeCount = $hs("intAttributeCount");
		
		notifName = $("#notifName");
		notifTagname = $("#notifTagname");
		
		btnNext = $hs("btnNext");
		btnSave = $hs("btnSave");
		
		aShopLogoDelete = $hs("aShopLogoDelete");
		aAttributeAdd = $hs("aAttributeAdd");
	}
	
	function initEventlistener(){
		if(btnNext != null){
			btnNext.onclick = function(){
				doNext();
			};
		}
		
		if(btnSave != null){
			btnSave.onclick = function(){
				doSave();
			};
		}
		
		imgShopLogo.onclick = function(){
			txtShopLogoFile.click();
		};
		
		txtShopLogoFile.onchange = function(){
			doImageUpload();
		};
		
		aShopLogoDelete.onclick = function(){
			doImageDelete();
		};
		
		aAttributeAdd.onclick = function(){
			var sequence = parseInt(intAttributeCount.value)+1;
			var div = document.createElement("div");
			
			div.innerHTML = "<div class='col s12 m3'>Nama kontak</div><div class='col s12 m5'><input name='txtAttributeId"+sequence+"' type='hidden' value=''><input name='txtAttributeName"+sequence+"' type='text' class='validate'></div><div class='col s12 m3'>Pin/ID/Nomor</div><div class='col s12 m5'><input name='txtAttributeValue"+sequence+"' type='text' class='validate'></div>";
			div.setAttribute("class","row valign-wrapper");
			divAttributes.append(div);
			intAttributeCount.value = sequence;
		};
	}
	
	function doNext(){
		var valid = true;
		
		if(formStep1.txtName.value == ""){
			$hs_notif("#notifName","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(formStep1.txtTagname.value == ""){
			$hs_notif("#notifTagname","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(formStep1.cmbCategory.value == ""){
			$hs_notif("#notifCategory","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(formStep1.cmbProvince.value == ""){
			$hs_notif("#notifProvince","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(formStep1.cmbCity.value == ""){
			$hs_notif("#notifCity","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(formStep1.cmbKecamatan.value == ""){
			$hs_notif("#notifKecamatan","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(valid){
			var formData = new FormData($hs("formStep1"));
			
			$.ajax({
				type: 'POST',
				data: formData,
				url: base_url+'toko/doStep1Save/',
				cache:false,
				contentType: false,
				processData: false,
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						top.location.href = base_url+"toko/step2";
					}else{
						$hs_notif("#notifStep1",response.message);
					}
				}
			});
		}
	}
	
	function doSave(){
		var valid = true;
		
		if(formStep1.txtName.value == ""){
			$hs_notif("#notifName","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(formStep1.txtTagname.value == ""){
			$hs_notif("#notifTagname","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(formStep1.cmbCategory.value == ""){
			$hs_notif("#notifCategory","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(formStep1.cmbProvince.value == ""){
			$hs_notif("#notifProvince","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(formStep1.cmbCity.value == ""){
			$hs_notif("#notifCity","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(formStep1.cmbKecamatan.value == ""){
			$hs_notif("#notifKecamatan","<i class='fa fa-warning'></i> Harus diisi !");
			valid = false;
		}
		
		if(valid){
			var formData = new FormData($hs("formStep1"));
			
			$.ajax({
				type: 'POST',
				data: formData,
				url: base_url+'toko/doStep1Save/',
				cache:false,
				contentType: false,
				processData: false,
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						$hs_notif("#notifStep1",response.message);
					}else{
						$hs_notif("#notifStep1",response.message);
					}
				}
			});
		}
	}
	
	function loadComboboxCity(){
		$.ajax({
			type: 'POST',
			data: "province="+$hs('formStep1').cmbProvince.value,
			url: base_url+'toko/comboboxCity/',
			success: function(result) {
				divCity.html(result);
				loadComboboxKecamatan();
			}
		});
	}
	
	function loadComboboxKecamatan(){
		$.ajax({
			type: 'POST',
			data: "province="+$hs('formStep1').cmbProvince.value+"&city="+$hs('formStep1').cmbCity.value,
			url: base_url+'toko/comboboxKecamatan/',
			success: function(result) {
				divKecamatan.html(result);
			}
		});
	}
	
	function doImageUpload(){
		var URL = window.URL || window.webkitURL;
			
		imgShopLogo.src = URL.createObjectURL(txtShopLogoFile.files[0]);
	}
	
	function doImageDelete(){
		imgShopLogo.src = base_url+"assets/image/img_default_photo.jpg";
	}
}

function CtrlShopStep5(){
	this.init = init;
	this.setSequence = setSequence;
	
	var sequence = 1;
	var divCustomCourier;
	var txtCustomeCourierCount;
	var aCustomeCourierAdd;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		aCustomeCourierAdd = $hs("aCustomeCourierAdd");
		divCustomCourier = $("#divCustomCourier");
		txtCustomeCourierCount = $hs("txtCustomeCourierCount");
	}
	
	function initEventlistener(){
		aCustomeCourierAdd.onclick = function(){
			addCustomeCourier();
		};
	}
	
	function setSequence(e){
		sequence = e;
		txtCustomeCourierCount.value = sequence;
	}
	
	function addCustomeCourier(){
		var div = document.createElement('div');
		
		sequence = sequence+1;
		
		div.innerHTML = "<div class='input-field col s9 m9'><div class='input-field col s8 m6'><input type='text' id='txtCustomeCourier"+sequence+"' name='txtCustomeCourier"+sequence+"'><label for='txtCustomeCourier"+sequence+"'>Nama Jasa Pengiriman</label></div><div class='input-field col s4 m6'><a class='left red-text' href=''><i class='mdi-action-delete'></i>Hapus</a> </div></div>";
		
		divCustomCourier.append(div);
		txtCustomeCourierCount.value = sequence;
	}
}
