<?php

if($Shop->flag_information == 0){
	$Button = "<a href='".base_url("toko/step6")."' class='btn waves-effect waves-light red'><i class='mdi-navigation-chevron-left left'></i> Kembali</a><button type='submit' class='btn waves-effect waves-light'>Lanjut<i class='mdi-navigation-chevron-right right'></i></button>";
}else{
	$Button = "<button class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></button>";
}

echo"
	<div id='divShipment' class='col s12 m12 l12'>
		<form class='formain' id='formstep7' method='POST' action='".base_url("toko/step7/")."'>
			<input type='hidden' name='submit' value='submited'/>
			<div class='formhead'>
				<h2 class='titmain'><b>PENGIRIMAN</b></h2>
				<p>Pilih jasa pengiriman yang didukung oleh toko Anda.</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m8'>
					<input type='checkbox' class='filled-in' id='chkPickUpStore' name='chkPickUpStore' ".($Shop->dm_pick_up_store == 1 ? "checked" : "")."/>
					<label for='chkPickUpStore'>Ambil di toko</label>
				</div>
				<div class='input-field col s12 m8'>
					<p>Pembeli akan datang ke alamat Toko Anda untuk mengambil pesanannya.</p>
				</div>
				<div class='input-field col s12 m8'>
					<input type='checkbox' class='filled-in' onclick=javascript:kliken_exp() id='chkExpedition' name='chkExpedition' ".($Shop->dm_expedition == 1 && count($Couriers) > 0 ? "checked" : "")." ".(count($Couriers) == 0 ? "disabled" : "")."/>
					<label for='chkExpedition'>Jasa ekspedisi</label>
				</div>	
				<div class='input-field col s12 m8'>
					<p>Silahkan pilih jasa ekspedisi berikut. Ongkos kirim sesuai kebijakan Perusahaan Ekspedisi yang bersangkutan.
						<!-- <div class='input-field col s2 m2'><p></p></div> -->
						<div class='menjorog'>
";
$k=0;
foreach($Couriers as $Courier){
	$QCourier = $this->model_toko_courier->get_by_shop_courier($_SESSION["bonobo"]["id"],$Courier->id)->row();
	
	if(!empty($QCourier)){
		$checked = "checked";
	}else{
		$checked = "";
	}
	
	echo"
		<div class='input-field col s12 m6 l3'>
			<input type='checkbox'  class='kurir-resmi-$k' onclick=javascript:kliken_kurir()  id='chkCourier".$Courier->id."'  name='chkCourier".$Courier->id."' ".$checked."/>
			<label for='chkCourier".$Courier->id."'>".$Courier->name."</label>
		</div>		
	";
	$k++;
}

echo"	</div>
		<input type='hidden' value='".count($Couriers)."' id='total_courier'>
	</div>
	<div class='input-field col s12 m8'><p></p></div>
	<div class='input-field col s12 m8'>
		<input type='checkbox' class='filled-in' id='chkStoreDelivery' name='chkStoreDelivery' ".($Shop->dm_store_delivery == 1 ? "checked" : "")."/>
		<label for='chkStoreDelivery'>Kurir Toko</label>
	</div>	
	<div class='input-field col s12 m12'>
		<p>Anda dapat mengatur jasa pengiriman sendiri sebagai Kurir Toko.
			
			<div id='divCustomCourier' style='margin-left:30px;width:100%'>
				<label id='notifStep5'></label>
";
	$no = 1;
	if(sizeOf($CustomeCouriers) <= 0){
		echo"
				<input type='hidden' id='txtCustomeCourierCount' name='txtCustomeCourierCount' value='".$no."'>
				<div id='divCourier".$no."' class='input-field col s12 m12 counter'>
					<div class='input-field col s12 m12 l6'>
						<input type='hidden' id='txtCourierId".$no."' name='txtCourierId".$no."'>
						<input class='hitung' type='text' id='txtCourierName".$no."' name='txtCourierName".$no."' maxlength='20'>
						<label for='txtCourierName".$no."'>Nama Kurir</label>
					</div>
					<div class='input-field col s12 m12 l6'>
						<button type='button' class='waves-effect waves-light btn-floating ' href='javascript:void(0);' onclick=ctrlShopStep7.doCourierSave(".$no.");><i class='material-icons left'>check</i>Simpan</button> 
						<button type='button' class='waves-effect waves-light btn-floating red' href='javascript:void(0);' onclick=ctrlShopStep7.doCourierDelete(".$no.");><i class='mdi-navigation-close left'></i>Hapus</button> 
						<button type='button' class='waves-effect waves-light btn-floating blue' id='aCourierDetail".$no."' href='javascript:void(0);' onclick=ctrlShopStep7.showDetail(".$no."); style='display:none;'><i class='material-icons left'>list</i>Detail</button> 
					</div>
				</div>
		";
	}else{
		foreach($CustomeCouriers as $CustomeCourier){
			echo"
				<div id='divCourier".$no."' class='input-field col s12 m12 counter'>
					<div class='input-field col s12 m12 l6'>
						<input type='hidden' id='txtCourierId".$no."' name='txtCourierId".$no."'  value='".$CustomeCourier->id."'>
						<input class='hitung' type='text' id='txtCourierName".$no."' name='txtCourierName".$no."' value='".$CustomeCourier->name."' maxlength='20'>
						<label for='txtCourierName".$no."'>Nama Kurir</label>
					</div>
					<div class='input-field col s12 m12 l6'>
						<button type='button' class='waves-effect waves-light btn-floating ' href='javascript:void(0);' onclick=ctrlShopStep7.doCourierSave(".$no.");><i class='material-icons left'>check</i>Simpan</button> 
						<button type='button' class='waves-effect waves-light btn-floating red' href='javascript:void(0);' onclick=ctrlShopStep7.doCourierDelete(".$no.");><i class='mdi-navigation-close left'></i>Hapus</button> 
						<button type='button' class='waves-effect waves-light btn-floating blue' id='aCourierDetail1' href='javascript:void(0);' onclick=ctrlShopStep7.showDetail(".$no.");><i class='material-icons left'>list</i>Detail</button> 
					</div>
				</div>
			";
			$no++;
		}
		echo"<input type='hidden' id='txtCustomeCourierCount' name='txtCustomeCourierCount' value='".sizeOf($CustomeCouriers)."'>";
	}
	
	echo"
						</div>
					</p>";
					if(sizeOf($CustomeCouriers) <= 2){
						echo "<p style='margin-left:30px;width:100%' class='input-field col s12 m8' id='tombol-tambah'><a href='javascript:void(0);' id='aCustomeCourierAdd'>[+] Tambah Baru</a></p>";
					}else{
						echo "<p style='margin-left:30px;width:100%;display:none' class='input-field col s12 m8' id='tombol-tambah'><a href='javascript:void(0);' id='aCustomeCourierAdd'>[+] Tambah Baru</a></p>";
					}
					echo"
				</div>
				
				<div class='input-field col s12 m8'><p><br></p></div>
				<div class='input-field col s12 m8'>
					".$Button."
				</div>					
			</div>
		</form>
	</div>
";

echo"
	<div id='divDetail' class='col s12 m12 l12' style='display:none;'>
		<form class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>ATUR JASA PENGIRIMAN TOKO</b></h2>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m6'>
					<a href='#divFormRate' id='aCustomeCourierRate' class='modal-trigger waves-effect waves-light btn deep-orange darken-1 left'>TAMBAH BARU</a>					
				</div>
				<div class='input-field col s12 m6'>
					<h4 class='right light'><span id='lblCustomCourierName' ></span></h4>
					<input type='hidden' id='txtCustomCourierId'  value=''>
				</div>	
				<div class='input-field col s12 m12'>
					<label id='notifStep5Rate'></label>
				</div>
				<div class='input-field col s12 m12'>
					<table class='responsive-table'>
						<thead>
							<tr>
								<th data-field='province'>Province</th>
								<th data-field='kota'>Kota</th>
								<th data-field='kecamatan'>Kecamatan</th>
								<th data-field='price'>Ongkos kirim per KG</th>
								<th data-field='action'>Aksi</th>
							</tr>
						</thead>

						<tbody id='divCustomeCourierTable'></tbody>
					</table>		
				</div>
				<div class='input-field col s12 m12'>
					<button id='btnStep5Back' type='button' class='waves-effect waves-light btn left'>KEMBALI</button>
				</div>
			</div>
		</form>
	</div>
		
	<div id='divFormRate' class='modal modal-fixed-footer'>
		<div class='modal-header deep-orange' id='header-rate'>
			<i class='material-icons left'>check</i> Tambah pengiriman
		</div>
		<div class='modal-content nolpad nolmar' id='divFormRateContent'>
		</div>
		<div class='modal-footer'>
			<button id='btnFormRateSave' class='btn-flat waves-effect waves-light' type='submit' name='action'>Simpan</button>
			<button class='modal-action modal-close btn-flat waves-effect waves-light' type='submit' name='action'> Batal</button>
		</div>
	</div>
			
";

echo"
	<script>
		var ctrlShopStep7 = new CtrlShopStep7();
		ctrlShopStep7.init();
	</script>
";
?>