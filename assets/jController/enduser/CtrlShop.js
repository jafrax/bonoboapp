function CtrlShopStep1(){
	this.init = init;
	this.loadComboboxCity = loadComboboxCity;
	this.loadComboboxKecamatan = loadComboboxKecamatan;
	
	var formStep1;
	var divCity, divKecamatan;
	var btnNext, btnSave;
	
	function init(){
		initComponent();
		initEventlistener();
	}
	
	function initComponent(){
		formStep1 = $hs("formStep1");
		divCity = $("#divCity");
		divKecamatan = $("#divKecamatan");
		
		notifName = $("#notifName");
		notifTagname = $("#notifTagname");
		
		btnNext = $hs("btnNext");
		btnSave = $hs("btnSave");
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
			$.ajax({
				type: 'POST',
				data: $("#formStep1").serialize(),
				url: base_url+'toko/doStep1Save/',
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
			$.ajax({
				type: 'POST',
				data: $("#formStep1").serialize(),
				url: base_url+'toko/doStep1Save/',
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
}
