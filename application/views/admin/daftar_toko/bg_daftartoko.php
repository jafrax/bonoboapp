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
							<div id='div-paging'>
								<div class='box-body table-responsive'>
									<div class='box-tools'>
										<div class='input-group'>
											<input type='text' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search' onChange=javascript:search(this.id,'')/>
											<div class='input-group-btn'>
												<button class='btn btn-sm btn-default'><i class='fa fa-search'></i></button>
											</div>
										</div>
									</div><br>
									<table class='table table-bordered table-striped'>
										<thead>	";
										echo "
											<tr>
												<th>No</th>
												<th>Nama Toko</th>
												<th>Email</th>
												<th>Email Status</th>
												<th>Account Status</th>
												<th>Berlaku s/d</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>";
											 $i=0;
										if ($allToko->num_rows() == 0) {
											echo "<tr>
												<td>$i</td>
												<td>Data activation kosong</td>
												<td></td>
												<td></td>                                        
												<td></td>                                        
												<td></td>                                        
											</tr>";
										}
										foreach ($allToko->result() as $row) {
											$i++;
										echo "
											<tr>
												<td>$i</td>
												<td>".$row->name."</td>
												<td>".$row->email."</td>
												<td>";
												if($row->status == 2){
														echo "<span class='label label-success'>Verified</span>";
												}else{
														echo "<span class='label label-danger'>! Verified</span>";
												}
												echo"
												</td>
												<td><a href='#' data-toggle='modal' data-target='.bs-example-modal-sm'><span class='label label-success'>Active</span></button></td>";
												$date_time=date('d F Y',strtotime($row->expired_on));
												echo"<td><a herf='#' data-toggle='modal' data-target='.confirm'> ".$date_time." </a> </td>
												<td>
													<button class='btn btn-warning btn-sm'>Hapus</button>
												</td>
											</tr>";
											}
										echo "										
										</tbody>
										<tfoot>
											<tr>
												<th>No</th>
												<th>Nama Toko</th>
												<th>Email</th>
												<th>Email Status</th>
												<th>Account Status</th>
												<th>Berlaku s/d</th>
												<th>Action</th>
										</tfoot>
									</table>
								</div><!-- /.box-body -->
								<div id='page' class='box-footer clearfix'>
									$pagination
								</div>
						</div>
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

    <div class='modal fade confirm' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
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
    </div>";
	?>
	