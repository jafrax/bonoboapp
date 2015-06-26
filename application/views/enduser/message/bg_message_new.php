<?php

echo"
	<div class='right pesan'>
		<input id='cmbMessageAnggota' type='checkbox' class='filled-in'  />
		<label for='cmbMessageAnggota'>Kirim ke semua anggota</label>
	</div>				
					
	<div style='height:100px;width:350px'>
		<div id='divEmailsTo' class='content-pesan'>
			<h5>Kepada : </h5>
			<select id='memberTo' class='chzn-select' >
				<option value='' disabled selected>Pilih Anggota</option>
";

	foreach($Members as $Member){
		echo"
			<option value='".$Member->id."'>".$Member->name."</option>
		";
	}

echo"
			</select>
		</div>
	</div>
	
	<div class='content-balasan'>
		<form id='formMessageNew' class='col s12'>
			<div class='row'>
				<div class='input-field col s12'>
					<textarea id='txtMessage' name='txtMessage' class='materialize-textarea'></textarea>
					<label for='txtMessage'>Isi Pesan</label>
				</div>
				<div class='input-field col s12'>
					<button id='btnSend'  class='btn-flat waves-effect waves-light deep-orange white-text right' type='button'>
						<i class='mdi-content-send right'></i> Kirim
					</button>
				</div>
			</div>
		</form>
	</div>
	
	
	<!--
		<input id='emailsTo' type='text' data-role='materialtags'/>
		<script>emailsTo.materialtags();</script>
	-->
	
	<script>
		var ctrlMessageNew = new CtrlMessageNew();
		ctrlMessageNew.init();
	</script>
";

?>