<?php	
	
echo"
	<div class='col s12 m12 l3'>
		<ul class='menucontent'>
			<li><a href='".base_url("anggota")."'>ANGGOTA BARU <span class='new badge'>".$countNewMember."</span></a></li>
			<li><a href='".base_url("anggota/invite")."'>KIRIM UNDANGAN</a></li>
			<li><a href='".base_url("anggota/members")."' class='active'>DAFTAR ANGGOTA</a></li>
			<li><a href='".base_url("anggota/blacklist")."'>BLACKLIST</a></li>
		</ul>
	</div>
	
	
	<div class='col s12 m12 l9'>
		<div class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>DAFTAR ANGGOTA</b> <span>( ".sizeOf($jumlah)." Anggota )</span></h2>
			</div>
			<div id='notifMember' align='center' style='display:none;'></div>
			<ul class='row formbody'>
				<form method='POST' action='".base_url("anggota/members/")."'>
				<li class='col s12 listanggodaf'>
					<div class='input-field col s12 m6 right'>
						<i class='mdi-action-search prefix'></i>
						<input id='keyword' name='keyword' type='text' class='validate' value='".$keyword."'>
						<label for='keyword'>Cari anggota</label>
					</div>
				</li>
				</form>
				<div id='ajax-div' >
";
if(sizeOf($Members) <= 0){
	echo"Anda tidak mempunyai anggota";
}else{
	
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
				<div class='col s12 m7 l8'>				
					<p><a href='#popupMembers' onclick=ctrlAnggotaMembers.popupDetail(".$Member->id."); class='modal-trigger tooltipped black-text' data-position='top' data-delay='50' data-tooltip='".$Member->name."'><b class='userangoota'>".$hasil_nama."</b></a></p>
					<p><a href='#setting_harga' onclick=ctrlAnggotaMembers.popupEdit(".$Member->id."); class='modal-trigger' ><b id='label_level_".$Member->id."'>Level : ".$Level."</b></a></p>
					<a href='#popupDelete' onclick=ctrlAnggotaMembers.popupDelete(".$Member->id.",'".base64_encode($Member->name)."'); class='modal-trigger btn-floating btn-xs waves-effect waves-light red right'><i class='mdi-navigation-close'></i></a>
				</div>
			</li>
		";
	}
}
echo"
				</div>
				
			</ul>
			<center>
					<img id='preloader' src='".base_url()."html/images/comp/loading.GIF' style='display:none' /><br>
					<label id='habis' class='green-text' style='display:none'>Semua anggota telah ditampilkan</label>
					<h3><br></h3>
				</center>
		</div>
	</div>
	
	<div id='popupMembers' class='modal modal-fixed-footer'></div>
	
	<div id='popupDelete' class='modal confirmation'>
		<div class='modal-header red'>
			<i class='mdi-navigation-close left'></i> Hapus anggota
		</div>
		<form class='modal-content'>
			<input id='memberDeleteID' type='hidden'>
			<p>Apakah anda yakin ingin menghapus <b id='memberDeleteName'></b> ?</p>
			<p>
				<input id='memberDeleteBlacklist' type='checkbox' class='filled-in' id='blacklist' />
				<label for='memberDeleteBlacklist'>Masukan kedalam blacklist</label>
			</p>
		</form>
		<div class='modal-footer'>
			<a href='javascript:void(0);' id='aMemberDeleteYes' class=' modal-action modal-close waves-effect waves-teal lighten-2 btn-flat'>YA</a>
			<a href='javascript:void(0);' id='aMemberDeleteNo' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
		</div>
	</div>
	
	<div id='setting_harga' class='modal confirmation'>
		<div class='modal-header deep-orange'>
			<i class='mdi-action-spellcheck left'></i> Setting harga
		</div>
		<form id='formMemberLevel' class='modal-content'>
			<input name='id' id='memberEdit' type='hidden' value=''>
			<p>
				<div class='input-field col s12'>
					<select name='level' id='level-saiki' class='browser-default'>						
					";
						if($shop->level_1_active == 1){
							echo "<option value='1'>".($shop->level_1_name == '' ? "Harga Member Umum" : $shop->level_1_name)."</option>";
						}
						if($shop->level_2_active == 1){
							echo "<option value='2'>".($shop->level_2_name == '' ? "Harga Member Langganan" : $shop->level_2_name)."</option>";	
						}
						if($shop->level_3_active == 1){
							echo "<option value='3'>".($shop->level_3_name == '' ? "Harga Khusus-1" : $shop->level_3_name)."</option>";
						}
						if($shop->level_4_active == 1){
							echo "<option value='4'>".($shop->level_4_name == '' ? "Harga Khusus-2" : $shop->level_4_name)."</option>";
						}
						if($shop->level_5_active == 1){
							echo "<option value='5'>".($shop->level_5_name == '' ? "Harga Khusus-3" : $shop->level_5_name)."</option>";
						}
					echo "</select>
				</div>
			</p>
		</form>
		<div class='modal-footer' style='padding-top:20px;'>
			<a href='javascript:void(0);' onclick=javascript:save_level() class='modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
			<a href='javascript:void(0);' id='aMemberLevelNo' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
		</div>
	</div>
	
	<script>
		var ctrlAnggotaMembers = new CtrlAnggotaMembers();
		ctrlAnggotaMembers.init();
	</script>

					
<script>
var offset=12;
var scrolling=true;

$(window).scroll(function () {      
        if ($(window).scrollTop() == ( $(document).height() - $(window).height()) && scrolling==true) {
            $('#preloader').slideDown();
            
            scrolling       = false;            
            var url         = base_url+'anggota/ajax_members/'+offset;
            
            window.scrollTo(0, ($(window).scrollTop()-50) );

            $.ajax({
                type: 'POST',
                data: 'ajax=1&scroll=1',
                url: url,
                success: function(msg) {
                    if (msg){
                        $('#ajax-div').append(msg);
                        $('#preloader').slideUp();
                        offset      = offset + 12;
                        scrolling   = true;

                        $('.modal-trigger').leanModal();

                    }else{
                        $('#preloader').slideUp();
                        scrolling   = false;
                        $('#habis').slideDown();
                    }
                }
            });
            return false;
        }
    });
</script>
							
";

?>