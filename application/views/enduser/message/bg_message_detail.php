<?php

echo"
	<h4>".$Member->name."</h4>
	<div class='content-pesan' onscroll=javascript:ctrlMessageDetail.doScroll(); style='max-height: 300px; overflow: auto;'>		
		<!-- <div class='row'><div class='pesanku'><img src='images/comp/male.png'><br>Keterangan Gambar</div></div> -->
		<div id='loader-message' style='text-align:center;display:none'><img src='".base_url()."html/images/comp/loading.GIF' ></div>
		<div id='habis' style='display:none;font-size:12px;text-align:center;margin:20px' class='green-text'><p >Pesan sudah ditempilkan semua</p></div>
		<div id='message-ajax'>
";

$date = '0000-00-00';
$total_message = count($Messages);
foreach(array_reverse($Messages) as $Message){
	$old_date 			= $Message->create_date;
	$old_date_timestamp = strtotime($old_date);
	$create_date 		= date('Y-m-d', $old_date_timestamp);
	$jam 		= date('H:i', $old_date_timestamp);

	if ($create_date != $date){
		$date = $create_date;

		$print_date 		= $this->hs_datetime->getDate4String($date);

		if ($create_date == date("Y-m-d")) {
			echo "<div class='datetime'><p>Hari Ini</p></div>";
		}else{
			echo "<div class='datetime'><p>".$print_date."</p></div>";
		}
	}

	if($Message->flag_from == 0){
		if($Message->title <> "" or $Message->image <> "" ){
		echo "<div class='row'><div class='pesanku'><img src='".base_url()."assets/pic/product/resize/".$Message->image."' ><br>$Message->title <br><span class='deep-orange-text text-lighten-5' style='font-size:10px;text-align:right;'>$jam</span></div></div> ";
		}
		echo "<div class='row'><div class='pesanku'>".nl2br($Message->message)." <span class='white-text ' style='display:table;font-size:10px'>$jam</span></div></div>";
		
	}else{
		echo "<div class='row'><div class='pesanmu'>".nl2br($Message->message)." <br><span class='deep-orange-text text-lighten-5' style='font-size:10px;text-align:right;'>$jam</span></div></div>";
	}
}

echo"</div>
	</div>
	<input type='hidden' id='total-message' value='$total_message'>
	<input type='hidden' id='member' value='".$Member->id."'>
	<div class='content-balasan'>
		<form id='formMessageDetail' class='col s12 '>
			<div class='row'>
				<div class='input-field col s12'>
					<textarea id='txtMessage' name='txtMessage' class='materialize-textarea' style='max-height:200px!important;'></textarea>
					<label for='txtMessage'>Balasan</label>
				</div>
				<div class='input-field col s12'>
					<button id='btnSend' class='btn-flat waves-effect waves-light deep-orange white-text right' type='button'>
						<i class='mdi-content-send right'></i> Kirim
					</button>
				</div>
			</div>
		</form>
	</div>	

	<script>
		var ctrlMessageDetail = new CtrlMessageDetail();
		ctrlMessageDetail.init();
		ctrlMessageDetail.setMember(".$Member->id.");
	</script>
";

?>