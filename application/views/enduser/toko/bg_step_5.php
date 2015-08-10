<?php

if($Shop->flag_information == 0){
	$Button = "<a href='".base_url("toko/step6")."' class='btn waves-effect waves-light red'><i class='mdi-navigation-chevron-left left'></i> Kembali</a><button type='submit' class='btn waves-effect waves-light'>Selanjutnya<i class='mdi-navigation-chevron-right right'></i></button>";
}else{
	$Button = "<button class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></button>";
}

echo"
	<div id='divShipment' class='col s12 m12 l12'>
		<form class='formain' method='POST' action='".base_url("toko/step7/")."'>
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
					<input type='checkbox' class='filled-in' id='chkExpedition' name='chkExpedition' ".($Shop->dm_expedition == 1 ? "checked" : "")."/>
					<label for='chkExpedition'>Jasa ekspedisi</label>
				</div>	
				<div class='input-field col s12 m8'>
					<p>Silahkan pilih jasa ekspedisi berikut. Ongkos kirim sesuai kebijakan Perusahaan Ekspedisi yang bersangkutan.
						<div class='input-field col s2 m2'><p></p></div>
";

foreach($Couriers as $Courier){
	$QCourier = $this->model_toko_courier->get_by_shop_courier($_SESSION["bonobo"]["id"],$Courier->id)->row();
	
	if(!empty($QCourier)){
		$checked = "checked";
	}else{
		$checked = "";
	}
	
	echo"
		<div class='input-field col s5 m2'>
			<input type='checkbox' id='chkCourier".$Courier->id."'  name='chkCourier".$Courier->id."' ".$checked."/>
			<label for='chkCourier".$Courier->id."'>".$Courier->name."</label>
		</div>
	";
}

echo"	
		</p>
	</div>
	<div class='input-field col s12 m8'><p></p></div>
	<div class='input-field col s12 m8'>
		<input type='checkbox' class='filled-in' id='chkStoreDelivery' name='chkStoreDelivery' ".($Shop->dm_store_delivery == 1 ? "checked" : "")."/>
		<label for='chkStoreDelivery'>Jasa pengiriman Toko</label>
	</div>	
	<div class='input-field col s12 m12'>
		<p>Anda bisa memasukkan jasa pengiriman lain jika memilikinya.
			
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
						<input type='text' id='txtCourierName".$no."' name='txtCourierName".$no."' maxlength='20'>
						<label for='txtCourierName".$no."'>Nama Jasa Pengiriman</label>
					</div>
					<div class='input-field col s12 m12 l6'>
						<button type='button' class='waves-effect waves-light btn ' href='javascript:void(0);' onclick=ctrlShopStep7.doCourierSave(".$no.");><i class='material-icons left'>library_add</i>Simpan</button> 
						<button type='button' class='waves-effect waves-light btn red' href='javascript:void(0);' onclick=ctrlShopStep7.doCourierDelete(".$no.");><i class='mdi-action-delete left'></i>Hapus</button> 
						<button type='button' class='waves-effect waves-light btn blue' id='aCourierDetail".$no."' href='javascript:void(0);' onclick=ctrlShopStep7.showDetail(".$no."); style='display:none;'><i class='material-icons left'>list</i>Detail</button> 
					</div>
				</div>
		";
	}else{
		foreach($CustomeCouriers as $CustomeCourier){
			echo"
				<div id='divCourier".$no."' class='input-field col s12 m12 counter'>
					<div class='input-field col s12 m12 l6'>
						<input type='hidden' id='txtCourierId".$no."' name='txtCourierId".$no."'  value='".$CustomeCourier->id."'>
						<input type='text' id='txtCourierName".$no."' name='txtCourierName".$no."' value='".$CustomeCourier->name."'>
						<label for='txtCourierName".$no."'>Nama Jasa Pengiriman</label>
					</div>
					<div class='input-field col s12 m12 l6'>
						<button type='button' class='waves-effect waves-light btn ' href='javascript:void(0);' onclick=ctrlShopStep7.doCourierSave(".$no.");><i class='material-icons left'>library_add</i>Simpan</button> 
						<button type='button' class='waves-effect waves-light btn red' href='javascript:void(0);' onclick=ctrlShopStep7.doCourierDelete(".$no.");><i class='mdi-action-delete left'></i>Hapus</button> 
						<button type='button' class='waves-effect waves-light btn blue' id='aCourierDetail1' href='javascript:void(0);' onclick=ctrlShopStep7.showDetail(".$no.");><i class='material-icons left'>list</i>Detail</button> 
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
				<div class='input-field col s12 m4'>
					<input type='hidden' id='txtCustomCourierId' value=''>
					<b><label id='lblCustomCourierName'></label></b>
				</div>
				<div class='input-field col s12 m12'>
					<a href='#divFormRate' id='aCustomeCourierRate' class='modal-trigger waves-effect waves-light btn deep-orange darken-1 right'>TAMBAH BARU</a>
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
		<div class='modal-header red'>
			<i class='material-icons left'>library_add</i> Tambah pengiriman
		</div>
		<div id='divFormRateContent'>
		</div>
		<div class='modal-footer'>
			<button id='btnFormRateSave' class='btn modal-close waves-effect waves-light' type='submit' name='action'>Simpan
				<i class='mdi-content-save left'></i>
			</button>
			<button class='modal-action modal-close btn waves-effect waves-light red' type='submit' name='action'>
				<i class='mdi-navigation-cancel left'></i> Batal
			</button>
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