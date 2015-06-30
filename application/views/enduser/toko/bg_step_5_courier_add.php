<?php

echo"
	<div class='col s12 m12 l12'>
		<form class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>ATUR JASA PENGIRIMAN TOKO</b></h2>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m4'>
					<input id='nama' type='text' class='validate'>
					<label for='nama'>Nama Jasa</label>
				</div>
				<div class='input-field col s12 m12'>
					<a href='#jasa_pengiriman' class='modal-trigger waves-effect waves-light btn deep-orange darken-1 right'>TAMBAH BARU</a>
				</div>	
				<div class='input-field col s12 m12'>
					<table class='responsive-table'>
						<thead>
							<tr>
								<th data-field='province'>Province</th>
								<th data-field='kota'>Kota</th>
								<th data-field='kecamatan'>Kecamatan</th>
								<th data-field='price'>Ongkos kirim per KG</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>
									<div class='input-field table'>
										<select>
											<option value='' disabled selected>Choose your option</option>
											<option value='1'>Option 1</option>
											<option value='2'>Option 2</option>
											<option value='3'>Option 3</option>
										</select>
									</div>
								</td>
								<td>
									<div class='input-field table'>
										<select>
											<option value='' disabled selected>Choose your option</option>
											<option value='1'>Option 1</option>
											<option value='2'>Option 2</option>
											<option value='3'>Option 3</option>
										</select>
									</div>
								</td>
								<td>
									<div class='input-field table'>
										<select>
											<option value='' disabled selected>Choose your option</option>
											<option value='1'>Option 1</option>
											<option value='2'>Option 2</option>
											<option value='3'>Option 3</option>
										</select>
									</div>
								</td>
								<td>
									<div class='input-field table'>
										<input id='nama' type='text' placeholder='Ongkos' class='validate'>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div class='input-field table'>
										<select>
											<option value='' disabled selected>Choose your option</option>
											<option value='1'>Option 1</option>
											<option value='2'>Option 2</option>
											<option value='3'>Option 3</option>
										</select>
									</div>
								</td>
								<td>
									<div class='input-field table'>
										<select>
											<option value='' disabled selected>Choose your option</option>
											<option value='1'>Option 1</option>
											<option value='2'>Option 2</option>
											<option value='3'>Option 3</option>
										</select>
									</div>
								</td>
								<td>
									<div class='input-field table'>
										<select>
											<option value='' disabled selected>Choose your option</option>
											<option value='1'>Option 1</option>
											<option value='2'>Option 2</option>
											<option value='3'>Option 3</option>
										</select>
									</div>
								</td>
								<td>
									<div class='input-field table'>
										<input id='nama' type='text' placeholder='Ongkos' class='validate'>
									</div>
								</td>
							</tr>
						</tbody>
					</table>		
				</div>
				<div class='input-field col s12 m12'>
					<button class='waves-effect waves-light btn left'>SIMPAN</button>
					<button class='waves-effect waves-light btn red left'>BATAL</button>
				</div>
			</div>
		</form>
	</div>
";

?>