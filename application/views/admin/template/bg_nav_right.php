        <?php
		echo"
		<body class='skin-blue'>
		<!-- header logo: style can be found in header.less -->
        <header class='header'>
            <a class='logo'>
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
                                <span>Hi, ".$_SESSION['bonobo_admin']->name."<i class='caret'></i></span>
                            </a>
                            <ul class='dropdown-menu user-nav' role='menu'>
                                <li><a href='".base_url('admin/account')."'>Halaman admin</a></li>
                                <li><a style='cursor:pointer' data-toggle='modal' data-target='#change-password' >Change password</a></li>
                                <li><a href='".base_url('admin/index/logout')."'>Logout</a></li>

                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>";
		?>
