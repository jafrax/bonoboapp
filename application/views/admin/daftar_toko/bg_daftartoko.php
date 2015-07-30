<?php
echo"
<!-- Right side column. Contains the navbar and content of the page -->
		<aside class='right-side'>
			<!-- Content Header (Page header) -->
			<section class='content-header'>
				<h1>
					Daftar Toko
				</h1>
				<ol class='breadcrumb'>
					<li><a href='#'><i class='fa fa-dashboard'></i> Dashboard</a></li>

					<li class='active'>Daftar Toko</li>
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
										<button data-toggle='modal' data-target='.delete_modal' onclick=javascript:delete_table('admin/daftar_toko/delete') class='btn btn-warning'>Hapus</button>
									</div>
									<div class='input-group'>
										<input type='text' id='search' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search' onChange=javascript:search('#search','admin/daftar_toko/search') />
										<div class='input-group-btn'>
											<button class='btn btn-sm btn-default' onclick=javascript:search('#search','admin/daftar_toko/search')><i class='fa fa-search'></i></button>
										</div>
									</div>
								</div><br>
								<div id='div-paging'>
								<table class='table table-bordered table-striped'>
									<thead>	";
									echo "
										<tr>
											<th style='width: 10px'>
												<label>
													<input id='checkall' type='checkbox'>
												</label>
											</th>
											<th>No</th>
											<th>Nama Toko</th>
											<th>Email</th>
											<th>Account Status</th>
											<th>Berlaku s/d</th>
										</tr>
									</thead>
									<tbody>";
										 $i=0;
									if ($allToko->num_rows > 0) {
										foreach ($allToko->result() as $row) {
											$i++;
											$nama=ucwords($row->name);
										echo "
											<tr class='toko-".$row->id."'>
												<td>
													<label>
														<input class='checkboxDelete' type='checkbox' value='".$row->id."' >
													</label>
												</td>
												<td>$i</td>
												<td>".$nama."</td>
												<td>".$row->email."</td>
												<td>";
												if($row->status == 2){
													echo "<button class='btn btn-info btn-sm btn-toko-".$row->id."' data-toggle='modal' data-target='.box-toko_suspend".$row->id."' >Suspend</button>";
													echo "
														<div class='modal fade box-toko_suspend".$row->id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
															<div class='modal-dialog modal-sm'>
																<div class='modal-content'>
																	<div class='box box-solid box-danger'>
																		<div class='box-header'>
																			<h3 class='box-title'>Confirmation</h3>
																			<div class='box-tools pull-right'>
																				<button class='btn btn-danger btn-sm' class='close' data-dismiss='modal' aria-label='Close'><i class='fa fa-times'></i></button>
																			</div>
																		</div>
																		<div class='box-body body-delete' style='display: block;'>
																			<p>
																				Suspend Toko ".$nama."
																			</p>
																		</div><!-- /.box-body -->
																		<div class='box-footer'>
																			<button type='button' class='btn btn-danger tombol-ok".$row->id."' data-dismiss='modal' onclick=javascript:toko_suspend('".$row->id."')>Ok</button>
																			<button type='button' class='btn btn-danger delete-cancel' data-dismiss='modal'>Cancel</button>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														";
												
												}else if($row->status == 3) {
													echo "<button class='btn btn-danger btn-sm btn-toko-".$row->id."'  data-toggle='modal' data-target='.box-toko_unsuspend".$row->id."' >Unsuspend</button>";
													echo "<div class='modal fade box-toko_unsuspend".$row->id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
															<div class='modal-dialog modal-sm'>
																<div class='modal-content'>
																	<div class='box box-solid box-danger'>
																		<div class='box-header'>
																			<h3 class='box-title'>Confirmation</h3>
																			<div class='box-tools pull-right'>
																				<button class='btn btn-danger btn-sm' class='close' data-dismiss='modal' aria-label='Close'><i class='fa fa-times'></i></button>
																			</div>
																		</div>
																		<div class='box-body body-delete' style='display: block;'>
																			<p>
																				Aktifkan Toko ".$nama."
																			</p>
																		</div><!-- /.box-body -->
																		<div class='box-footer'>
																			<button type='button' class='btn btn-danger tombol-ok".$row->id."' data-dismiss='modal' onclick=javascript:toko_unsuspend('".$row->id."')>Ok</button>
																			<button type='button' class='btn btn-danger tombol-cancel' data-dismiss='modal'>Cancel</button>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														";
												}
												echo "
												</td>";
												$date_time=date('d F Y',strtotime($row->expired_on));
												echo"<td><a href='#' data-toggle='modal' data-target='.bs-example-modal-sm".$row->id."'> ".$date_time." </a> </td>
													<div class='modal fade bs-example-modal-sm".$row->id."' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
													  <div class='modal-dialog modal-sm'>
														<div class='modal-content'>
															<div class='box box-solid box-danger'>
																<div class='box-header'>
																	<h3 class='box-title'>Confirmation</h3>
																	<div class='box-tools pull-right'>
																		<button class='btn btn-danger btn-sm' data-widget='collapse'><i class='fa fa-minus'></i></button>
																		<button class='btn btn-danger btn-sm' class='close' data-dismiss='modal' aria-label='Close'><i class='fa fa-times'></i></button>
																	</div>
																</div>
																<div class='box-body' style='display: block;'>
																	Box class: <code>.box.box-solid.box-primary</code>
																	<p>
																	</p>
																</div><!-- /.box-body -->
																<div class='box-footer'>
																	<button type='submit' class='btn btn-danger'>Ok</button>
																	<button type='submit' class='btn btn-danger'>Cancel</button>
																</div>
															</div>
														</div>
													  </div>
													</div>
											</tr>";
											}
									}else{
										echo "<tr>
												<td colspan='6'>Zero</td>                                       
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
											<th>Nama Toko</th>
											<th>Email</th>
											<th>Account Status</th>
											<th>Berlaku s/d</th>
									</tfoot>
								</table>
							
							<div id='page' class='box-footer clearfix'>
								$pagination
							</div>
						</div>
					</div><!-- /.box-body -->
				</div><!-- /.box -->
				

			</section><!-- /.content -->
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->
	
	<!-- ./modal -->
		<div class='modal fade bs-example-modal-sm' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-sm'>
	<div class='modal-content'>
		<div class='box box-primary'>
			<div class='box-header'>
				<h3 class='box-title'>Ganti account status</h3>
			</div><!-- /.box-header -->
			<!-- form start -->
			<form role='form'>
				<div class='box-body'>
					<div class='form-group'>
						<label for='exampleInputEmail1'>Status</label>
						<select class='form-control'>
							<option>Active</option>
							<option>Nonactive</option>
						</select>
					</div>
					<div class='form-group'>
						<label for='exampleInputEmail1'>Berlaku s/d</label>
						<div class='input-group'>
							<div class='input-group-addon'>
								<i class='fa fa-calendar'></i>
							</div>
							<input type='text' class='form-control pull-right' id='tanggalindong'>
						</div>
					</div>
				</div><!-- /.box-body -->

				<div class='box-footer'>
					<button type='submit' class='btn btn-primary'>Submit</button>
					<button type='submit' class='btn btn-primary' data-dismiss='modal'>Cancel</button>
				</div>
			</form>
		</div><!-- /.box -->
	</div>
  </div>
</div>
		
		";
?>
