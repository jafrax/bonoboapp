<?php 
echo"
<!-- Right side column. Contains the navbar and content of the page -->
<aside class='right-side'>
	<!-- Content Header (Page header) -->
	<section class='content-header'>
		<h1>
			Master Lokasi
		</h1>
		<ol class='breadcrumb'>
			<li><a href='#'><i class='fa fa-dashboard'></i> Dashboard</a></li>

			<li class='active'>Master Lokasi</li>
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
						<input type='text' id='search' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search' onChange=javascript:search('#search','admin/master_lokasi/search') />
						<div class='input-group-btn'>
							<button class='btn btn-sm btn-default' onclick=javascript:search('#search','admin/daftar_toko/search')><i class='fa fa-search'></i></button>
						</div>
					</div>
				</div><br>
				<div id='div-paging'>
				<table class='table table-bordered table-striped'>
					<thead>
						<tr>
							<th>No</th>
							<th>Kodepos</th>
							<th>Keluarahan</th>
							<th>Kecamatan</th>
							<th>Kota</th>
							<th>Propinsi</th>
						</tr>
					</thead>
					<tbody>";
					$i=0;
					if($allMLokasi->num_rows > 0){
						foreach ($allMLokasi->result() as $row ){
							$i++;
							echo "
								<tr>
									<td>$i</td>
									<td>".$row->postal_code."</td>
									<td>".$row->kelurahan."</td>
									<td>".$row->kecamatan."</td>
									<td>".$row->city."</td>
									<td>".$row->province."</td>
								</tr>
								";
							}
					}else{
						echo "
						<tr>
							<td colspan='6'>Zero</td>
						 </tr>
						";
					}
					echo "	
					</tbody>
					<tfoot>
						<tr>
							<th>No</th>
							<th>Kodepos</th>
							<th>Keluarahan</th>
							<th>Kecamatan</th>
							<th>Kota</th>
							<th>Propinsi</th>
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
";
?>