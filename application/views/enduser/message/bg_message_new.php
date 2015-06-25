<?php

echo"
	<div class='right pesan'>
		<input id='cmbMessageAnggota' type='checkbox' class='filled-in'  />
		<label for='cmbMessageAnggota'>Kirim ke semua anggota</label>
	</div>				
					
	<div style='height:120px'>
		<div id='divEmailsTo' class='content-pesan'>
			<h5>Kepada : </h5>
			<input id='emailsTo' type='text' data-role='materialtags'/>
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
	
	<script>
		var ctrlMessageNew = new CtrlMessageNew();
		ctrlMessageNew.init();
	</script>
";

?>