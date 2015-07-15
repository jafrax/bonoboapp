function CtrlShopStep1(){
	this.init = init;
	this.loadComboboxCity = loadComboboxCity;
	this.loadComboboxKecamatan = loadComboboxKecamatan;
	this.loadComboboxProv = loadComboboxProv;

	var formStep1,formStep1JQuery;
	var intAttributeCount;
	var divCity, divKecamatan, divAttributes;
	var imgShopLogo, txtShopLogoFile, aShopLogoDelete;
	var btnNext, btnSave;
	var aAttributeAdd,txtPostal;
	
	function init(){
		initComponent();
		initEventlistener();
		initValidation();
	}
	
	function initComponent(){
		formStep1 = $hs("formStep1");
		formStep1JQuery = $("#formStep1");
		divProvince=$("#divProvince");
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
		txtPostal		=$hs('txtPostal');
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
			
			div.innerHTML = "<div class='col s12 m3' id='kontak"+sequence+"'>Nama kontak</div><div class='col s12 m5'><input  name='txtAttributeId"+sequence+"' type='hidden' value=''><input id='txtAttributeId"+sequence+"' name='txtAttributeName"+sequence+"' placeholder='BBM/whatsapp/Line' type='text' class='validate'></div><div class='col s12 m3'>Pin/ID/Nomor</div><div class='col s12 m5'><input name='txtAttributeValue"+sequence+"' type='text' placeholder='Ex : AD9876/bonoboLine' class='validate'></div><div class='col s12 m2'><a class='btn-floating btn-xs waves-effect waves-light red right' onclick=javascript:deletestep1("+sequence+",0)><i class='mdi-navigation-close'></i></a></div>";
			div.setAttribute("class","row valign-wrapper counter attr-"+sequence);
			divAttributes.append(div);
			intAttributeCount.value = sequence;
			if ($('.counter').length > 3 ) {
				//alert($('.counter').length);
				$('#aAttributeAdd').hide();
				return;
			}
		};
		

		
	}
	

	function deletestepsatu(e,a){
		var txtAttributeId = $hs("txtAttributeId"+e);
		var divKontak = $("#divKontak"+e);
		
		if(txtAttributeId.value == ""){
			divKontak.slideUp("slow").remove();
			if ($('.counter').length < 3  ) {			
				$('#aAttributeAdd').show();
			}
		}else{
			$.ajax({
				type: 'POST',
				data: "id="+txtAttributeId.value,
				url: base_url+'toko/dostep1deletekontak/',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						divKontak.slideUp("slow").remove();
					}else{
						$hs_notif("#notifStep5",response.message);
					}
				}
			});
		}
	}

	
	function doNext(){
			var formData = new FormData($hs("formStep1"));
		if(!formStep1JQuery.valid()){
			return false;
		}else{
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
	
	function initValidation(){
		formStep1JQuery.validate({
			rules:{
				txtName: {
					required: true,
				},
				txtTagname: {
					required: true,
					minlength:3,
					maxlength:15,
				},
				cmbProvince: {
					required: true,
				},
				cmbCity: {
					required: true,
				},
				cmbKecamatan: {
					required: true,
				},
			},
			messages: {
				txtName:{
					required: message_alert("Harus diisi !"),
				},
				txtTagname:{
					required: message_alert("Harus diisi !"),
					minlength: message_alert("Masukkan minimal 3 karakter"),
					maxlength: message_alert("Masukkan maksimal 15 karakter"),
				},
				cmbProvince:{
					required: message_alert("Harus diisi !"),
				},
				cmbCity:{
					required: message_alert("Harus diisi !"),
				},
				cmbKecamatan:{
					required: message_alert("Harus diisi !"),
				},
			}
		});
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
		
		if(!formStep1JQuery.valid()){
			return false;
		}else{
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
						window.location.href = base_url+'toko/step2';
					}else{
						$hs_notif("#notifStep1",response.message);
					}
				}
			});
		}
	}
	function loadComboboxProv(){
		var txtPostal= $('#txtPostal').val();
		$.ajax({
			type: 'POST',
			data: "zip_code="+txtPostal,
			url: base_url+'toko/comboboxprov/',
			success: function(result) {
				divProvince.html(result);
				loadComboboxCity();
			}
		});
	}
	
	function loadComboboxCity(){
		var txtPostal= $('#txtPostal').val();
		$.ajax({
			type: 'POST',
			data: "province="+$hs('formStep1').cmbProvince.value+"&zip_code="+txtPostal,
			url: base_url+'toko/comboboxCity/',
			success: function(result) {
				divCity.html(result);
				loadComboboxKecamatan();
			}
		});
	}
	
	function loadComboboxKecamatan(){
		var txtPostal= $('#txtPostal').val();
		$.ajax({
			type: 'POST',
			data: "province="+$hs('formStep1').cmbProvince.value+"&city="+$hs('formStep1').cmbCity.value+"&zip_code="+txtPostal,
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
function CtrlShopStep4(){
	this.init = init;
	
	var btnSave;
	
	function init(){
		initComponent();
		initEventlistener();
		initActive();
	}
	
	function initComponent(){
		btnSave = $hs("btnSave");
		formStep4JQuery = $("#formStep4");
		formStep4 = $hs("formStep4");
	}
	function initEventlistener(){	
		btnSave.onclick = function(){
			doSave();
		};
	}
	
	function initActive(){
	$('[name="chkPaymentCash"]').change(function () {
                if (this.checked) {
                    $('[name="chkPaymentCash2"]').val(1);
                } else {
                    $('[name="chkPaymentCash2"]').val(0);
                }
            });
	$('[name="chkPaymentTransfer"]').change(function () {
                if (this.checked) {
                    $('[name="chkPaymentTransfer2"]').val(1);
                } else {
                    $('[name="chkPaymentTransfer2"]').val(0);
                }
        });
	}
	
	function doSave(){
		$.ajax({
			type: 'POST',
			data: $('#formstep4').serialize(),
			url: base_url+'toko/step4save/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 0){
					 Materialize.toast(response.message, 4000);
				}else{
					window.location.href = base_url+'toko/step5';  
				}
			}
		});
		
	}

}


function CtrlShopStep7(){
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
	var btnFormRateSave,btnStep7Back;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		aCustomeCourierAdd = $hs("aCustomeCourierAdd");
		aCustomeCourierRate = $hs("aCustomeCourierRate");
		btnFormRateSave = $hs("btnFormRateSave");
		btnStep7Back = $hs("btnStep5Back");
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
		btnStep7Back.onclick = function(){
			hideDetail();
		};
	}
	
	function setSequence(e){
		sequence = e;
		txtCustomeCourierCount.value = sequence;
	}
	
	function addCustomeCourier(){
		var div = document.createElement('div');
		

		sequence = sequence+2;

		
		div.innerHTML = "<div id='divCourier"+sequence+"' class='input-field col s12 m12 counter'><div class='input-field col s12 m12 l6'><input type='hidden' id='txtCourierId"+sequence+"' name='txtCourierId1'><input type='text' id='txtCourierName"+sequence+"' name='txtCourierName1'><label for='txtCourierName"+sequence+"'>Nama Jasa Pengiriman</label></div><div class='input-field col s12 m12 l6'><button type='button' class='waves-effect waves-light btn  ' onclick=ctrlShopStep7.doCourierSave("+sequence+");><i class='material-icons left'>library_add</i> Simpan</button> <button class='waves-effect waves-light btn red' type='button' onclick=ctrlShopStep7.doCourierDelete("+sequence+");><i class='mdi-action-delete left'></i>Hapus</button> <button type='button' class='waves-effect waves-light btn blue' id='aCourierDetail"+sequence+"'  onclick=ctrlShopStep7.showDetail("+sequence+"); style='display:none;'><i class='material-icons left'>list</i>Detail</button> </div></div>";
		
		divCustomCourier.append(div);
		txtCustomeCourierCount.value = sequence;
		if ($('.counter').length > 2 ) {
				//alert($('.counter').length);
				$('#tombol-tambah').hide();
				return;
			}
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
			url: base_url+'toko/doStep7CourierSave/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					aCourierDetail.slideDown("slow");
					txtCourierId.value = response.id;
					//location.reload();
				}else{
					Materialize.toast(response.message, 4000);
				}
			}
		});
	}
	
	function doCourierDelete(e){
		var txtCourierId = $hs("txtCourierId"+e);
		var divCourier = $("#divCourier"+e);
		
		
		if(txtCourierId.value == ""){
			divCourier.slideUp("slow").remove();
			if ($('.counter').length < 3  ) {			
				$('#tombol-tambah').show();
			}
		}else{
			$.ajax({
				type: 'POST',
				data: "id="+txtCourierId.value,
				url: base_url+'toko/doStep7CourierDelete/',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						divCourier.slideUp("slow").remove();
						if ($('.counter').length < 3  ) {			
				$('#tombol-tambah').show();
			}
					}else{
						Materialize.toast(response.message, 4000);
					}
				}
			});
		}
	}
	
	function doRateSave(){
		$.ajax({
			type: 'POST',
			data: $('#formStep5Rate').serialize()+"&customCourier="+txtCustomCourierId.value,
			url: base_url+'toko/doStep7RateSave/',
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
			url: base_url+'toko/doStep7RateDelete/',
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
			url: base_url+'toko/step7Detail/',
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
			url: base_url+'toko/step7Table/',
			success: function(result) {
				divCustomeCourierTable.html(result);
			}
		});
	}
	
	function initPopupRateAdd(e){
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'toko/step7Form/',
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
			url: base_url+'toko/step7ComboboxCity/',
			success: function(result) {
		
				divCity.html(result);
				loadComboboxKecamatan();
			}
		});
	}
	
	function loadComboboxKecamatan(){
	var cmbProvince= $('').val();
		$.ajax({
			type: 'POST',
			data: "province="+$hs('formStep5Rate').cmbProvince.value+"&city="+$hs('formStep5Rate').cmbCity.value,
			url: base_url+'toko/step7ComboboxKecamatan/',
			success: function(result) {
				divKecamatan.html(result);
			}
		});
	}
}

function CtrlShopStep8(){
	this.init = init;
	this.formEdit = formEdit;
	this.doDelete = doDelete;
	
	var btnAddNew,btnSave;
	var formStep8Add;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		formStep8Add = $hs("formStep6Add");
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

		formStep8Add.txtId.value = "";
		formStep8Add.txtName.value = "";
		formStep8Add.txtNo.value = "";
		
		$.ajax({
			type: 'POST',
			url: base_url+'toko/step8ComboboxBankadd',
			success: function(result) {
				$('.modal-header').html('<i class="mdi-maps-local-atm left"></i>Akun Baru');
				$("#divCmbBank").html(result);
			}
		});
	}
	
	function formEdit(e){
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'toko/step8ComboboxBank/',
			success: function(result) {
				$('.modal-header').html('<i class="mdi-maps-local-atm left"></i> Edit Akun Bank');
				$("#divCmbBank").html(result);
			}
		});
		
		$.ajax({
			type: 'POST',
			data: "id="+e,
			url: base_url+'toko/step8GetData/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					formStep8Add = $hs("formStep6Add");
					formStep8Add.txtId.value = response.id;
					formStep8Add.txtName.value = response.acc_name;
					formStep8Add.txtNo.value = response.acc_no;
				}else{
					//formClear();
					$('#formStep6Add').reset();
					$hs_notif("#notifStep6",response.message);
				}
			}
		});
	}
	
	function doSave(){
		$.ajax({
			type: 'POST',
			data: $("#formStep6Add").serialize(),
			url: base_url+'toko/doStep8Save/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					top.location.href = base_url+"toko/step8";
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
			url: base_url+'toko/doStep8Delete/',
			success: function(result) {
				var response = JSON.parse(result);
				if(response.result == 1){
					top.location.href = base_url+"toko/step8/";
				}else{
					$hs_notif("#notifStep6",response.message);
				}
			}
		});
	}
}

function CtrlShopStep5(){
        this.init = init;
       
        var formStep5;
        var btnSave;
        var chkLevel5, chkLevel4, chkLevel3, chkLevel2;
       
        function init(){
                initComponent();
                initEventlistener();
                initActive();
        }
       
        function initComponent(){
                formStep5 = $("#formStep7");
                btnSave = $hs("btnSave");
                chkLevel5 = $hs("chkLevel5");
                chkLevel4 = $hs("chkLevel4");
                chkLevel3 = $hs("chkLevel3");
                chkLevel2 = $hs("chkLevel2");
                txtLevel2 = $hs("txtLevel2");
        }
       
        function initEventlistener(){
                btnSave.onclick = function(){
                        doSave();
                };
        }
       
        function initActive(){
            $('#chkLevel2').change(function () {
                if (this.checked) {
                    $('[name="chkLevel2"]').val(1);
                    $('#chkLevel2').val(1);
                    $('[name="txtLevel22"]').prop('disabled', false);
                } else {
                    $('[name="chkLevel2"]').val(0);
                    $('#chkLevel2').val(0);
                    $('[name="txtLevel22"]').prop('disabled', true);
                }
			});
            $('#chkLevel3').change(function () {
                if (this.checked) {
                    $('[name="chkLevel3"]').val(1);
                    $('[name="txtLevel33"]').prop('disabled', false);
                } else {
                    $('[name="chkLevel3"]').val(0);
                    $('[name="txtLevel33"]').prop('disabled', true);
                }
            });
            $('#chkLevel4').change(function () {
                if (this.checked) {
                    $('[name="chkLevel4"]').val(1);
                    $('[name="txtLevel44"]').prop('disabled', false);
                } else {
                    $('[name="chkLevel4"]').val(0);
                    $('[name="txtLevel44"]').prop('disabled', true);
                }
            });
            $('#chkLevel5').change(function () {
                if (this.checked) {
                    $('[name="chkLevel5"]').val(1);
                    $('[name="txtLevel55"]').prop('disabled', false);
                } else {
                    $('[name="chkLevel5"]').val(0);
                    $('[name="txtLevel55"]').prop('disabled', true);
                }
            });
            $('[name="txtLevel22"]').change(function () {
                var txtLevel22 = $('[name="txtLevel22"]').val();
                $('[name="txtLevel2"]').val(txtLevel22);
            });
            $('[name="txtLevel33"]').change(function () {
                var txtLevel33 = $('[name="txtLevel33"]').val();
                $('[name="txtLevel3"]').val(txtLevel33);
            });
            $('[name="txtLevel44"]').change(function () {
                var txtLevel44 = $('[name="txtLevel44"]').val();
                $('[name="txtLevel4"]').val(txtLevel44);
            });
            $('[name="txtLevel55"]').change(function () {
                var txtLevel55 = $('[name="txtLevel55"]').val();
				$('[name="txtLevel5"]').val(txtLevel55);
                });
            chkLevel2.onclick = function on_change(){
                var cek_data = $('[id="chkLevel2"]').val();
                    $.ajax({
                        type: 'POST',
                        data: 'level='+cek_data,
                        url: base_url+'toko/update_level2/',
                        success: function(result) {
							if (result == '1') {
								$('[id="labelLevel2"]').prop('hidden', false);
							}else{
								$('[id="labelLevel2"]').prop('hidden', true);
							}
                        }
                    });
            };
            chkLevel3.onclick = function on_change(){
            var cek_data = $('[id="chkLevel3"]').val();
                $.ajax({
                    type: 'POST',
                    data: 'level='+cek_data,
                    url: base_url+'toko/update_level3/',
                    success: function(result) {
                        if (result == '1') {
                            $('[id="labelLevel3"]').prop('hidden', false);
                        }else{
                            $('[id="labelLevel3"]').prop('hidden', true);
						}
					}
                });
            };
            chkLevel4.onclick = function on_change(){
            var cek_data = $('[id="chkLevel4"]').val();
                $.ajax({
                    type: 'POST',
                    data: 'level='+cek_data,
                    url: base_url+'toko/update_level4/',
                    success: function(result) {
                        if (result == '1') {
                            $('[id="labelLevel4"]').prop('hidden', false);
                        }else{
                            $('[id="labelLevel4"]').prop('hidden', true);
                        }
                    }
                });
            };
            chkLevel5.onclick = function on_change(){
            var cek_data = $('[id="chkLevel5"]').val();
                $.ajax({
                        type: 'POST',
                        data: 'level='+cek_data,
                        url: base_url+'toko/update_level5/',
                        success: function(result) {
                                if (result == '1') {
                                    $('[id="labelLevel5"]').prop('hidden', false);
                                }else{
                                    $('[id="labelLevel5"]').prop('hidden', true);
                                }
                            }
                        });
                    };
                }
                setInterval(level2_autocek, 3000);
                function level2_autocek(){
                    $.ajax({
                            type: 'POST',
                            url: base_url+'toko/autocek_level2',
                            success: function(result) {
                            var response = JSON.parse(result);
                            if (response.result == 0) {
                                $('[id="chkLevel2"]').prop('disabled', false);
                                $('[id="labelLevel2"]').prop('hidden', true);
                            }else{
                                $('[id="chkLevel2"]').prop('disabled', true);
                                $('[id="labelLevel2"]').prop('hidden', false);
                            }
                        }
                    });
                }
                setInterval(level3_autocek, 3000);
                function level3_autocek(){
                    $.ajax({
                        type: 'POST',
                        url: base_url+'toko/autocek_level3',
                        success: function(result) {
                            var response = JSON.parse(result);
                            if (response.result == 0) {
                                $('[id="chkLevel3"]').prop('disabled', false);
                                $('[id="labelLevel3"]').prop('hidden', true);
                            }else{
                                $('[id="chkLevel3"]').prop('disabled', true);
								$('[id="labelLevel3"]').prop('hidden', false);
                            }
                        }
                    });
                }
                setInterval(level4_autocek, 3000);
                function level4_autocek(){
                   $.ajax({
						type: 'POST',
						url: base_url+'toko/autocek_level4',
						success: function(result) {
							var response = JSON.parse(result);
							if (response.result == 0) {
								$('[id="chkLevel4"]').prop('disabled', false);
								$('[id="labelLevel4"]').prop('hidden', true);
							}else{
								$('[id="chkLevel4"]').prop('disabled', true);
								$('[id="labelLevel4"]').prop('hidden', false);
							}
                        }
                    });
                }
                setInterval(level5_autocek, 3000);
                function level5_autocek(){
                    $.ajax({
                    type: 'POST',
                    url: base_url+'toko/autocek_level5',
                    success: function(result) {
                        var response = JSON.parse(result);
                        if (response.result == 0) {
                            $('[id="chkLevel5"]').prop('disabled', false);
                            $('[id="labelLevel5"]').prop('hidden', true);
                        }else{
							$('[id="chkLevel5"]').prop('disabled', true);
                            $('[id="labelLevel5"]').prop('hidden', false);
                        }
                    }
                    });
                }

        function doSave(){
                $.ajax({
                    type: 'POST',
                    data:formStep5.serialize(),
                    url: base_url+'toko/doStep5Save/',
                    success: function(result) {
                            var response = JSON.parse(result);
                            if(response.result == 1){
                                window.location.href = base_url+'toko/step6';                                  
                            }else{
                                $hs_notif("#notifStep7",response.message);
                            }
                        }
                });
        }
}


function deletestep1(e,a){
		var txtAttributeId = $("#txtAttributeId"+e);
		var divKontak = $(".attr-"+e);
		
		if(a == 0){
			divKontak.slideUp("slow").remove();
			if ($('.counter').length <= 3  ) {			
				$('#aAttributeAdd').show();
			}
		}else{
			$.ajax({
				type: 'POST',
				data: "id="+a,
				url: base_url+'toko/dostep1deletekontak/',
				success: function(result) {
					var response = JSON.parse(result);
					if(response.result == 1){
						divKontak.slideUp("slow").remove();
						if ($('.counter').length <= 3  ) {			
							$('#aAttributeAdd').show();
						}
					}else{
						$hs_notif("#notifStep5",response.message);
					}
				}
			});
		}
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
