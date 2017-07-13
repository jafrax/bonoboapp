<?php
echo "
<div class='box-header'>
	<h3 class='box-title'>Edit Lokasi</h3>
</div><!-- /.box-header -->
<!-- form start -->
<form role='form' id='form-dkurir-edit$idedit' name='form-dkurir-edit$idedit'>
	<input type='hidden' name='idedit' id='idedit' value='$idedit'/>
	<div class='box-body'>
		<div class='form-group' id='ffprovince'>
			<label for=''>Lokasi Awal</label>
			<select  class='chosen-select' name='fprovince' id='fprovince' onchange='javascript:set_city()' >
			<option value='' disabled selected>Pilih Provinsi</option>";
			foreach ($get_province->result() as $row_p) {
			echo "<option value='".$row_p->province."' ".($row_p->province == $ffprovince ? "selected='selected'" : "")." >".$row_p->province."</option>";
			}			
		echo"</select></div>";
		echo "<div class='form-group' id='ffkota'>
			<select  class='chosen-select' name='fkota' id='fkota' onchange=javascript:set_kecamatan()>
			<option value='' disabled selected>Pilih Kota</option>";	
			foreach ($get_fkota->result() as $row_c) {
			echo "<option value='".$row_c->city."' ".($row_c->city == $ffkota ? "selected='selected'" : "")." >".$row_c->city."</option>";
			}
		echo"</select></div>";
		echo "<div class='form-group' id='ffkecamatan'>
			<select  class='chosen-select' name='fkecamatan' id='fkecamatan'>
			<option value='' disabled selected>Pilih Kecamatan</option>";
			foreach ($get_fkecamatan->result() as $row_p) {
			echo "<option value='".$row_p->kecamatan."' ".($row_p->kecamatan == $ffkecamatan ? "selected='selected'" : "")." >".$row_p->kecamatan."</option>";
			}	
		echo"</select></div>";
		echo"<div class='form-group'>
			<label for=''>Lokasi Tujuan</label>
			<select  class='chosen-select' name='tprovince' id='tprovince' onchange=javascript:set_tcity()>
			<option value='' disabled selected>Pilih Provinsi</option>";
			foreach ($get_province->result() as $row_p) {
			echo "<option value='".$row_p->province."' ".($row_p->province == $ftprovince ? "selected='selected'" : "")." >".$row_p->province."</option>";
			}	
		echo"
		</select></div>";
		echo "<div class='form-group' id='ftkota'>
			<select  class='chosen-select' name='tkota' id='tkota' nchange=javascript:set_tkecamatan()>
			<option value='' disabled selected>Pilih Kota</option>";	
			foreach ($get_tkota->result() as $row_p) {
			echo "<option value='".$row_p->city."' ".($row_p->city == $ftkota ? "selected='selected'" : "")." >".$row_p->city."</option>";
			}
		echo"</select></div>";
		echo "<div class='form-group' id='ftkecamatan'>
			<select  class='chosen-select' name='tkecamatan' id='tkecamatan'>
			<option value='' disabled selected>Pilih Kecamatan</option>";
			foreach ($get_tkecamatan->result() as $row_p) {
			echo "<option value='".$row_p->kecamatan."' ".($row_p->kecamatan == $ftkecamatan ? "selected='selected'" : "")." >".$row_p->kecamatan."</option>";
			}	
		echo"</select></div>
		<div class='form-group'>
			<label for=''>Harga per Kg (Rp.)</label>
			<input type='text' class='form-control ribuan'  id='hargapkg' maxlength='11'  name='hargapkg' value='$price' >
			<label id='edit_num$idedit' class='error-required' style='display:none'>cannot be empty</label>
		</div>
	</div><!-- /.box-body -->					
	<div class='box-footer'>
		<button type='button' class='btn btn-primary form-dkurir-edit-btn' onclick=javascript:submit_data_edit('form-dkurir-edit$idedit','admin/kurir_detail/edit') >Submit</button>
		<button type='button' class='btn btn-primary' data-dismiss='modal' >Cancel</button>
	</div>
	<script type='text/javascript' src='".base_url("")."assets/jController/admin/CtrlDkurir.js'></script>
</form>			
";

?>