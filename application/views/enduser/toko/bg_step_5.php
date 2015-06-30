<?php

if($Shop->flag_information == 0){
	$Button = "<a href='".base_url("toko/step4")."' class='btn waves-effect waves-light red'><i class='mdi-navigation-chevron-left left'></i> Kembali</a><button class='btn waves-effect waves-light'>Selanjutnya<i class='mdi-navigation-chevron-right right'></i></button>";
}else{
	$Button = "<button class='btn waves-effect waves-light'>Simpan<i class='mdi-navigation-chevron-right right'></i></button>";
}

echo"
	<div id='divShipment' class='col s12 m12 l12'>
		<form class='formain' method='POST' action='".base_url("toko/step5/")."'>
			<input type='hidden' name='submit' value='submited'/>
			<div class='formhead'>
				<h2 class='titmain'><b>PENGIRIMAN</b></h2>
				<p>Pilih jasa pengiriman ayng didukung oleh toko Anda.</p>
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
				<div class='input-field col s12 m8'>
					<p>Anda bisa memasukkan jasa pengiriman lain jika memilikinya.
						<input type='hidden' id='txtCustomeCourierCount' name='txtCustomeCourierCount' value='1'>
						<div id='divCustomCourier' style='margin-left:30px;width:100%'>
							<div id='notifStep5'></div>
							
							<div id='divCourier1' class='input-field col s9 m9'>
								<div class='input-field col s8 m6'>
									<input type='hidden' id='txtCourierId1' name='txtCourierId1'>
									<input type='text' id='txtCourierName1' name='txtCourierName1'>
									<label for='txtCourierName1'>Nama Jasa Pengiriman</label>
								</div>
								<div class='input-field col s4 m6'>
									<a class='left blue-text' href='javascript:void(0);' onclick=ctrlShopStep5.doCourierSave(1);><i class='mdi-action-delete'></i>Simpan</a> 
									<a class='left red-text' href='javascript:void(0);' onclick=ctrlShopStep5.doCourierDelete(1);><i class='mdi-action-delete'></i>Hapus</a> 
									<a class='left black-text' id='aCourierDetail1' href='javascript:void(0);' onclick=ctrlShopStep5.showDetail(1); style='display:none;'><i class='mdi-action-delete'></i>Detail</a> 
								</div>
							</div>
							
						</div>
					</p>
					<p style='margin-left:30px;width:100%' class='input-field col s12 m8'><a href='javascript:void(0);' id='aCustomeCourierAdd'>Tambah Baru</a></p>
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
					Nama Jasa Pengiriman
				</div>
				<div class='input-field col s12 m12'>
					<a href='#jasa_pengiriman' class='modal-trigger waves-effect waves-light btn deep-orange darken-1 right'>TAMBAH BARU</a>
				</div>	
				<div class='input-field col s12 m12'>
					<table class='responsive-table'>
						<thead>
							<tr>
								<th data-field='province'>Province</th>
								<th data-field='kota'>Kota</th>
								<th data-field='kecamatan'>Kecamatan</th>
								<th data-field='price'>Ongkos kirim per KG</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>
									<div class='input-field table'>
										Jawa Tengah
									</div>
								</td>
								<td>
									<div class='input-field table'>
										Surakarta
									</div>
								</td>
								<td>
									<div class='input-field table'>
										Teras
									</div>
								</td>
								<td>
									<div class='input-field table'>
										2000
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class='input-field table'>
										DKI Jakarta
									</div>
								</td>
								<td>
									<div class='input-field table'>
										Jakarta Utara
									</div>
								</td>
								<td>
									<div class='input-field table'>
										Kebun Jeruk
									</div>
								</td>
								<td>
									<div class='input-field table'>
										10000
									</div>
								</td>
							</tr>
						</tbody>
					</table>		
				</div>
				<div class='input-field col s12 m12'>
					<button class='waves-effect waves-light btn left' onclick=ctrlShopStep5.hideDetail();>SIMPAN</button>
					<button class='waves-effect waves-light btn red left' onclick=ctrlShopStep5.hideDetail();>BATAL</button>
				</div>
			</div>
		</form>
	</div>
	
	
	
	<div id='jasa_pengiriman' class='modal'>
	<div class='modal-header red'>
		<i class='material-icons dp48 left'></i> Tambah pengiriman
	</div>
	<form class='modal-content'>
		<div class='row formbody'>
			<div class='col m12'>
				<div class='input-field col s12 m4'>							
					Provinsi								
				</div>
				<div class='input-field col s12 m8'>
					<p>
						<select>
							<option value='' disabled selected>Choose your option</option>
							<option value='1'>Option 1</option>
							<option value='2'>Option 2</option>
							<option value='3'>Option 3</option>
						</select>
					</p>
				</div>
				<div class='input-field col s12 m4'>							
					Kota								
				</div>
				<div class='input-field col s12 m8'>
					<p>
						<select>
							<option value='' disabled selected>Choose your option</option>
							<option value='1'>Option 1</option>
							<option value='2'>Option 2</option>
							<option value='3'>Option 3</option>
						</select>
					</p>
				</div>
				<div class='input-field col s12 m4'>							
					Kecamatan								
				</div>
				<div class='input-field col s12 m8'>
					<p>
						<select>
							<option value='' disabled selected>Choose your option</option>
							<option value='1'>Option 1</option>
							<option value='2'>Option 2</option>
							<option value='3'>Option 3</option>
						</select>									
					</p>
				</div>
				<div class='input-field col s12 m4'>							
					Ongkos Kirim								
				</div>
				<div class='input-field col s12 m8'>
					<p>
						<input id='nama' type='text' class='validate'>										
					</p>
				</div>
			</div>
		</div>
	</form>
	<div class='modal-footer'>
		<button class='btn waves-effect waves-light' type='submit' name='action'>Simpan
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
		var ctrlShopStep5 = new CtrlShopStep5();
		ctrlShopStep5.init();
	</script>
";
?>