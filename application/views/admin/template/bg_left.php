		<?php
		echo"
	  <div class='wrapper row-offcanvas row-offcanvas-left'>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class='left-side sidebar-offcanvas'>
                <!-- sidebar: style can be found in sidebar.less -->
                <section class='sidebar'>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class='sidebar-menu'>
                        <li >
                            <a href='".base_url("admin/index/dashboard")."'>
                                <i class='fa fa-dashboard'></i> <span>DASHBOARD</span>
                            </a>
                        </li>
                        <li class='active'>
                            <a href='".base_url("admin/daftar_toko")."'>
                                <i class='fa fa-laptop'></i> <span>DAFTAR TOKO</span>
                            </a>
                        </li>
                        <li>
                            <a href='".base_url("admin/daftar_pembeli")."'>
                                <i class='fa fa-shopping-cart'></i> <span>DAFTAR PEMBELI</span>
                            </a>
                        </li>
                        <li >
                            <a href='".base_url("admin/master_kategori")."'>
                                <i class='fa fa-list'></i> <span>MASTER KATEGORI</span>
                            </a>
                        </li>
                        <li>
                            <a href='".base_url("admin/master_lokasi")."'>
                                <i class='fa fa-map-marker'></i> <span>MASTER LOKASI</span>
                            </a>
                        </li>
                        <li>
                            <a href='".base_url("admin/master_bank")."'>
                                <i class='fa fa-credit-card'></i> <span>MASTER BANK</span>
                            </a>
                        </li>
                        <li>
                            <a href='".base_url("admin/master_kurir")."'>
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
            </aside>";
			?>