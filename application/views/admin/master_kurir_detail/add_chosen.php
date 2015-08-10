<?php
echo"
<div class='form-group'>
	<label for=''>Lokasi Awal</label>
	<select  class='chosen-select error-required' name='fprovince' id='fprovince' onchange=javascript:set_city() >
		<option value='' disabled selected>Pilih Provinsi</option>";
		foreach ($get_province->result() as $row_p) {
			echo "<option value='".$row_p->province."'>".$row_p->province."</option>";
		}	
		echo"
	</select>
</div>
<div class='form-group' id='ffkota'>
	<select  class='chosen-select' name='fkota' id='fkota' onchange=javascript:set_kecamatan()>
		<option value='' disabled selected>Pilih Kota</option>";
		foreach ($get_kota->result() as $row_c) {
			$select = '';
			echo "<option value='".$row_c->city."'>".$row_c->city."</option>";
		}	
		echo"
	</select>
</div>
<div class='form-group' id='ffkecamatan'>
	<select  class='chosen-select' name='fkecamatan' id='fkecamatan'>
		<option value='' disabled selected>Pilih Kecamatan</option>";
		foreach ($get_kecamatan->result() as $row_p) {
			echo "<option $select value='".$row_p->kecamatan."'>".$row_p->kecamatan."</option>";
		}	
		echo"
	</select>
</div>
<div class='form-group'>
	<label for=''>Lokasi Tujuan</label>
	<select  class='chosen-select' name='tprovince' id='tprovince' onchange=javascript:set_tcity()>
		<option value='' disabled selected>Pilih Provinsi</option>";
		foreach ($get_province->result() as $row_p) {
			echo "<option $select value='".$row_p->province."'>".$row_p->province."</option>";
		}	
		echo"
	</select>
</div>
<div class='form-group' id='ftkota'>
	<select  class='chosen-select' name='tkota' id='tkota' nchange=javascript:set_tkecamatan()>
		<option value='' disabled selected>Pilih Kota</option>";
		foreach ($get_kota->result() as $row_p) {
			echo "<option $select value='".$row_p->city."'>".$row_p->city."</option>";
		}	
		echo"
	</select>
</div>
<div class='form-group' id='ftkecamatan'>
	<select  class='chosen-select' name='tkecamatan' id='tkecamatan'>
		<option value='' disabled selected>Pilih Kecamatan</option>";
		foreach ($get_kecamatan->result() as $row_p) {
			echo "<option $select value='".$row_p->kecamatan."'>".$row_p->kecamatan."</option>";
		}	
		echo"
	</select>
</div>
<div class='form-group'>
	<label for=''>Harga per Kg</label>
	<input type='text' class='form-control price' id='hargapkg' name='hargapkg'>
</div>
";

?>