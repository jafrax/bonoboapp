<?php

echo"
	<div class='right pesan'>
		<input type='checkbox' class='filled-in' id='via-bank'  />
		<label for='via-bank'>Kirim ke semua anggota</label>
	</div>				
					
	<h5>Kepada : </h5>
	<div class='content-pesan'>
		<input type='text' data-role='materialtags'/>
	</div>

	<div class='content-balasan'>
		<form class='col s12 '>
			<div class='row'>
				<div class='input-field col s12'>
					<textarea id='textarea1' class='materialize-textarea'></textarea>
					<label for='textarea1'>Isi Pesan</label>
				</div>
				<div class='input-field col s12'>
					<button class='btn-flat waves-effect waves-light deep-orange white-text right' type='button' name='action'>
						<i class='mdi-content-send right'></i> Kirim
					</button>
				</div>
			</div>
		</form>
	</div>
";

?>