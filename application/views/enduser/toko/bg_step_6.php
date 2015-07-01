<?php

echo"
	<div class='col s12 m12 l12'>
		<form class='formain'>
			<div class='formhead'>
				<h2 class='titmain'><b>BANK</b></h2>
				<p>Masukkan data Bank Anda.</p>
			</div>
			<div class='row formbody'>
				<div class='input-field col s12 m12'>
					<button data-target='modal1' class='btn waves-effect waves-light modal-trigger' type='button' name='action'>
						<i class='mdi-content-add-circle-outline left'></i> Tambah baru
					</button>
					<!-- Modal Structure -->
					<div id='modal1' class='modal'>
						<div class='modal-header red'>
							<i class='mdi-maps-local-atm left'></i> Akun Baru
						</div>
						<div class='modal-content'>								      
							<div class='col s12 m12 l12'>
								<form class='formain'>
									<div class='row formbody'>
										<div class='col m12'>
											<div class='input-field col s12 m12'>							
												Nama Bank								
											</div>
											<div class='input-field col s12 m12'>																
												<select class='chosen-select'>
													<option value='' disabled selected>Choose your option</option>
													<option value='1'>Option 1</option>
													<option value='2'>Option 2</option>
													<option value='3'>Option 3</option>
												</select>																
											</div>
											<div class='input-field col s12 m12'>
												<input id='nama' type='text' class='validate'>
												<label for='nama'>Nama Pemilik Rekening</label>
											</div>
											<div class='input-field col s12 m12'>
												<input id='nama' type='text' class='validate'>
												<label for='nama'>Nomor Rekening</label>
											</div>															
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class='modal-footer'>
							<a href='#!' class='modal-action modal-close waves-effect waves-green btn-flat '>Simpan</a>
							<a href='#!' class='modal-action modal-close waves-effect waves-red btn-flat '>Batal</a>
						</div>
					</div>
				</div>
				<div class='col s12 m8 l4'>
					<div class='card-panel grey lighten-5 z-depth-1'>
						<div class='row valign-wrapper'>
							<div class='col s4'>
								<img src='images/comp/male.png' alt='' class='circle responsive-img'>
							</div>
							<div class='col s10'>
								<blockquote>
									<h5>BRO</h5>
									<h6>Dinar Wahyu W</h6>
									<h6>6911-123-4156-789-1</h6>
								</blockquote>
								<div class='input-field col s6 m12'>
									<button class='btn-flat waves-effect waves-light' type='button' name='action'>
										<i class='mdi-editor-border-color'></i>
									</button>
									<button class='btn-flat waves-effect waves-light' type='button' name='action'>
										<i class='mdi-action-delete'></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col s12 m8 l4'>
					<div class='card-panel grey lighten-5 z-depth-1'>
						<div class='row valign-wrapper'>
							<div class='col s4'>
								<img src='images/comp/male.png' alt='' class='circle responsive-img'>
							</div>
							<div class='col s10'>
								<blockquote>
									<h5>BRO</h5>
									<h6>Dinar Wahyu W</h6>
									<h6>6911-123-4156-789-1</h6>
								</blockquote>
								<div class='input-field col s6 m12'>
									<button class='btn-flat waves-effect waves-light' type='button' name='action'>
										<i class='mdi-editor-border-color'></i>
									</button>
									<button class='btn-flat waves-effect waves-light' type='button' name='action'>
										<i class='mdi-action-delete'></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col s12 m8 l4'>
					<div class='card-panel grey lighten-5 z-depth-1'>
						<div class='row valign-wrapper'>
							<div class='col s4'>
								<img src='images/comp/male.png' alt='' class='circle responsive-img'>
							</div>
							<div class='col s10'>
								<blockquote>
									<h5>BRO</h5>
									<h6>Dinar Wahyu W</h6>
									<h6>6911-123-4156-789-1</h6>
								</blockquote>
								<div class='input-field col s6 m12'>
									<button class='btn-flat waves-effect waves-light' type='button' name='action'>
										<i class='mdi-editor-border-color'></i>
									</button>
									<button class='btn-flat waves-effect waves-light' type='button' name='action'>
										<i class='mdi-action-delete'></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class='col s12 m8 l4'>
					<div class='card-panel grey lighten-5 z-depth-1'>
						<div class='row valign-wrapper'>
							<div class='col s4'>
								<img src='images/comp/male.png' alt='' class='circle responsive-img'>
							</div>
							<div class='col s10'>
								<blockquote>
									<h5>BRO</h5>
									<h6>Dinar Wahyu W</h6>
									<h6>6911-123-4156-789-1</h6>
								</blockquote>
								<div class='input-field col s6 m12'>
									<button class='btn-flat waves-effect waves-light' type='button' name='action'>
										<i class='mdi-editor-border-color'></i>
									</button>
									<button class='btn-flat waves-effect waves-light' type='button' name='action'>
										<i class='mdi-action-delete'></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class='input-field col s12 m12'><p><br></p></div>
				<div class='input-field col s12 m12'>
					<button class='btn waves-effect waves-light red' type='button' onclick='location.href='pengiriman.html'' name='action'>
						<i class='mdi-navigation-chevron-left left'></i> Kembali
					</button>
					<button class='btn waves-effect waves-light' type='button' onclick='location.href='level_harga.html'' name='action'>Selanjutnya
						<i class='mdi-navigation-chevron-right right'></i>
					</button>
				</div>	
			</div>
		</form>
	</div>
";

?>