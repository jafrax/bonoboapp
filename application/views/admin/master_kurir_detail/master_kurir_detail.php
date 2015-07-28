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
			<li><a href='#'><i class='fa fa-dashboard'></i> Dashboard</a></li>
			<li class='active'><a href='#'>Master Kurir</a></li>
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
						<button data-toggle='modal' data-target='.bs-add-modal-sm' class='btn btn-primary '>Tambah Baru</button>
					</div>
					<div class='input-group'>
						<input type='text' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search'/>
						<div class='input-group-btn'>
							<button class='btn btn-sm btn-default'><i class='fa fa-search'></i></button>
						</div>
					</div>
				</div><br>
				<table class='table table-bordered table-striped'>
					<thead>
						<tr>
							<th style='width: 10px'><input type='checkbox'></th>
							<th>No</th>
							<th>Lokasi Awal</th>
							<th>Lokasi Tujuan</th>
							<th>Harga Per Kg</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<label>
									<input type='checkbox'>
								</label>
							</td>
							<td>1</td>
							<td>Jawa Tengah (Surakarta)</td>
							<td>Jawa Tengah (Tegal)</td>
							<td>900</td>
							<td>
								<button data-toggle='modal' data-target='.bs-edit-modal-sm' class='btn btn-primary btn-sm'>Edit</button>
								<button data-toggle='modal' data-target='.confirm' class='btn btn-warning btn-sm'>Hapus</button>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th style='width: 10px'></th>
							<th>No</th>
							<th>Lokasi Awal</th>
							<th>Lokasi Tujuan</th>
							<th>Harga Per Kg</th>
							<th>Action</th>
					</tfoot>
				</table>
			</div><!-- /.box-body -->
			<div class='box-footer clearfix'>
				<ul class='pagination pagination-sm no-margin pull-right'>
					<li><a href='#'>&laquo;</a></li>
					<li><a href='#'>1</a></li>
					<li><a href='#'>2</a></li>
					<li><a href='#'>3</a></li>
					<li><a href='#'>&raquo;</a></li>
				</ul>
			</div>
		</div><!-- /.box -->
		

	</section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
"; ?>