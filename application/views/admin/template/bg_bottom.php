<?php
echo "	
		<div class='modal fade delete_modal' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
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
		<div class='modal fade change' id='change-password' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-sm'>
                <div class='modal-content'>
                    <div class='box box-primary'>
                        <div class='box-header'>
                            <h3 class='box-title'>Change Password</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role='form' id='form-change-password' >
                            <div class='box-body'>
                                <div class='form-group'>
                                    <label >Old password</label>
                                    <input type='password' name='oldpass' class='form-control' placeholder='Enter Old password' onkeypress='press_enter(event,\".form-change-password-btn\")'  autocomplete=off >
                                </div>
                                <div class='form-group'>
                                    <label >New password</label>
                                    <input type='password' name='newpass' id='newpass' class='form-control' placeholder='Enter New password' onkeypress='press_enter(event,\".form-change-password-btn\")'   >
                                </div>
                                <div class='form-group'>
                                    <label >Retype password</label>
                                    <input type='password' name='renewpass' class='form-control' placeholder='Enter Retype password' onkeypress='press_enter(event,\".form-change-password-btn\")'  >
                                </div>
                            </div><!-- /.box-body -->
    
                            <div class='box-footer'>
                                <button type='button' class='btn btn-primary form-change-password-btn' onclick=javascript:change_password('form-change-password','admin/account/change_password') >Submit</button>
                                <button type='button' class='btn btn-primary' data-dismiss='modal'>Cancel</button>
                            </div>
                        </form>
                    </div><!-- /.box -->
                </div>
            </div>
        </div>

		<script>var base_url = '".base_url()."';</script>
		<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js'></script>
		<script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.price_format.2.0.min.js")."'></script>
        <script src='".site_url("html/admin/js/jquery-ui-1.10.3.min.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/bootstrap.min.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/plugins/datepicker/bootstrap-datepicker.min.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/AdminLTE/app.js' type='text/javascript")."'></script>
        
        <script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.validate.js")."'></script>
        <script type='text/javascript' src='".base_url("assets/jLib/jQuery/additional-methods.js")."'></script>
        <script type='text/javascript' src='".base_url("html/js/chosen.jquery.js")."'></script>
		<script src=".base_url('assets/jLib/jQuery/jquery.price_format.2.0.min.js')." type='text/javascript'></script>
        <script src='".site_url("assets/jController/admin/globe.js' type='text/javascript")."'></script>
		<script src='".site_url("html/admin/js/core.js' type='text/javascript")."'></script>
        <script src='".site_url("assets/jController/CtrlSystem.js' type='text/javascript")."'></script>

        ";
		if(!empty($scjav)){
		echo "<script src='".site_url($scjav)."' type='text/javascript'></script>";
		}
    echo "</body>
</html>";
?>