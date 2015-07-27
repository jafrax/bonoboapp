<?php
echo "	<script>var base_url = '".base_url()."';</script>
		<script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js'></script>
        <script src='".site_url("html/admin/js/jquery-ui-1.10.3.min.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/bootstrap.min.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/plugins/daterangepicker/daterangepicker.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/AdminLTE/app.js' type='text/javascript")."'></script>
        <script src='".site_url("html/admin/js/core.js' type='text/javascript")."'></script>
        <script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.validate.js")."'></script>
        <script type='text/javascript' src='".base_url("assets/jLib/jQuery/additional-methods.js")."'></script>
        <script type='text/javascript' src='".base_url("html/js/chosen.jquery.js")."'></script>
        
        <script src='".site_url("assets/jController/CtrlSystem.js' type='text/javascript")."'></script>

        ";
		if(!empty($scjav)){
		echo "<script src='".site_url($scjav)."' type='text/javascript'></script>";
		}
    echo "</body>
</html>";
?>