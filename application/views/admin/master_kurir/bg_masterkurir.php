<?php echo"
<!-- Right side column. Contains the navbar and content of the page -->
	<aside class='right-side'>
		<!-- Content Header (Page header) -->
		<section class='content-header'>
			<h1>
				Master kurir
			</h1>
			<ol class='breadcrumb'>
				<li><a href='#'><i class='fa fa-dashboard'></i> Dashboard</a></li>

				<li class='active'>Master kurir</li>
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
							<button onClick=javascript:kurir_modal_add() class='btn btn-primary '>Tambah Baru</button>
							<span></spam>
							<button data-toggle='modal' data-target='.delete_modal' onclick=javascript:delete_table('admin/master_kurir/delete') class='btn btn-warning'>Hapus</button>
						</div>
						<div class='input-group'>
							<input type='text' id='search' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search' onChange=javascript:search('#search','admin/master_kurir/search') />
							<div class='input-group-btn'>
								<button class='btn btn-sm btn-default' onclick=javascript:search('#search','admin/master_kurir/search')><i class='fa fa-search'></i></button>
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
								<th>Nama kurir</th>
								<th>Logo</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>";
						$i=0;
						if ($allMKurir->num_rows > 0){
						foreach ($allMKurir->result() as $row ){
						$id_link=base64_encode($row->id);
								$i++;
								echo "
								<tr class='toko-".$row->id."'>
									<td>
										<label>
											<input class='checkboxDelete' type='checkbox' value='".$row->id."' >
										</label>
									</td>
									<td>$i</td>
									<td id='nama-".$row->id."'>".$row->name."</td>
									<td><img class='logokurir' src='img/credit/dummy_logo.png' /></td>
									<td>
										<button class='btn btn-primary btn-sm' onClick=javascript:kurir_modal('".$row->id."') >Edit</button>
										<a href='".base_url('admin/kurir_detail/index/'.$id_link.'')."' class='btn btn-info btn-sm'>Detail</a>
									</td>
								</tr>";
								}
							}else{
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
								<th>Nama kurir</th>
								<th>Logo</th>
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
<div class='modal fade box-form-kurir-edit' id='box-form-kurir-edit' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
      <div class='modal-dialog modal-sm'>
        <div class='modal-content'>
            <div class='box box-primary'>
                <div class='box-header'>
                    <h3 class='box-title'>Edit kurir</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role='form' id='form-kurir-edit'>
                    <div class='box-body'>
                        <div class='form-group'>
                            <label for='namaedit'>Nama kurir</label>
                            <input type='text' class='form-control' id='namaedit' name='namaedit' placeholder='Enter nama kurir' onchange=javascript:submit_data_edit('form-kurir-edit','admin/master_kurir/edit') >
                            <input type='hidden' name='idedit' id='idedit'/>
                        </div>
						<div class='form-group'>
                            <label for='exampleInputEmail1'>Logo</label>
                            <button type='button' class='btn btn-info btn-xs'>Broswe</button>
                            <div class='colimg'>
                                <img class='logokurirbig' src='img/credit/dummy_logo_big.png' />
                                <button type='button' class='close'>×</button>
                            </div>
                        </div>
						
                    </div><!-- /.box-body -->
                        
                    <div class='box-footer'>
                        <button type='button' class='btn btn-primary form-kurir-edit-btn' onclick=javascript:submit_data_edit('form-kurir-edit','admin/master_kurir/edit') >Submit</button>
                        <button type='button' class='btn btn-primary' data-dismiss='modal' >Cancel</button>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
      </div>
    </div>
	
	<div class='modal fade box-form-kurir-add' id='box-form-kurir-add' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
      <div class='modal-dialog modal-sm'>
        <div class='modal-content'>
            <div class='box box-primary'>
                <div class='box-header'>
                    <h3 class='box-title'>add kurir</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role='form' id='form-kurir-add'>
                    <div class='box-body'>
                        <div class='form-group'>
                            <label for='namaadd'>Nama kurir</label>
                            <input type='text' class='form-control' id='namaadd' name='namaadd' placeholder='Enter nama kurir' onkeypress=javascript:key_enter(event,'form-kurir-add','admin/master_kurir/add') >
                        </div>
						<div class='form-group'>
                            <label for='exampleInputEmail1'>Logo</label>
                            <button type='button' class='btn btn-info btn-xs'>Broswe</button>
                            <div class='colimg'>
                                <img class='logokurirbig' src='img/credit/dummy_logo_big.png' />
                                <button type='button' class='close'>×</button>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                        
                    <div class='box-footer'>
                        <button type='button' class='btn btn-primary form-kurir-edit-btn' onclick=javascript:submit_data('form-kurir-add','admin/master_kurir/add') >Submit</button>
                        <button type='button' class='btn btn-primary' data-dismiss='modal' >Cancel</button>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
      </div>
    </div>
";
?>