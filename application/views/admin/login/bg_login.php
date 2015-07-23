<?php 
echo "
    <!DOCTYPE html>
    <html class='bg-black'>
    <head>
        <meta charset='UTF-8'>
        <title>Bonobo || Admin</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href='".site_url("html/admin/css/bootstrap.min.css")."' rel='stylesheet' type='text/css' />
        <link href='".site_url("html/admin/css/font-awesome.min.css")."' rel='stylesheet' type='text/css' />
        <link href='".site_url("html/admin/css/AdminLTE.css")."' rel='stylesheet' type='text/css' />
    </head>
    <body class='bg-black'>
        <div class='form-box' id='login-box'>
            <div class='header'>Sign In</div>
            <form id='fsignin' method='post' action='".site_url("admin/index/signin")."'>
			<div id='lblNotif' class='notif-error'>".$this->session->flashdata('loginkata')."</div>
                <div class='body bg-gray'>
                    <div class='form-group'>
                        <input type='text' id='email' name='email' class='required form-control' placeholder='Email User' autocomplete='off' autofocus />
                    </div>
                    <div class='form-group'>
                        <input type='password' id='password' name='password' class='required form-control' placeholder='Password' autocomplete='off' autofocus />
                    </div>          
                </div>
                <div class='footer'>                                                               
                    <button type='submit' class='btn bg-olive btn-block'  onClick=javascript:valaid('fsignin') >Sign me in</button>                    
                    <p><a href='#'>I forgot my password</a></p>
                </div>
            </form>
        </div>
        <script type='text/javascript' src='".site_url("html/js/jquery-2.1.4.min.js")."'></script>
        <script type='text/javascript' src='".site_url("html/admin/js/bootstrap.min.js")."'></script>
        <script type='text/javascript' src='".base_url("assets/jLib/jQuery/jquery.validate.js")."'></script>
        <script type='text/javascript' src='".site_url("assets/jController/admin/CtrlIndex.js")."'></script>        
    </body>
    </html>";

?>