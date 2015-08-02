<?php
echo "
<!-- Right side column. Contains the navbar and content of the page -->
<aside class='right-side'>
	<!-- Content Header (Page header) -->
	<section class='content-header'>
		<h1>
			Master Kurir Detail
		</h1>
		<ol class='breadcrumb'>
			<li><a href='".site_url('admin/index/dashboard')."'><i class='fa fa-dashboard'></i> Dashboard</a></li>
			<li class='active'><a href='".site_url('admin/master_kurir')."'>Master Kurir</a></li>
			<li class='active'>Master Kurir Detail</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class='content'>

		<div class='box'>
			<div class='box-header'>
				<h3 class='box-title'>JNE</h3>                                    
			</div><!-- /.box-header -->
			<div class='box-body table-responsive'>
				<div class='box-tools'>
					<div class='input-group'>
						<button onClick=javascript:dkurir_modal_add() class='btn btn-primary '>Tambah Baru</button>
						<span></spam>
						<button data-toggle='modal' data-target='.delete_modal' onclick=javascript:delete_table('admin/kurir_detail/delete') class='btn btn-warning'>Hapus</button>
					</div>
					<div class='input-group'>
						<input type='text' id='search' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search' onChange=javascript:search('#search','admin/kurir_detail/search') />
						<div class='input-group-btn'>
							<button class='btn btn-sm btn-default' onclick=javascript:search('#search','admin/kurir_detail/search')><i class='fa fa-search'></i></button>
						</div>
					</div>
				</div><br>
				<div id='div-paging'>
				<table class='table table-bordered table-striped'>
					<thead>
						<tr>
							<th style='width: 10px'>
								<label>
									<input id='checkall' type='checkbox'>
								</label>
							</th>
							<th>No</th>
							<th>Lokasi Awal</th>
							<th>Lokasi Tujuan</th>
							<th>Harga Per Kg</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>";
					$i=0;
					if ($allDKurir->num_rows > 0){
						foreach($allDKurir->result() as $row ){
						$i++;
						echo "
						<tr class='toko-".$row->id."'>
							<td>
								<label>
									<input class='checkboxDelete' type='checkbox' value='".$row->id."' >
								</label>
							</td>
							<td>$i</td>
							<td><span id='fp-".$row->id."'>".$row->location_from_province."</span> /
								<span id='fc-".$row->id."'> ".$row->location_from_city." </span> /
								<span id='fk-".$row->id."'> ".$row->location_from_kecamatan." </span>
							
							</td>
							<td><span id='fp-".$row->id."'>".$row->location_to_province."</span> /
								<span id='fc-".$row->id."'> ".$row->location_to_city." </span> /
								<span id='fk-".$row->id."'> ".$row->location_to_kecamatan." </span>
							</td>
							<td>".$row->price."</td>
							<td>
								<button class='btn btn-primary btn-sm' onClick=javascript:dkurir_modal('".$row->id."') >Edit</button>
								
							</td>
						</tr>";
						}
					  } else {
							if(isset($search)){
									echo "<tr><td colspan='8'><center>Tidak ditemukan pencarian dengan keyword <b>$search</b></center></td></tr>";
								}else{
									echo "<tr><td colspan='8'><center>zero</center></td></tr>";
								}
					  }
						
					echo "
					</tbody>
					<tfoot>
						<tr>
							<th style='width: 10px'>
								<label>
									<input id='checkall' type='checkbox'>
								</label>
							</th>
							<th>No</th>
							<th>Lokasi Awal</th>
							<th>Lokasi Tujuan</th>
							<th>Harga Per Kg</th>
							<th>Action</th>
					</tfoot>
				</table>
			<div class='box-footer clearfix'>
				$pagination
			</div>
			</div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
		

	</section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->

	<div class='modal fade box-form-dkurir-add' id='box-form-dkurir-add' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
      <div class='modal-dialog modal-sm'>
        <div class='modal-content'>
            <div class='box box-primary'>
                <div class='box-header'>
                    <h3 class='box-title'>Tambah Lokasi</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role='form' id='form-dkurir-add' name='form-dkurir-add'>
                    <div class='box-body'>
					<div class='form-group'>
						<label for=''>Lokasi Awal</label>
						<select  class='chosen-select' name='fprovince' id='fprovince' onchange=javascript:set_city() >
							<option value='' disabled selected>Pilih Provinsi</option>";
							foreach ($get_province->result() as $row_p) {
								$select = '';
								//if ($row_p->province == $row->location_to_province) {$select = 'selected';}
								echo "<option $select value='".$row_p->province."'>".$row_p->province."</option>";
							}	
							echo"
						</select>
					</div>
					<div class='form-group' id='ffkota'>
						<select  class='chosen-select' name='fkota' id='fkota' onchange=javascript:set_kecamatan()>
							<option value='' disabled selected>Pilih Kota</option>";
							foreach ($get_kota->result() as $row_c) {
								$select = '';
								//if ($row_p->city == $row->location_to_city) {$select = 'selected';}
								echo "<option $select value='".$row_c->city."'>".$row_c->city."</option>";
							}	
							echo"
						</select>
					</div>
					<div class='form-group' id='ffkecamatan'>
						<select  class='chosen-select' name='fkecamatan' id='fkecamatan'>
							<option value='' disabled selected>Pilih Kecamatan</option>";
							foreach ($get_kecamatan->result() as $row_p) {
								$select = '';
								//if ($row_p->province == $row->location_to_province) {$select = 'selected';}
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
								$select = '';
								//if ($row_p->province == $row->location_to_province) {$select = 'selected';}
								echo "<option $select value='".$row_p->province."'>".$row_p->province."</option>";
							}	
							echo"
						</select>
					</div>
					<div class='form-group' id='ftkota'>
						<select  class='chosen-select' name='tkota' id='tkota' nchange=javascript:set_tkecamatan()>
							<option value='' disabled selected>Pilih Kota</option>";
							foreach ($get_kota->result() as $row_p) {
								$select = '';
								//if ($row_p->city == $row->location_to_city) {$select = 'selected';}
								echo "<option $select value='".$row_p->city."'>".$row_p->city."</option>";
							}	
							echo"
						</select>
					</div>
					<div class='form-group' id='ftkecamatan'>
						<select  class='chosen-select' name='tkecamatan' id='tkecamatan'>
							<option value='' disabled selected>Pilih Kecamatan</option>";
							foreach ($get_kecamatan->result() as $row_p) {
								$select = '';
								//if ($row_p->province == $row->location_to_province) {$select = 'selected';}
								echo "<option $select value='".$row_p->kecamatan."'>".$row_p->kecamatan."</option>";
							}	
							echo"
						</select>
					</div>
					<div class='form-group'>
						<label for=''>Harga per Kg</label>
						<input type='text' class='form-control' id='hargapkg' name='hargapkg'>
					</div>
					</div><!-- /.box-body -->
                        
                    <div class='box-footer'>
                        <button type='button' class='btn btn-primary form-dkurir-add-btn' onclick=javascript:submit_data('form-dkurir-add','admin/kurir_detail/add') >Submit</button>
                        <button type='button' class='btn btn-primary' data-dismiss='modal' >Cancel</button>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
      </div>
    </div>
	
	<div class='modal fade bs-edit-modal-sm' id='bs-edit-modal-sm' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
	  <div class='modal-dialog modal-sm'>
		<div class='modal-content'>
			<div class='box box-primary'>
				<div class='box-header'>
					<h3 class='box-title'>Edit Lokasi</h3>
				</div><!-- /.box-header -->
				<!-- form start -->
				<form role='form' id='form-dkurir-edit'>
					 <div class='box-body' id='edit_dk'>
					
					</div><!-- /.box-body -->
						
					<div class='box-footer'>
						<button type='button' class='btn btn-primary form-dkurir-edit-btn' onclick=javascript:submit_data_edit('form-dkurir-edit','admin/kurir_detail/edit') >Submit</button>
						<button type='button' class='btn btn-primary' data-dismiss='modal' >Cancel</button>
					</div>
				</form>
			</div><!-- /.box -->
		</div>
	  </div>
	</div>
	
	
"; ?>