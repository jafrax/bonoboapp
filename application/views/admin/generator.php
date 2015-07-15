<?php
echo "
<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8'>
        <title>Administrator Bonobo | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href='".base_url()."html/admin/css/bootstrap.min.css' rel='stylesheet' type='text/css' />
        <!-- font Awesome -->
        <link href='".base_url()."html/admin/css/font-awesome.min.css' rel='stylesheet' type='text/css' />
        <!-- Ionicons -->
        <link href='".base_url()."html/admin/css/ionicons.min.css' rel='stylesheet' type='text/css' />
        <!-- DATA TABLES -->
        <link href='".base_url()."html/admin/css/datatables/dataTables.bootstrap.css' rel='stylesheet' type='text/css' />

        <!-- Theme style -->
        <link href='".base_url()."html/admin/css/AdminLTE.css' rel='stylesheet' type='text/css' />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
          <script src='https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js'></script>
        <![endif]-->
    </head>

    <div class='modal fade change' tabindex='-1' role='dialog' aria-labelledby='mySmallModalLabel' aria-hidden='true'>
        <div class='modal-dialog modal-sm'>
            <div class='modal-content'>
                <div class='box box-primary'>
                    <div class='box-header'>
                        <h3 class='box-title'>Change Password</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role='form'>
                        <div class='box-body'>
                            <div class='form-group'>
                                <label >Old password</label>
                                <input type='password' class='form-control' placeholder='Enter Old password'>
                            </div>
                            <div class='form-group'>
                                <label >New password</label>
                                <input type='password' class='form-control' placeholder='Enter New password'>
                            </div>
                            <div class='form-group'>
                                <label >Retype password</label>
                                <input type='password' class='form-control' placeholder='Enter Retype password'>
                            </div>
                        </div><!-- /.box-body -->

                        <div class='box-footer'>
                            <button type='submit' class='btn btn-primary'>Submit</button>
                            <button type='submit' class='btn btn-primary'>Cancel</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </div>

    <body class='skin-blue'>
        <!-- header logo: style can be found in header.less -->
        <header class='header'>
            <a href='index.html' class='logo'>
                <!-- Add the class icon to your logo image or logo icon to add the margining -->Bonobo
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class='navbar navbar-static-top' role='navigation'>
                <!-- Sidebar toggle button-->
                <a href='#' class='navbar-btn sidebar-toggle' data-toggle='offcanvas' role='button'>
                    <span class='sr-only'>Toggle navigation</span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                    <span class='icon-bar'></span>
                </a>
                <div class='navbar-right'>
                    <ul class='nav navbar-nav'>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class='dropdown user user-menu'>
                            <a href='#' class='dropdown-toggle' data-toggle='dropdown'>
                                <i class='glyphicon glyphicon-user'></i>
                                <span>Jane Doe <i class='caret'></i></span>
                            </a>
                            <ul class='dropdown-menu user-nav' role='menu'>
                                <li><a href='manage-admin.html'>Halaman admin</a></li>
                                <li><a href='#' data-toggle='modal' data-target='.change'>Change password</a></li>
                                <li><a href='#'>Logout</a></li>

                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class='wrapper row-offcanvas row-offcanvas-left'>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class='left-side sidebar-offcanvas'>
                <!-- sidebar: style can be found in sidebar.less -->
                <section class='sidebar'>
                    <!-- search form -->
                    <form action='#' method='get' class='sidebar-form'>
                        <div class='input-group'>
                            <input type='text' name='q' class='form-control' placeholder='Search...'/>
                            <span class='input-group-btn'>
                                <button type='submit' name='seach' id='search-btn' class='btn btn-flat'><i class='fa fa-search'></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class='sidebar-menu'>
                        <li class='active'>
                            <a href=''>
                                <i class='fa fa-dashboard'></i> <span>DASHBOARD</span>
                            </a>
                        </li>
                        <li >
                            <a href='daftar_toko.html'>
                                <i class='fa fa-laptop'></i> <span>DAFTAR TOKO</span>
                            </a>
                        </li>
                        <li >
                            <a href='daftar_pembeli.html'>
                                <i class='fa fa-shopping-cart'></i> <span>DAFTAR PEMBELI</span>
                            </a>
                        </li>
                        <li >
                            <a href='master_kategori.html'>
                                <i class='fa fa-list'></i> <span>MASTER KATEGORI</span>
                            </a>
                        </li>
                        <li>
                            <a href='master_lokasi.html'>
                                <i class='fa fa-map-marker'></i> <span>MASTER LOKASI</span>
                            </a>
                        </li>
                        <li>
                            <a href='master_bank.html'>
                                <i class='fa fa-credit-card'></i> <span>MASTER BANK</span>
                            </a>
                        </li>
                        <li>
                            <a href='master_kurir.html'>
                                <i class='fa fa-truck'></i> <span>MASTER KURIR</span>
                            </a>
                        </li>
                        <li class='treeview'>
                            <a href='#'>
                                <i class='fa fa-barcode'></i> <span>LICENSE PURCHASE</span>
                                <i class='fa fa-angle-left pull-right'></i>
                            </a>
                            <ul class='treeview-menu'>
                                <li><a href='licence_setting.html'><i class='fa fa-angle-double-right'></i> LICENSE SETTING</a></li>
                                <li><a href='licence_generator.html'><i class='fa fa-angle-double-right'></i> LICENSE GENERATOR</a></li>
                                <li><a href='licence_daftar.html'><i class='fa fa-angle-double-right'></i> LICENSE DAFTAR</a></li>
                            </ul>
                        </li>
                       
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class='right-side'>
                <!-- Content Header (Page header) -->
                <section class='content-header'>
                    <h1>
                        License Purchase
                    </h1>
                    <ol class='breadcrumb'>
                        <li><a href='#'><i class='fa fa-dashboard'></i> Dashboard</a></li>

                        <li class='active'>License Purchase</li>
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
                                <div class='col-xs-12 col-md-6'> 
                                    <div class='row form-group'>
                                        <div class='col-xs-12'>
                                            <label>Pilih Toko</label>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-6'>
                                            <select class='chosen-select form-control' id='toko'>
                                                <option>Pilih Toko</option>";
                                                foreach ($toko->result() as $row) {
                                                    echo "<option value='".$row->id."'>".$row->name." - ".$row->email."</option>";
                                                }
                                                echo"
                                            </select>
                                        </div>
                                        
                                    </div>
                                    <div class='row form-group'>
                                        <div class='nolpadright col-xs-12'>
                                            <label>Durasi</label>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-3'>
                                            <input type='text' class='form-control' placeholder='' id='durasi'>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-3'>
                                            <select class='form-control' id='durasi-tipe'>
                                                <option value='D'>Hari</option>
                                                <option value='M'>Bulan</option>
                                                <option value='Y'>Tahun</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='row form-group'>
                                        <div class='nolpadright col-xs-12'>
                                            <label>Kode</label>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-6'>
                                            <input type='text' class='form-control' placeholder='xxxx-xxxx-xxxx-xxxx' disabled>
                                        </div>
                                        <div class='padbottom col-xs-12 col-md-6'>
                                            <button type='submit' class='btn btn-primary'>Generate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class='box-footer clearfix'>
                            
                        </div>
                    </div><!-- /.box -->
                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <!-- jQuery 2.0.2 -->
        <script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js'></script>
        <!-- jQuery UI 1.10.3 -->
        <script src='".base_url()."html/admin/js/jquery-ui-1.10.3.min.js' type='text/javascript'></script>
        <!-- Bootstrap -->
        <script src='".base_url()."html/admin/js/bootstrap.min.js' type='text/javascript'></script>
         <!-- DATA TABES SCRIPT -->
        <script src='".base_url()."html/admin/js/plugins/datatables/jquery.dataTables.js' type='text/javascript'></script>
        <script src='".base_url()."html/admin/js/plugins/datatables/dataTables.bootstrap.js' type='text/javascript'></script>

        <!-- AdminLTE App -->
        <script src='".base_url()."html/admin/js/AdminLTE/app.js' type='text/javascript'></script>

        <!-- page script -->
        <script type='text/javascript'>
            $(function() {
               $('#example1').dataTable();
            });
        </script>

    </body>
</html>
";