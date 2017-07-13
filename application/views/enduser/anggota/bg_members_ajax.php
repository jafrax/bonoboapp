<?php	
	foreach($Members as $Member){
		$hasil_nama=$this->template->limitc($Member->name);
		$Level = "Unknown";
		$MemberImage = base_url("assets/image/img_default_logo.jpg");
		
		if(!empty($Member->image) && file_exists("./assets/pic/user/".$Member->image)){
			$MemberImage = base_url("assets/pic/user/resize/".$Member->image);
		}
		
		$ShopMember = $this->model_toko_member->get_by_shop_member($shop->id,$Member->id)->row();
		if(!empty($ShopMember)){
			if($ShopMember->price_level == 1){
				$Level = $shop->level_1_name;
			}elseif($ShopMember->price_level == 2){
				$Level = $shop->level_2_name;
			}elseif($ShopMember->price_level == 3){
				$Level = $shop->level_3_name;
			}elseif($ShopMember->price_level == 4){
				$Level = $shop->level_4_name;
			}elseif($ShopMember->price_level == 5){
				$Level = $shop->level_5_name;
			}
		}
		
		echo"
			<li class='col s12 m6 l4 listanggodaf'>
				<div class='col s12 m5 l4'>
					<img src='".$MemberImage."' class='responsive-img userimg'>
					<input type='hidden' id='price_level_".$Member->id."' value='".$ShopMember->price_level."'>
				</div> 
				<div class='col s12 m7 l7'>				
					<p><a href='#popupMembers' onclick=ctrlAnggotaMembers.popupDetail(".$Member->id."); class='modal-trigger tooltipped' data-position='top' data-delay='50' data-tooltip='".$Member->name."'><b class='userangoota'>".$hasil_nama."</b></a></p>
					<p><a href='#setting_harga' onclick=ctrlAnggotaMembers.popupEdit(".$Member->id."); class='modal-trigger' ><b id='label_level_".$Member->id."'>Level : ".$Level."</b></a></p>
					<a href='#popupDelete' onclick=ctrlAnggotaMembers.popupDelete(".$Member->id.",'".base64_encode($Member->name)."'); class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
				</div>
			</li>
		";
	}

?>