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
            <div class='header'>Forgot Password</div>
            <form method='post' action=''>                
                <div class='body bg-gray'>
                    <div style='text-align:center;color:red;padding:10px 0'>
                        "; if (isset($_SESSION['login_error'])) echo $_SESSION['login_error']; unset($_SESSION['login_error']); echo"
                    </div>
                    <div class='form-group'>
                 Masukkan email anda 
                    </div>
                    <div class='form-group'>

                        <input type='text' id='email' name='email' class='required form-control' placeholder='Email User' autocomplete='off' autofocus />
                    </div>
                   
                </div>
                <div class='footer'>                                                               
                    <button type='submit' class='btn bg-olive btn-block'  onClick=javascript:valaid('fsignin') >Sign me in</button>                    
                    
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