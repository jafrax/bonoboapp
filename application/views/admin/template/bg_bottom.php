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


		<script>var base_url = '".base_url()."';</script>
		<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js'></script>
        <script src='".site_url("html/admin/js/jquery-ui-1.10.3.min.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/bootstrap.min.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/plugins/daterangepicker/daterangepicker.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/AdminLTE/app.js' type='text/javascript")."'></script>
        <script src='".site_url("html/admin/js/core.js' type='text/javascript")."'></script>
        <script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.validate.js")."'></script>
        <script type='text/javascript' src='".base_url("assets/jLib/jQuery/additional-methods.js")."'></script>
        <script src='".site_url("assets/jController/CtrlSystem.js' type='text/javascript")."'></script>

        ";
		if(!empty($scjav)){
		echo "<script src='".site_url($scjav)."' type='text/javascript'></script>";
		}
    echo "</body>
</html>";
?>