        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">EasyBox Menu</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <!-- <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                -->
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" onclick="toggle_logout_div();" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown" id="userDropdown_div" style="display: none;">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" onclick="logout();" >Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="../index.html"><div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div>Info</a>
                            <?php if( $user_level_number == 1 ) echo '<a class="nav-link" href="../users.html"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Utilizatori</a>'; ?>
                            <?php if( $user_level_number > 1 )
                                    { 
                                        echo '<a class="nav-link" href="config.html"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Configurare</a>';
                                        echo '<a class="nav-link" href="config.html"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>Tech Info</a>';
                                    } ?>
                            
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.html">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                           
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        <?php echo $username; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active"><?php echo "Utilizator logat: ".$username." / Logat ultima oara in data de: ".$last_login_day." la ora: ".$last_login_hour." de pe ip-ul: ".$last_login_ip; ?></li>
                        </ol>
                        <div class="row">

                            <?php

                                    if( substr($path, 0, 11) == "admin_users" )
                                    {
                                        $status = 1;

                                        $response = get_users_details_with_return($_GET['page'],5);

                                        $response_arr = explode("/*/*/*/", $response);

                                        $pages_nr = intval( $response_arr[ count($response_arr) - 1 ] );

                                        echo "<table class='table table-sm table-hover table-responsive table-bordered'>";
                                        
                                        echo "<thead class='thead-dark'><tr>";
                                        echo "<th style='width:40%'>Utilizator</th>";
                                        echo "<th  style='width:40%'>Ultima logare</th>";
                                        echo "<th>Nivel</th>";
                                        echo "<th>Stare</th>";
                                        echo "<th>Editare</th>";
                                        echo "</tr></thead>";
                                        
                                        for ($i=0; $i < count($response_arr) - 1 ; $i++) { 
                                            
                                            $target_user_info = $response_arr[ $i ];
                                            $target_user_info = explode("<--->", $target_user_info);

                                            $target_username = $target_user_info[1];
                                            $target_last_login = $target_user_info[4];
                                            $target_status = $target_user_info[2];
                                            $target_level = $target_user_info[3];

                                            echo "<tr>";
                                            echo "<td style='vertical-align: middle;'>{$target_username}</td>";
                                            echo "<td style='vertical-align: middle;'>{$target_last_login}</td>";
                                            echo "<td style='vertical-align: middle;'>{$target_level}</td>";
                                            echo "<td style='vertical-align: middle;'>";
                                            if ($target_status == 1){echo '<img src="img/greenflag32.png">';}
                                            else { echo '<img src="img/cancel32.png">'; }          
                                            echo "</td>";
                                            echo "<td>";
                                            echo "<a href='' type='button' class='btn btn-sm1 btn-outline-info' onclick='load_user()' ><img src='img/edit_users32.png'></a>";
                                            echo "</td>";
                                            echo "</tr>";

                                        }

                                        echo "</table>";


                                        //pagination

                                        echo "<ul class=\"pagination margin-zero\">";
                                        for ($i=0; $i < $pages_nr; $i++) { 
                                            $curr_page = $i + 1;
                                            echo "<li class='page-item'><a class='page-link' href='admin_users.php?page=".$i."'>".$curr_page."</a></li>";
                                        }
                                        echo "</ul>";
                                        
                                    }
                                    else if( substr($path, 0, 10) == "config.php" )
                                    {
                                        
                                        echo '<div class="row">
                                            <button onclick=add_box("box_edit");>add box</button>
                                        </div>';
                                        echo '<div id="box_edit" class="col-md-12" style="margin-left:100px;height:500px;" onmousemove="check_boxes(event);update_mouse_position(event);" onkeydown="ctrl_is_pressed(event);" onkeyup="ctrl_is_not_pressed(event);">

                                            </div>';

                                    }
                                    

                                    /*
                                    echo "<tr>";
                                    echo "<td style='vertical-align: middle;'>{$username}</td>";
                                    echo "<td style='vertical-align: middle;'>{$username}</td>";
                                    echo "<td style='vertical-align: middle;'>{$username}</td>";
                                    echo "<td style='vertical-align: middle;'>";
                                    if ($status == '1'){echo '<img src="img/greenflag32.png">';}
                                    else { echo '<img src="img/cancel32.png">'; }          
                                    echo "</td>";
                                    echo "<td>";
                                    echo "<a href='admin_users_edit.php?action=edit&value=' type='button' class='btn btn-sm1 btn-outline-info' onclick='load_user()' ><img src='img/edit_users32.png'></a>";
                                    echo "</td>";
                                    echo "</tr>";

                                    echo "</table>"; */

                                    

                            ?>

                        </div>
                        <div class="row">

                            

                        </div>
                        <div class="card mb-4">
                            


                        </div>
                    </div>
                </main>
            

            </div>
        </div>
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/datatables-demo.js"></script>
        -->