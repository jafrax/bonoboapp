<?php echo"
<!-- Right side column. Contains the navbar and content of the page -->
	<aside class='right-side'>
		<!-- Content Header (Page header) -->
		<section class='content-header'>
			<h1>
				Master Bank
			</h1>
			<ol class='breadcrumb'>
				<li><a href='#'><i class='fa fa-dashboard'></i> Dashboard</a></li>

				<li class='active'>Master Bank</li>
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
							<button onClick=javascript:bank_modal_add() class='btn btn-primary '>Tambah Baru</button>
							<span></spam>
							<button data-toggle='modal' data-target='.delete_modal' onclick=javascript:delete_table('admin/master_bank/delete') class='btn btn-warning'>Hapus</button>
						</div>
						<div class='input-group'>
							<input type='text' id='search' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search' onChange=javascript:search('#search','admin/master_bank/search') />
							<div class='input-group-btn'>
								<button class='btn btn-sm btn-default' onclick=javascript:search('#search','admin/master_bank/search')><i class='fa fa-search'></i></button>
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
								<th>Nama Bank</th>
								<th>Logo</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>";
						$i=0;
						if ($allMBank->num_rows > 0){
						foreach ($allMBank->result() as $row ){
								$i++;
								$image = base_url().'html/admin/img/credit/dummy_logo.png';
								if(!empty($row->image) && file_exists("./assets/pic/bank/".$row->image)){
									$image = base_url("assets/pic/bank/resize/".$row->image);
								}
								echo "
								<tr class='toko-".$row->id."'>
									<td>
										<label>
											<input class='checkboxDelete' type='checkbox' value='".$row->id."' >
										</label>
									</td>
									<td>$i</td>
									<td id='nama-".$row->id."'>".$row->name."</td>
									<td><img class='logobank' src='$image' /></td>
									<td>
										<button class='btn btn-primary btn-sm' onClick=javascript:bank_modal('".$row->id."') >Edit</button>
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
								<th>Nama Bank</th>
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
<div class='modal fade box-form-bank-edit' id='box-form-bank-edit' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
      <div class='modal-dialog modal-sm'>
        <div class='modal-content'>
            <div class='box box-primary'>
                <div class='box-header'>
                    <h3 class='box-title'>Edit bank</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role='form' id='form-bank-edit'>
                    <div class='box-body'>
                        <div class='form-group'>
                            <label for='namaedit'>Nama bank</label>
                            <input type='text' class='form-control' id='namaedit' name='namaedit' placeholder='Enter nama bank' onchange=javascript:submit_data_edit('form-bank-edit','admin/master_bank/edit') >
                            <input type='hidden' name='idedit' id='idedit'/>
                        </div>
						<div class='form-group'>
                            <label for='exampleInputEmail1'>Logo</label>
                            <button type='button' class='btn btn-info btn-xs'>Broswe</button>
                            <div class='colimg'>
                                <img id='image' class='logobankbig' src='".base_url()."html/admin/img/credit/dummy_logo.png' />
                                <button type='button' class='close'>×</button>
                                <input type='file' id='file-image-edit' name='file-image'>
                            </div>
                        </div>
						
                    </div><!-- /.box-body -->
                        
                    <div class='box-footer'>
                        <button type='button' class='btn btn-primary form-bank-edit-btn' onclick=javascript:submit_data_edit('form-bank-edit','admin/master_bank/edit') >Submit</button>
                        <button type='button' class='btn btn-primary' data-dismiss='modal' >Cancel</button>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
      </div>
    </div>
	
	<div class='modal fade box-form-bank-add' id='box-form-bank-add' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
      <div class='modal-dialog modal-sm'>
        <div class='modal-content'>
            <div class='box box-primary'>
                <div class='box-header'>
                    <h3 class='box-title'>add bank</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role='form' id='form-bank-add' enctype='multipart/form-data' method='post' action='".base_url()."admin/master_bank/add'>
                    <div class='box-body'>
                        <div class='form-group'>
                            <label for='namaadd'>Nama bank</label>
                            <input type='text' class='form-control' id='namaadd' name='namaadd' placeholder='Enter nama bank' onkeypress=javascript:key_enter(event,'form-bank-add','admin/master_bank/add') >
                        </div>
						<div class='form-group'>
                            <label for='exampleInputEmail1'>Logo</label>
                            <button type='button' class='btn btn-info btn-xs' onClick=javascript:klik('file-image')>Broswe</button>
                            <div class='colimg'>
                                <img class='logobankbig' id='file-image-add' src='".base_url()."html/admin/img/credit/dummy_logo.png' />
                                <input type='file' id='file-image' name='file-image' style='display:none;' OnChange=javascript:picture_upload(this.id)>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                        
                    <div class='box-footer'>
                        <button type='submit' class='btn btn-primary form-bank-edit-btn'  >Submit</button>
                        <button type='button' class='btn btn-primary' data-dismiss='modal' >Cancel</button>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
      </div>
    </div>
";
?>