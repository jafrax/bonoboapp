<?php

if(!empty($Member)){
	$MemberImage = base_url("assets/image/img_default_photo.jpg");
		
	if(!empty($Member->image) && file_exists("./assets/pic/user/".$Member->image)){
		$MemberImage = base_url("assets/pic/user/resize/".$Member->image);
	}
	
	$Attributes = $this->model_member_attribute->get_by_member($Member->id)->result();
	$Locations = $this->model_member_location->get_by_member($Member->id)->result();

	echo"
		<div class='row modal-content'>
			<div class='col s12 m3 l3'>
				<img src='".$MemberImage."' class='responsive-img userimg'>
			</div>
			<div class='col s12 m9 l9 formdetilpup'>
				<p><b>Email :</b>".$Member->email."</p>
				<p><b>Nama :</b>".$Member->name."</p>
				<p><b>Hand Phone :</b>".$Member->phone."</p>
	";
	
	foreach($Attributes as $Attribute){
		echo"<p><b>".$Attribute->name." :</b>".$Attribute->value."</p>";
	}
	
	echo"
		</div>
		<div class='col s12 m12 l12 formdetilpup'>
			<h6><b>Alamat</b></h6>
		</div>";
	
	foreach($Locations as $Location){
		echo"
			<div class='col s12 m12 l12 formdetilpup'>
				<p><b>Propinsi :</b>".$Location->location_province."</p>
				<p><b>Kota :</b>".$Location->location_city."</p>
				<p><b>Kecamatan :</b>".$Location->location_kecamatan."</p>
				<p><b>Alamat :</b>".$Location->address."</p>
				<p><b>Kodepos :</b>".$Location->location_postal."</p><br>
			</div>
		";
	}
	
	echo"</div>";
}else{
	echo"
		<div class='row modal-content'>
			Data anggota tidak ditemukan
		</div>
	";
}

echo"
	<div class='modal-footer'>
		<a href='".base_url("anggota")."' class='waves-effect waves-red btn-flat'>KELUAR</a>
	</div>
";
?>