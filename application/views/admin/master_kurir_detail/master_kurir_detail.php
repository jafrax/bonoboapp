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
			<div class='box-header'>";
			foreach ($ini_nama as $row){
				echo "<h3 class='box-title'>".$row->name."</h3> ";
			}
			echo "	                                  
			</div><!-- /.box-header -->
			<div class='box-body table-responsive'>
				<div class='box-tools'>
					<div class='input-group'>
						<button type='reset' onClick=javascript:dkurir_modal_add() class='btn btn-primary '>Tambah Baru</button>
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
							<th>Harga Per Kg (Rp.)</th>
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
							<td><span id='tp-".$row->id."'>".$row->location_to_province."</span> /
								<span id='tc-".$row->id."'> ".$row->location_to_city." </span> /
								<span id='tk-".$row->id."'> ".$row->location_to_kecamatan." </span>
							</td>
							<td><span id='pr-".$row->id."'>Rp. ".$row->price."</span></td>
							<td>
								<button data-toggle='modal' data-target='.bs-edit-modal-sm-".$row->id."' class='btn btn-primary btn-sm' onClick=javascript:dkurir_modal('".$row->id."') >Edit</button>
							</td>
						</tr>
							<div class='modal fade bs-edit-modal-sm-".$row->id."' id='bs-edit-modal-sm-".$row->id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
							  <div class='modal-dialog modal-sm'>
								<div class='modal-content'>
									<div class='box box-primary'>
								<div id='edit_dk".$row->id."'>
								</div>
								</div><!-- /.box -->
										</div>
									  </div>								
							</div>
						";
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
							<th>Harga Per Kg (Rp.)</th>
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
                    <div class='box-body' id='chosen-add'>				
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
"; 

?>