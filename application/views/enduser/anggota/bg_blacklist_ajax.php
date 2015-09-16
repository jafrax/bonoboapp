<?php	
	


	foreach($Members as $Member){
		$MemberImage = base_url("assets/image/img_default_logo.jpg");
		
		if(!empty($Member->image) && file_exists("./assets/pic/user/".$Member->image)){
			$MemberImage = base_url("assets/pic/user/resize/".$Member->image);
		}
		
		echo"
			<li class='col s12 m6 l4 listanggodaf'>
				<div class='col s12 m5 l4'>
					<img src='".$MemberImage."' class='responsive-img userimg'>
				</div>
				<div class='col s12 m7 l8'>
					<p><a href='#popupBlacklist' onclick=ctrlAnggotaBlacklist.popupDetail2(".$Member->id."); class='modal-trigger'><b class='userangoota'>".$Member->name."</b></a></p>
					<a href='#popupDelete' onclick=ctrlAnggotaBlacklist.popupDelete(".$Member->id.",'".urlencode($Member->name)."'); class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
				</div>
			</li>
		";
	}


?>