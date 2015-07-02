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
	this.showDetail = showDetail;
	this.hideDetail = hideDetail;
	this.doRateDelete = doRateDelete;
	this.doCourierSave = doCourierSave;
	this.doCourierDelete = doCourierDelete;
	this.loadComboboxCity = loadComboboxCity;
	this.loadComboboxKecamatan = loadComboboxKecamatan;
	this.initPopupRateAdd = initPopupRateAdd;
	
	var sequence = 1;
	var divCustomCourier,divShipment,divDetail,divCustomeCourierTable,divFormRateContent,divCity,divKecamatan;
	var txtCustomeCourierCount, txtCustomCourierId;
	var lblCustomCourierName;
	var aCustomeCourierAdd,aCustomeCourierRate;
	var btnFormRateSave,btnStep5Back;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		aCustomeCourierAdd = $hs("aCustomeCourierAdd");
		aCustomeCourierRate = $hs("aCustomeCourierRate");
		btnFormRateSave = $hs("btnFormRateSave");
		btnStep5Back = $hs("btnStep5Back");
		divCustomCourier = $("#divCustomCourier");
		divShipment = $("#divShipment");
		divDetail = $("#divDetail");
		divFormRateContent = $("#divFormRateContent");
		divCustomeCourierTable = $("#divCustomeCourierTable");
		txtCustomeCourierCount = $hs("txtCustomeCourierCount");
		txtCustomCourierId = $hs("txtCustomCourierId");
		lblCustomCourierName = $hs("lblCustomCourierName");
	}
	
	function initEventlistener(){
		aCustomeCourierAdd.onclick = function(){
			addCustomeCourier();
		};
		
		aCustomeCourierRate.onclick = function(){
			initPopupRateAdd("empty");
		};
		
		btnFormRateSave.onclick = function(){
			doRateSave();
		};
		btnStep5Back.onclick = function(){
			hideDetail();
		};
	}
	
	function setSequence(e){
		sequence = e;
		txtCustomeCourierCount.value = sequence;
	}
	
	function addCustomeCourier(){
		var div = document.createElement('div');
		
		sequence = sequence+1;
		
		div.innerHTML = "<div id='divCourier"+sequence+"' class='input-field col s9 m9'><div class='input-field col s8 m6'><input type='hidden' id='txtCourierId"+sequence+"' name='txtCourierId1'><input type='text' id='txtCourierName"+sequence+"' name='txtCourierName1'><label for='txtCourierName"+sequence+"'>Nama Jasa Pengiriman</label></div><div class='input-field col s4 m6'><a class='left blue-text' href='javascript:void(0);' onclick=ctrlShopStep5.doCourierSave("+sequence+");><i class='mdi-action-delete'></i>Simpan</a> <a class='left red-text' href='javascript:void(0);' onclick=ctrlShopStep5.doCourierDelete("+sequence+");><i class='mdi-action-delete'></i>Hapus</a> <a class='left black-text' id='aCourierDetail"+sequence+"' href='javascript:void(0);' onclick=ctrlShopStep5.showDetail("+sequence+"); style='display:none;'><i class='mdi-action-delete'></i>Detail</a> </div></div>";
		
		divCustomCourier.append(div);
		txtCustomeCourierCount.value = sequence;
	}
	
	function showDetail(e){
		divShipment.slideUp("slow");
		divDetail.slideDown("slow");
		
		initCustomeCourierDetail(e);
	}
	
	function hideDetail(){
		divShipment.slideDown("slow");
		divDetail.slideUp("slow");
	}
	
	function doCourierSave(e){
		var txtCourierId = $hs("txtCourierId"+e);
		var txtCourierName = $hs("txtCourierName"+e);
		var aCourierDetail = $("#aCourierDetail"+e);
		
		$.ajax({
			type: 'POST',
			data: "id="+txtCourierId.value+"&name="+txtCourierName.value,
			url: base_url+'toko/doStep5CourierSave/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					aCourierDetail.slideDown("slow");
					txtCourierId.value = response.id;
				}else{
					$hs_notif("#notifStep5",response.message);
				}
			}
		});
	}
	
	function doCourierDelete(e){
		var txtCourierId = $hs("txtCourierId"+e);
		var divCourier = $("#divCourier"+e);
		
		if(txtCourierId.value == ""){
			divCourier.slideUp("slow");
		}else{
			$.ajax({
				type: 'POST',
				data: "id="+txtCourierId.value,
				url: base_url+'toko/doStep5CourierDelete/',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						divCourier.slideUp("slow");
					}else{
						$hs_notif("#notifStep5",response.message);
					}
				}
			});
		}
	}
	
	function doRateSave(){
		$.ajax({
			type: 'POST',
			data: $('#formStep5Rate').serialize()+"&customCourier="+txtCustomCourierId.value,
			url: base_url+'toko/doStep5RateSave/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					initCustomeCourierTable(txtCustomCourierId.value);
				}else{
					$hs_notif("#notifStep5Rate",response.message);
				}
			}
		});
	}
	
	function doRateDelete(e){
		$.ajax({
			type: 'POST',
			data: "rate="+e,
			url: base_url+'toko/doStep5RateDelete/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					initCustomeCourierTable(txtCustomCourierId.value);
				}else{
					$hs_notif("#notifStep5Rate",response.message);
				}
			}
		});
	}
	
	function initCustomeCourierDetail(e){
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'toko/step5Detail/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					txtCustomCourierId.value = response.id;
					lblCustomCourierName.innerHTML = response.name;
					initCustomeCourierTable(e);
				}
			}
		});
	}
	
	function initCustomeCourierTable(e){
		$.ajax({
			type: 'POST',
			data: "courier="+e,
			url: base_url+'toko/step5Table/',
			success: function(result) {
				divCustomeCourierTable.html(result);
			}
		});
	}
	
	function initPopupRateAdd(e){
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'toko/step5Form/',
			success: function(result) {
				divFormRateContent.html(result);
				
				divCity = $("#divCity");
				divKecamatan = $("#divKecamatan");
				
				initComboBox();
			}
		});
	}
	
	function loadComboboxCity(){
		$.ajax({
			type: 'POST',
			data: "province="+$hs('formStep5Rate').cmbProvince.value,
			url: base_url+'toko/step5ComboboxCity/',
			success: function(result) {
				divCity.html(result);
				loadComboboxKecamatan();
			}
		});
	}
	
	function loadComboboxKecamatan(){
		$.ajax({
			type: 'POST',
			data: "province="+$hs('formStep5Rate').cmbProvince.value+"&city="+$hs('formStep5Rate').cmbCity.value,
			url: base_url+'toko/step5ComboboxKecamatan/',
			success: function(result) {
				divKecamatan.html(result);
			}
		});
	}
}

function CtrlShopStep6(){
	this.init = init;
	this.formEdit = formEdit;
	this.doDelete = doDelete;
	
	var btnAddNew,btnSave;
	var formStep6Add;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		formStep6Add = $hs("formStep6Add");
		btnAddNew = $hs("btnAddNew");
		btnSave = $hs("btnSave");
	}
	
	function initEventlistener(){
		btnAddNew.onclick = function(){
			formClear();
		};
		
		btnSave.onclick = function(){
			doSave();
		};
	}
	
	function formClear(){
		formStep6Add.txtId.value = "";
		formStep6Add.txtName.value = "";
		formStep6Add.txtNo.value = "";
		
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'toko/step6ComboboxBank/',
			success: function(result) {
				$("#divCmbBank").html(result);
			}
		});
	}
	
	function formEdit(e){
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'toko/step6ComboboxBank/',
			success: function(result) {
				$("#divCmbBank").html(result);
			}
		});
		
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'toko/step6GetData/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					formStep6Add = $hs("formStep6Add");
					formStep6Add.txtId.value = response.id;
					formStep6Add.txtName.value = response.acc_name;
					formStep6Add.txtNo.value = response.acc_no;
				}else{
					formClear();
					$hs_notif("#notifStep6",response.message);
				}
			}
		});
	}
	
	function doSave(){
		$.ajax({
			type: 'POST',
			data: $("#formStep6Add").serialize(),
			url: base_url+'toko/doStep6Save/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					top.location.href = base_url+"toko/step6/";
				}else{
					$hs_notif("#notifStep6",response.message);
				}
			}
		});
	}
	
	function doDelete(e){
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'toko/doStep6Delete/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					top.location.href = base_url+"toko/step6/";
				}else{
					$hs_notif("#notifStep6",response.message);
				}
			}
		});
	}
}

function CtrlShopStep7(){
	this.init = init;
	
	var formStep7;
	var btnSave;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		formStep7 = $("#formStep7");
		btnSave = $hs("btnSave");
	}
	
	function initEventlistener(){
		btnSave.onclick = function(){
			doSave();
		};
	}
	
	function doSave(){
		$.ajax({
			type: 'POST',
			data: formStep7.serialize(),
			url: base_url+'toko/doStep7Save/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					$hs_notif("#notifStep7",response.message);
				}else{
					$hs_notif("#notifStep7",response.message);
				}
			}
		});
	}
}
