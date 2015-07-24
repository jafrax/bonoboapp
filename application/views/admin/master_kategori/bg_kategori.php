<?php
echo "
<!-- Right side column. Contains the navbar and content of the page -->
<aside class='right-side'>
	<!-- Content Header (Page header) -->
	<section class='content-header'>
		<h1>
			Master Kategori
		</h1>
		<ol class='breadcrumb'>
			<li><a href='#'><i class='fa fa-dashboard'></i> Dashboard</a></li>

			<li class='active'>Master Kategori</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class='content'>

		<div class='box'>
			<div class='box-header'>
				<h3 class='box-title'></h3>                                    
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
							<th>No</th>
							<th>Nama Kategori</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>";
					$i=0;
					if (empty($allMKategori)){
					echo "
						<tr>
							<span> Zero </span>
						</tr>";
						}else{
							foreach ($allMKategori->result() as $row ){
							$i++;
							echo "
							<tr>
								<td>$i</td>
								<td>".$row->name."</td>
								<td>
									<button data-toggle='modal' data-target='.bs-edit-modal-sm' class='btn btn-primary btn-sm'>Edit</button>
									<button data-toggle='modal' data-target='.confirm' class='btn btn-warning btn-sm'>Hapus</button>
								</td>
							</tr>";
							}
						}
					echo "	
					</tbody>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Nama Kategori</th>
							<th>Action</th>
					</tfoot>
				</table>
			</div><!-- /.box-body -->
			<div class='box-footer clearfix'>
				$pagination
			</div>
		</div><!-- /.box -->
	</section><!-- /.content -->
</aside><!-- /.right-side -->
</div><!-- ./wrapper -->
";
?>