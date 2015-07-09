<?php

echo "
	<div class='col s12 m12 l12'>
		<ul class='menucontent row'>
			<li class='col s12 m6 l3 langkah ".($this->uri->segment(2) == "" ? "active" : "")."'>
				<a href='".base_url("toko/")."'>
					<div class='card-panel '>
						<span class='white-text'>1. INFORMASI TOKO</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
					</div>
				</a>
			</li>
			<li class='col s12 m6 l3 langkah ".($this->uri->segment(2) == "step2" ? "active" : "")."'>
				<a href='".base_url("toko/step2")."'>
					<div class='card-panel '>
						<span class='white-text'>2. ATUR PRIVASI</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
					</div>
				</a>
			</li>
			<li class='col s12 m6 l3 langkah ".($this->uri->segment(2) == "step3" ? "active" : "")."'>
				<a href='".base_url("toko/step3")."'>
					<div class='card-panel '>
						<span class='white-text'>3. ATUR PENGURANGAN STOK</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
					</div>
				</a>
			</li>
			<li class='col s12 m6 l3 langkah ".($this->uri->segment(2) == "step4" ? "active" : "")."'>
				<a href='".base_url("toko/step4")."'>
					<div class='card-panel '>
						<span class='white-text'>4. METODE TRANSAKSI</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
					</div>
				</a>
			</li>
			<li class='col s12 m6 l3 langkah ".($this->uri->segment(2) == "step5" ? "active" : "")."'>
				<a href='".base_url("toko/step5")."'>
					<div class='card-panel '>
						<span class='white-text'>5. ATUR LEVEL HARGA</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
					</div>
				</a>
			</li>
			<li class='col s12 m6 l3 langkah ".($this->uri->segment(2) == "step6" ? "active" : "")."'>
				<a href='".base_url("toko/step6")."'>
					<div class='card-panel '>
						<span class='white-text'>6. METODE KONFIRMASI</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
					</div>
				</a>
			</li>
			<li class='col s12 m6 l3 langkah ".($this->uri->segment(2) == "step7" ? "active" : "")."'>
				<a href='".base_url("toko/step7")."'>
					<div class='card-panel '>
						<span class='white-text'>7. PENGIRIMAN</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
					</div>
				</a>
			</li>			
			<li class='col s12 m6 l3 langkah ".($this->uri->segment(2) == "step8" ? "active" : "")."'>
				<a href='".base_url("toko/step8")."'>
					<div class='card-panel '>
						<span class='white-text'>8. BANK</span><i class='mdi-hardware-keyboard-arrow-right right'></i>
					</div>
				</a>
			</li>
			
		</ul>
	</div>
";
?>