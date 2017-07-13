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
			<li><a href='".site_url('admin/index/dashboard')."'><i class='fa fa-dashboard'></i> Dashboard</a></li>

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
						<button onClick=javascript:kategori_modal_add() class='btn btn-primary '>Tambah Baru</button>
						<span></spam>
						<button data-toggle='modal' data-target='.delete_modal' onclick=javascript:delete_table('admin/master_kategori/delete') class='btn btn-warning'>Hapus</button>
					</div>
					<div class='input-group'>
						<input type='text' id='search' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search' onChange=javascript:search('#search','admin/master_kategori/search') />
						<div class='input-group-btn'>
							<button class='btn btn-sm btn-default' onclick=javascript:search('#search','admin/master_kategori/search')><i class='fa fa-search'></i></button>
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
							<th>Nama Kategori</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>";
					$i=0;
					if ($allMKategori->num_rows > 0){
					foreach ($allMKategori->result() as $row ){
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
								<td>
									<button class='btn btn-primary btn-sm' onClick=javascript:kategori_modal('".$row->id."') >Edit</button>
								</td>
							</tr>";
							}
						}else{
							echo "
									<tr>
										<span> Zero </span>
									</tr>";
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
							<th>Nama Kategori</th>
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

<div class='modal fade box-form-kategori-edit' id='box-form-kategori-edit' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
      <div class='modal-dialog modal-sm'>
        <div class='modal-content'>
            <div class='box box-primary'>
                <div class='box-header'>
                    <h3 class='box-title'>Edit kategori</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role='form' id='form-kategori-edit'>
                    <div class='box-body'>
                        <div class='form-group'>
                            <label for='namaedit'>Nama kategori</label>
                            <input type='text' class='form-control' id='namaedit' name='namaedit' placeholder='Enter nama kategori' onchange=javascript:submit_data_edit('form-kategori-edit','admin/master_kategori/edit') >
                            <input type='hidden' name='idedit' id='idedit'/>
                        </div>
                    </div><!-- /.box-body -->
                        
                    <div class='box-footer'>
                        <button type='button' class='btn btn-primary form-kategori-edit-btn' onclick=javascript:submit_data_edit('form-kategori-edit','admin/master_kategori/edit') >Submit</button>
                        <button type='button' class='btn btn-primary' data-dismiss='modal' >Cancel</button>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
      </div>
    </div>
	
	<div class='modal fade box-form-kategori-add' id='box-form-kategori-add' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
      <div class='modal-dialog modal-sm'>
        <div class='modal-content'>
            <div class='box box-primary'>
                <div class='box-header'>
                    <h3 class='box-title'>add kategori</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role='form' id='form-kategori-add'>
                    <div class='box-body'>
                        <div class='form-group'>
                            <label for='namaadd'>Nama kategori</label>
                            <input type='text' class='form-control' id='namaadd' name='namaadd' placeholder='Enter nama kategori' onkeypress=javascript:key_enter(event,'form-kategori-add','admin/master_kategori/add') >
                        </div>
                    </div><!-- /.box-body -->
                        
                    <div class='box-footer'>
                        <button type='button' class='btn btn-primary form-kategori-edit-btn' onclick=javascript:submit_data('form-kategori-add','admin/master_kategori/add') >Submit</button>
                        <button type='button' class='btn btn-primary' data-dismiss='modal' >Cancel</button>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
      </div>
    </div>

";
?>