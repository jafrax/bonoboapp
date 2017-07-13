<?php 
$url = "".site_url($this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3)."/".$this->uri->segment(4)."/".$this->uri->segment(5));

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
        <script>var base_url = '".base_url()."';</script>
    </head>
    <body class='bg-black'>
        <div class='form-box' id='login-box'>
            <div class='header'>Masukkan Password Baru</div>
            <form id='form-reset-password' >                
                <div class='body bg-gray'>
                    <div style='text-align:center;color:red;padding:10px 0'>
                        "; if (isset($_SESSION['login_error'])) echo $_SESSION['login_error']; unset($_SESSION['login_error']); echo"
                    </div>
                    <div class='form-group'>
                        <input type='password' id='newpass' name='newpass' maxlength='50' class='required form-control' placeholder='Password Baru' autocomplete='off' autofocus />
                    </div>
                    <div class='form-group'>
                        <input type='password' id='renewpass' name='renewpass' maxlength='50' class='required form-control' placeholder='Ulangi Password Baru' autocomplete='off' autofocus />
                    	<input type='hidden' id='email' name='email' value=".$this->uri->segment(4).">
                    </div>
                   
                </div>
                <div class='footer'>                                                               
                    <button type='button' class='btn bg-olive btn-block'  onclick=javascript:r_password('form-reset-password','admin/index/new_password','".$url."') >Reset Password</button>                    
                    
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