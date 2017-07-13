<?php
if ($kategori->num_rows() == 0) {
	if (isset($_SESSION['search_kategori'])) {
		echo "Kategori \"".$_SESSION['search_kategori']."\" tidak ditemukan";
		//unset($_SESSION['search_kategori']);
	}else{
		echo "Kategori kosong";
	}
}
	foreach ($kategori->result() as $row) {
		$count = $this->model_produk->count_product_by_category($row->id);
		echo"									
		<li class='col s12 listanggonew' id='kategori-".$row->id."'>
			<div class='col s12 m12 l6'><p><b>".$row->name."</b> <b class='green-text'> $count Produk</b></p>
			</div>
			<div class='col s12 m12 l6'>
				<a href='#delete_kategori_".$row->id."' class='modal-trigger btn-flat right'><b class='text-red'><i class='mdi-av-not-interested left'></i>Hapus</b></a>
				<a href='#edit_kategori_".$row->id."' onclick=javascript:set_rules(".$row->id.") class='modal-trigger btn-flat right'><b class='blue-text'><i class='mdi-editor-border-color left'></i>Edit</b></a>
				<div id='delete_kategori_".$row->id."' class='modal confirmation'>
					<div class='modal-header red'>
						<i class='mdi-navigation-close left'></i> Hapus produk
					</div>
					<form class='modal-content'>
						<p>Apakah anda yakin ingin menghapus <b>'".$row->name."'</b> ?</p>
					</form>
					<div class='modal-footer'>
						<a onclick=javascript:delete_kategori('".$row->id."') class=' modal-action modal-close waves-effect waves-red btn-flat'>YA</a>
						<a  class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
					</div>
				</div>

				<div id='edit_kategori_".$row->id."' class='modal confirmation'>
					<div class='modal-header deep-orange'>
						<i class='mdi-action-spellcheck left'></i> Edit kategori
					</div>
					<form class='modal-content' id='form_edit_kategori_".$row->id."'>
						<p>
							<div class='input-field col s12'>														
								<input id='nama_".$row->id."' name='nama_kategori' type='text' value='".$row->name."' class='validate' required>
								<label for='nama_".$row->id."'>Kategori</label>														
							</div>
					    </p>
					</form>
					<div class='modal-footer'>
						<a href='javascript:void(0)' onclick=javascript:edit_kategori('".$row->id."') class=' modal-action waves-effect waves-red btn-flat'>YA</a>
						<a href='javascript:void(0)' class=' modal-action modal-close waves-effect waves-red btn-flat'>TIDAK</a>
					</div>
				</div>
			</div>
		</li>";
	}

?>				
