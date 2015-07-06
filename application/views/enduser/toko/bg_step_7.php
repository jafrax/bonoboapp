<?php

echo"
	<div class='col s12 m12 l12'>
		<form id='formStep7' class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>ATUR LEVEL HARGA</b></h2>
				<p>Anda bisa mendefinisikan nama untuk setiap level harga di toko Anda.</p>
			</div>
			<div class='row formbody'>
				<div class='linehead right-align'>
					<b class='labelisasi'>AKTIF</b>
				</div>
				<div class='input-field col s12 m8'>
					<h6>Level 1</h6>
					<input name='txtLevel1' type='text' class='validate' value='".$Shop->level_1_name."' autofocus>
				</div>
				<div class='input-field col s12 m4'>
					<div class='col s12 m12 right-align'>
						<p class='right'>
						<input type='checkbox' id='chkLevel1' name='chkLevel1' ".($Shop->level_1_active == 1 ? "checked" : "")." />
						<label for='chkLevel1'></label>
						</p>
					</div>
				</div>
			</div>
			<div class='row formbody'>							
				<div class='linehead'></div>
				<div class='input-field col s12 m8'>
					<h6>Level 2</h6>
					<input name='txtLevel2' type='text' class='validate' value='".$Shop->level_2_name."'>
				</div>
				<div class='input-field col s12 m4'>
					<div class='col s12 m12 right-align'>
						<p class='right'>
						<input type='checkbox' id='chkLevel2' name='chkLevel2' ".($Shop->level_2_active == 1 ? "checked" : "")." />
						<label for='chkLevel2'></label>
						</p>
					</div>
				</div>
			</div>
			<div class='row formbody'>							
				<div class='linehead'></div>
				<div class='input-field col s12 m8'>
					<h6>Level 3</h6>
					<input name='txtLevel3' type='text' class='validate' value='".$Shop->level_3_name."'>
				</div>
				<div class='input-field col s12 m4'>
					<div class='col s12 m12 right-align'>
						<p class='right'>
						<input type='checkbox' id='chkLevel3' name='chkLevel3' ".($Shop->level_3_active == 1 ? "checked" : "")." />
						<label for='chkLevel3'></label>
						</p>
					</div>
				</div>
			</div>
			<div class='row formbody'>							
				<div class='linehead'></div>
				<div class='input-field col s12 m8'>
					<h6>Level 4</h6>
					<input name='txtLevel4' type='text' class='validate' value='".$Shop->level_4_name."'>
				</div>
				<div class='input-field col s12 m4'>
					<div class='col s12 m12 right-align'>
						<p class='right'>
						<input type='checkbox' id='chkLevel4' name='chkLevel4' ".($Shop->level_4_active == 1 ? "checked" : "")." />
						<label for='chkLevel4'></label>
						</p>
					</div>
				</div>
			</div>
			<div class='row formbody'>							
				<div class='linehead'></div>
				<div class='input-field col s12 m8'>
					<h6>Level 5</h6>
					<input name='txtLevel5' type='text' class='validate' value='".$Shop->level_5_name."'>
				</div>
				<div class='input-field col s12 m4'>
					<div class='col s12 m12 right-align'>
						<p class='right'>
						<input type='checkbox' id='chkLevel5' name='chkLevel5' ".($Shop->level_5_active == 1 ? "checked" : "")." />
						<label for='chkLevel5'></label>
						</p>
					</div>
				</div>
			</div>
			<div class='row formbody'>
				<button id='btnSave' class='btn waves-effect waves-light' type='button'>Simpan<i class='mdi-navigation-chevron-right right'></i></button>
				<label id='notifStep7' style='display:none;'></label>
			</div>
		</form>
	</div>
	
	<script>
		var ctrlShopStep7 = new CtrlShopStep7();
		ctrlShopStep7.init();
	</script>
";

?>