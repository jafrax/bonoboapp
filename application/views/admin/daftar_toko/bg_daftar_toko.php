<?php
echo "
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
                    <!-- Sidebar user panel -->
                    <div class='user-panel'>
                        <div class='pull-left image'>
                            <img src='img/avatar3.png' class='img-circle' alt='User Image' />
                        </div>
                        <div class='pull-left info'>
                            <p>Hello, Jane</p>

                            <a href='#'><i class='fa fa-circle text-success'></i> Online</a>
                        </div>
                    </div>
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
                        <li >
                            <a href=''>
                                <i class='fa fa-dashboard'></i> <span>DASHBOARD</span>
                            </a>
                        </li>
                        <li class='active'>
                            <a href='daftar_toko.html'>
                                <i class='fa fa-laptop'></i> <span>DAFTAR TOKO</span>
                            </a>
                        </li>
                        <li>
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
                                    <input type='text' name='table_search' class='form-control input-sm pull-right' style='width: 150px;' placeholder='Search'/>
                                    <div class='input-group-btn'>
                                        <button class='btn btn-sm btn-default'><i class='fa fa-search'></i></button>
                                    </div>
                                </div>
                            </div><br>
                            <table class='table table-bordered table-striped'>
                                <thead>
                                ";

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
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Nina</td>
                                        <td>nina@mail.com</td>
                                        <td><span class='label label-success'>Verified</span></td>
                                        <td><a href='#' data-toggle='modal' data-target='.bs-example-modal-sm'><span class='label label-success'>Active</span></button></td>
                                        <td>17 Juni 2014</td>
                                        <td>
                                            <button class='btn btn-warning btn-sm'>Hapus</button>
                                        </td>
                                    </tr>
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
                        <div class='box-footer clearfix'>
                            <ul class='pagination pagination-sm no-margin pull-right'>
                                <li><a href='#'>&laquo;</a></li>
                                <li><a href='#'>1</a></li>
                                <li><a href='#'>2</a></li>
                                <li><a href='#'>3</a></li>
                                <li><a href='#'>&raquo;</a></li>
                            </ul>
                        </div>
                    </div><!-- /.box -->
                    

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


        <script src='http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js'></script>
        <script src='".site_url("html/admin/js/jquery-ui-1.10.3.min.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/bootstrap.min.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/plugins/daterangepicker/daterangepicker.js")."' type='text/javascript'></script>
        <script src='".site_url("html/admin/js/AdminLTE/app.js' type='text/javascript")."'></script>
        ".$scjav."
    </body>
</html>";
?>