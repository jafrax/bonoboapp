<?php
echo "
<!-- Right side column. Contains the navbar and content of the page -->
            <aside class='right-side'>
                <!-- Content Header (Page header) -->
                <section class='content-header'>
                    <h1>
                        Manage Admin
                    </h1>
                    <ol class='breadcrumb'>
                        <li><a href='".site_url('admin/index/dashboard')."'><i class='fa fa-dashboard'></i> Dashboard</a></li>

                        <li class='active'>Manage Admin</li>
                    </ol>
                </section>
    <!-- Main content -->
    <section class='content'>

        <div class='box'>
            <div class='box-header'>
                <h3 class='box-title'></h3>                                    
            </div><!-- /.box-header -->
            <div class='box-body table-responsive'>
                <div class='row'>
                    <div class='col-md-6'>
                        <div class=''>
                            <button class='btn btn-primary' onclick=javascript:new_data('box-form-account') >New account</button> 
                            <button class='btn btn-danger' data-toggle='modal' data-target='.delete_modal' onclick=javascript:delete_table('admin/account/delete') >Hapus</button> 
                        </div>
                        <br>
                        <div id='box-form-account' style='display:none'>
                            <!-- general form elements -->
                            <div class='box box-primary'>
                                <div class='box-header'>
                                    <h3 class='box-title'>New account</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form role='form' id='form-account'>
                                    <div class='box-body'>
                                        <div class='form-group'>
                                            <label for='exampleInputName'>Nama account</label>
                                            <input type='text' name='name' class='form-control' id='exampleInputName' placeholder='Enter nama account' onkeypress=javascript:key_enter(event,'form-account','admin/account/add') >
                                        </div>
                                        <div class='form-group'>
                                            <label for='exampleInputUsername1'>Email account</label>
                                            <input type='text' name='username' class='form-control' id='exampleInputUsername1' placeholder='Enter nama account' autocomplete=off onkeypress=javascript:key_enter(event,'form-account','admin/account/add') >
                                        </div>
                                        <div class='form-group'>
                                            <label for='exampleInputPassword1'>Password</label>
                                            <input type='password' name='password' class='form-control' id='exampleInputPassword1' placeholder='Password' onkeypress=javascript:key_enter(event,'form-account','admin/account/add') >
                                        </div>
                                        <div class='form-group'>
                                            <label for='exampleInputPassword2'>Retype Password</label>
                                            <input type='password' name='repassword' class='form-control' id='exampleInputPassword2' placeholder='Retype Password' onkeypress=javascript:key_enter(event,'form-account','admin/account/add') >
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class='box-footer'>
                                        <button type='button' class='btn btn-primary form-account-btn' onclick=javascript:submit_data('form-account','admin/account/add') >Submit</button>
                                        <button type='button' class='btn btn-primary' onclick=javascript:cancel_data('box-form-account') >Cancel</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->
                        </div>
                        
                    </div>
                </div>
                
                <div class='box-tools'>
                    <div class='input-group'>
						<input type='text' id='search' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search' onChange=javascript:search('#search','admin/account/search') />
						<div class='input-group-btn'>
							<button class='btn btn-sm btn-default' onclick=javascript:search('#search','admin/account/search')><i class='fa fa-search'></i></button>
						</div>
					</div>
                </div><br>
                
                <div id='div-paging'>
                    <table class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th style='width: 10px'>
                                    <input type='checkbox' id='checkall' >
                                </th>
                                <th>Nama Admin</th>
                                <th>Email Admin</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>";
                            if($Account->num_rows() >0){
                                foreach($Account->result() as $row){
                                    echo "
                                        <tr>
                                            <td>";
                                                if($_SESSION["bonobo_admin"]->id == $row->id || $row->id == 1){
                                                     
                                                }else{
                                                    echo "<input type='checkbox' class='checkboxDelete' value='".$row->id."'>";   
                                                }
                                                echo "
                                            </td>
                                            <td id='nama-".$row->id."' >".$row->name."</td>
                                            <td>".$row->email."</td>
                                            <td>";
                                                if($_SESSION["bonobo_admin"]->id == $row->id){
                                                    echo "<button class='btn btn-default btn-sm' >Reset password</button>";
                                                }else{
                                                    echo "<button class='btn btn-info btn-sm' onclick=javascript:account_reset_modal('".$row->id."','".base64_encode($row->name)."') >Reset password</button>";
                                                }
                                                echo "
                                                
                                                <button class='btn btn-info btn-sm' onClick=javascript:account_modal('".$row->id."') >Edit</button>
                                            </td>
                                        </tr>
                                    ";
                                }
                                
                            }else{
                                echo "<tr><td colspan='4'><center>Data is empty</center></td></tr>";
                            }
                            echo "
                            
                            
                        </tbody>
							<tfoot>
							<tr>
								<th style='width: 10px'>
									<input type='checkbox' id='checkall' >
								</th>
								<th>Nama Admin</th>
								<th>Email Admin</th>
								<th>Action</th>
							</tr>
						</tfoot>
                    </table>
                    <div class='box-footer clearfix'>
                        <div class='pagination pagination-sm no-margin pull-right'>
                            $pagination
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->      
        </div><!-- /.box -->
    </section><!-- /.content -->
  </aside><!-- /.right-side -->
</div><!-- ./wrapper -->
    
    <div class='modal fade bs-example-modal-sm' id='box-form-account-edit' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
      <div class='modal-dialog modal-sm'>
        <div class='modal-content'>
            <div class='box box-primary'>
                <div class='box-header'>
                    <h3 class='box-title'>Edit account</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role='form' id='form-account-edit'>
                    <div class='box-body'>
                        <div class='form-group'>
                            <label for='namaedit'>Nama account</label>
                            <input type='text' class='form-control' id='namaedit' name='namaedit' placeholder='Enter nama account' onkeypress='press_enter(event,\".form-account-edit-btn\")' >
                            <input type='hidden' name='idedit' id='idedit'/>
                        </div>
                    </div><!-- /.box-body -->
                        
                    <div class='box-footer'>
                        <button type='button' class='btn btn-primary form-account-edit-btn' onclick=javascript:submit_data_edit('form-account-edit','admin/account/edit') >Submit</button>
                        <button type='button' class='btn btn-primary' data-dismiss='modal' >Cancel</button>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
      </div>
    </div>
	
	<div class='modal fade box-form-account-edit' id='box-form-account-edit' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
      <div class='modal-dialog modal-sm'>
        <div class='modal-content'>
            <div class='box box-primary'>
                <div class='box-header'>
                    <h3 class='box-title'>Edit account</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form role='form' id='form-account-edit'>
                    <div class='box-body'>
                        <div class='form-group'>
                            <label for='namaedit'>Nama account</label>
                            <input type='text' class='form-control' id='namaedit' name='namaedit' placeholder='Enter nama account' onchange=javascript:submit_data_edit('form-account-edit','admin/account/edit') >
                            <input type='hidden' name='idedit' id='idedit'/>
                        </div>
                    </div><!-- /.box-body -->
                        
                    <div class='box-footer'>
                        <button type='button' class='btn btn-primary form-account-edit-btn' onclick=javascript:submit_data_edit('form-account-edit','admin/account/edit') >Submit</button>
                        <button type='button' class='btn btn-primary' data-dismiss='modal' >Cancel</button>
                    </div>
                </form>
            </div><!-- /.box -->
        </div>
      </div>
    </div>
	
	<div class='modal fade bs-example-modal-sm' id='delete-confirm' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
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
                                No selected data
                            </p>
                        </div><!-- /.box-body -->
                        <div class='box-footer'>
                            <button type='button' class='btn btn-danger delete-ok'>Ok</button>
                            <button type='button' class='btn btn-danger delete-cancel' data-dismiss='modal'>Cancel</button>
                        </div>
                    </div>
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
</div>
";
?>