<?php

echo"
	<h4>".$Member->name."</h4>
	<div class='content-pesan'>
		<!--
			<div class='datetime'><p>30 September 2015</p></div>
			<div class='row'><div class='pesanku'><img src='images/comp/male.png'><br>Keterangan Gambar</div></div>
		-->

";

foreach($Messages as $Message){
	if($Message->flag_from == 1){
		echo"<div class='row'><div class='pesanku'>".$Message->message."</div></div>";
	}else{
		echo"<div class='row'><div class='pesanmu'>".$Message->message."</div></div>";
	}
}

echo"
	</div>
	<div class='content-balasan'>
		<form id='formMessageDetail' class='col s12 '>
			<div class='row'>
				<div class='input-field col s12'>
					<textarea id='txtMessage' name='txtMessage' class='materialize-textarea'></textarea>
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